<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function index(): View
    {
        $complaints = Complaint::with(['user', 'room', 'assignedTo'])
            ->orderByRaw("CASE WHEN priority = 'urgente' THEN 0 WHEN priority = 'moyenne' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->get();

        $techniciens = User::whereIn('role', ['technicien', 'admin'])
            ->orderBy('name')
            ->get();

        return view('admin.complaints.index', compact('complaints', 'techniciens'));
    }

    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
            'status' => ['required', Rule::in(['ouverte', 'en_cours', 'resolue'])],
        ]);

        if ($validated['status'] === 'resolue') {
            if (! empty($validated['assigned_to'])) {
                $complaint->update(['assigned_to' => $validated['assigned_to']]);
            }

            $complaint->marquerResolue();
        } else {
            $complaint->update([
                'assigned_to' => $validated['assigned_to'] ?? $complaint->assigned_to,
                'status' => $validated['status'],
            ]);
        }

        return back()->with('success', 'Réclamation mise à jour.');
    }
}
