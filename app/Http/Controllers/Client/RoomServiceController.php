<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomServiceController extends Controller
{
    public function index(): View
    {
        $menuByCategory = MenuItem::disponibles()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('client.room-service.index', compact('menuByCategory'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0|max:99',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        if (! $user->room_id) {
            return back()->withErrors([
                'room' => 'Vous devez être assigné à une chambre pour passer commande.',
            ]);
        }

        $hasItems = collect($validated['items'])->contains(fn ($qty) => (int) $qty > 0);

        if (! $hasItems) {
            return back()->withErrors([
                'items' => 'Veuillez sélectionner au moins un article.',
            ]);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'room_id' => $user->room_id,
            'status' => 'recue',
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $menuItemId => $quantity) {
            $quantity = (int) $quantity;

            if ($quantity <= 0) {
                continue;
            }

            $menuItem = MenuItem::disponibles()->find($menuItemId);

            if ($menuItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'unit_price' => $menuItem->price,
                ]);
            }
        }

        $order->recalculateTotal();

        return redirect()
            ->route('client.room-service.index')
            ->with('success', 'Votre commande a bien été envoyée au restaurant !');
    }
}
