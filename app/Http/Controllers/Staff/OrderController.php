<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const NEXT_STATUS = [
        'recue' => 'en_preparation',
        'en_preparation' => 'en_livraison',
        'en_livraison' => 'livree',
    ];

    public function index(): View
    {
        $orders = Order::with(['user', 'room', 'items.menuItem'])
            ->whereNotIn('status', ['livree', 'annulee'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['recue', 'en_preparation', 'en_livraison', 'livree', 'annulee']),
            ],
        ]);

        $expectedNext = self::NEXT_STATUS[$order->status] ?? null;

        if ($validated['status'] !== $expectedNext) {
            return back()->withErrors([
                'status' => 'Transition de statut invalide.',
            ]);
        }

        $order->update([
            'status' => $validated['status'],
            'served_by' => $request->user()->id,
        ]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
