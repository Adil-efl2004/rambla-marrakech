<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $reservations = $request->user()
            ->reservations()
            ->with('reservable')
            ->latest()
            ->get();

        return view('client.reservations.index', compact('reservations'));
    }

    public function create(Request $request): View
    {
        $rooms = Room::libres()
            ->with(['photos' => fn ($q) => $q->orderBy('position')])
            ->orderBy('number')
            ->get();
        $services = Service::actifs()->orderBy('name')->get();

        // Pré-sélection depuis ?room=id (lien "Réserver" sur la fiche chambre)
        $preselectedRoom = $request->query('room');

        // On encode les données chambre pour la prévisualisation JS
        $roomsJson = $rooms->map(fn ($r) => [
            'id'          => $r->id,
            'number'      => $r->number,
            'type'        => $r->type,
            'surface_m2'  => $r->surface_m2,
            'capacity'    => $r->capacity,
            'bed_type'    => $r->bed_type,
            'amenities'   => $r->amenities ?? [],
            'photo'       => $r->photos->first()?->url,
            'show_url'    => route('client.rooms.show', $r),
        ])->keyBy('id');

        // Plages déjà réservées par chambre pour Flatpickr (disable)
        $roomsBookedRanges = $rooms->mapWithKeys(fn ($r) => [
            $r->id => $r->reservations()
                ->whereIn('status', ['en_attente', 'confirmee'])
                ->get(['start_datetime', 'end_datetime'])
                ->map(fn ($res) => [
                    'from' => \Carbon\Carbon::parse($res->start_datetime)->format('Y-m-d'),
                    'to'   => \Carbon\Carbon::parse(
                        $res->end_datetime ?? \Carbon\Carbon::parse($res->start_datetime)->addDay()
                    )->format('Y-m-d'),
                ])
                ->values()
                ->all(),
        ]);

        return view('client.reservations.create', compact('rooms', 'services', 'roomsJson', 'roomsBookedRanges', 'preselectedRoom'));
    }

    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'start'   => 'required|date',
            'end'     => 'nullable|date|after:start',
        ]);

        $room      = Room::findOrFail($request->integer('room_id'));
        $available = $room->isAvailable($request->input('start'), $request->input('end'));

        return response()->json(['available' => $available]);
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        // Le client ne peut annuler que ses propres réservations
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if (! $reservation->isCancellableByClient()) {
            return back()->withErrors([
                'cancel' => 'Cette réservation ne peut plus être annulée. Pour toute demande, veuillez contacter directement la réception.',
            ]);
        }

        $reservation->update(['status' => 'annulee']);

        return redirect()
            ->route('client.reservations.index')
            ->with('success', 'Votre réservation a bien été annulée.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'           => 'required|in:room,service',
            'reservable_id'  => 'required|integer',
            'start_datetime' => 'required|date|after:now',
            'end_datetime'   => 'nullable|date|after:start_datetime',
            'notes'          => 'nullable|string|max:1000',
        ]);

        if ($validated['type'] === 'room') {
            $reservable = Room::libres()->findOrFail($validated['reservable_id']);
            $reservableType = Room::class;

            // ── Vérification des chevauchements ──────────────────────────────
            if (! $reservable->isAvailable($validated['start_datetime'], $validated['end_datetime'] ?? null)) {
                return back()
                    ->withInput()
                    ->withErrors(['reservable_id' => 'Cette chambre n\'est plus disponible pour ces dates. Merci de choisir d\'autres dates ou une autre chambre.']);
            }

            $start      = strtotime($validated['start_datetime']);
            $end        = strtotime($validated['end_datetime'] ?? $validated['start_datetime']);
            $nights     = max(1, (int) ceil(($end - $start) / 86400));
            $totalPrice = $reservable->price_per_night * $nights;
        } else {
            $reservable     = Service::actifs()->findOrFail($validated['reservable_id']);
            $reservableType = Service::class;
            $totalPrice     = $reservable->price;
        }

        Reservation::create([
            'user_id'          => $request->user()->id,
            'reservable_type'  => $reservableType,
            'reservable_id'    => $reservable->id,
            'start_datetime'   => $validated['start_datetime'],
            'end_datetime'     => $validated['end_datetime'] ?? null,
            'status'           => 'en_attente',
            'total_price'      => $totalPrice,
            'notes'            => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('client.reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }
}
