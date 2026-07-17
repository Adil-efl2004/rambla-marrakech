<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Service;
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

    public function create(): View
    {
        $rooms = Room::libres()->orderBy('number')->get();
        $services = Service::actifs()->orderBy('name')->get();

        return view('client.reservations.create', compact('rooms', 'services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:room,service',
            'reservable_id' => 'required|integer',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'nullable|date|after:start_datetime',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validated['type'] === 'room') {
            $reservable = Room::libres()->findOrFail($validated['reservable_id']);
            $reservableType = Room::class;

            $start = strtotime($validated['start_datetime']);
            $end = strtotime($validated['end_datetime'] ?? $validated['start_datetime']);
            $nights = max(1, (int) ceil(($end - $start) / 86400));
            $totalPrice = $reservable->price_per_night * $nights;
        } else {
            $reservable = Service::actifs()->findOrFail($validated['reservable_id']);
            $reservableType = Service::class;
            $totalPrice = $reservable->price;
        }

        Reservation::create([
            'user_id' => $request->user()->id,
            'reservable_type' => $reservableType,
            'reservable_id' => $reservable->id,
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'] ?? null,
            'status' => 'en_attente',
            'total_price' => $totalPrice,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('client.reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }
}
