<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $complaints = $request->user()
            ->complaints()
            ->with('room')
            ->latest()
            ->get();

        return view('client.reclamations.index', compact('complaints'));
    }

    public function create(Request $request): View
    {
        if (! $request->user()->room_id) {
            abort(403, 'Vous devez être assigné à une chambre pour déposer une réclamation.');
        }

        return view('client.reclamations.create', [
            'types' => Complaint::types(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->room_id) {
            return back()->withErrors([
                'room' => 'Vous devez être assigné à une chambre pour déposer une réclamation.',
            ]);
        }

        $validated = $request->validate([
            'type' => ['required', Rule::in(Complaint::types())],
            'description' => 'nullable|string|max:2000',
        ]);

        $priority = in_array($validated['type'], Complaint::typesUrgentsParDefaut(), true)
            ? 'urgente'
            : 'moyenne';

        Complaint::create([
            'user_id' => $user->id,
            'room_id' => $user->room_id,
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'priority' => $priority,
            'status' => 'ouverte',
        ]);

        return redirect()
            ->route('client.reclamations.index')
            ->with('success', 'Réclamation enregistrée avec succès.');
    }
}
