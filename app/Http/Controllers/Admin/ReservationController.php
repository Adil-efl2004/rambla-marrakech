<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::with(['user', 'reservable'])
            ->orderByRaw("CASE WHEN status = 'en_attente' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['confirmee', 'annulee'])],
        ]);

        $reservation->update(['status' => $validated['status']]);

        $label = $validated['status'] === 'confirmee' ? 'confirmée' : 'annulée';

        return back()->with('success', "Réservation #{$reservation->id} {$label}.");
    }
}
