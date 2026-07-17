@php
    $statusLabels = [
        'recue' => 'Reçue',
        'en_preparation' => 'En préparation',
        'en_livraison' => 'En livraison',
        'livree' => 'Livrée',
        'annulee' => 'Annulée',
    ];

    $statusClasses = [
        'recue' => 'status-pending',
        'en_preparation' => 'status-pending',
        'en_livraison' => 'status-neutral',
        'livree' => 'status-positive',
        'annulee' => 'status-urgent',
    ];

    $nextStatus = [
        'recue' => 'en_preparation',
        'en_preparation' => 'en_livraison',
        'en_livraison' => 'livree',
    ];

    $nextStatusLabels = [
        'en_preparation' => 'Passer en préparation',
        'en_livraison' => 'Passer en livraison',
        'livree' => 'Marquer livrée',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-ink">
            Commandes en cours
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-sage/20 bg-sage/10 p-4 text-sage">
                    {{ session('success') }}
                </div>
            @endif

            <x-input-error :messages="$errors->get('status')" class="mb-4" />

            <div class="hotel-panel">
                <div class="p-6">
                    @if ($orders->isEmpty())
                        <p class="text-stone">Aucune commande en cours.</p>
                    @else
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            @foreach ($orders as $order)
                                <article class="key-card">
                                    <div class="flex flex-wrap items-start justify-between gap-4 p-5">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                                Commande #{{ $order->id }}
                                            </p>
                                            <p class="mt-2 room-number">
                                                Chambre {{ $order->room?->number ?? 'N/A' }}
                                            </p>
                                            <p class="mt-2 text-sm text-stone">
                                                {{ $order->user?->name ?? 'N/A' }} · {{ $order->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>

                                        <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-neutral' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </div>

                                    <div class="border-t border-ink/10 px-5 py-4">
                                        <ul class="space-y-2 text-sm text-ink">
                                            @foreach ($order->items as $item)
                                                <li class="flex items-center justify-between gap-4">
                                                    <span>{{ $item->menuItem?->name ?? 'Article inconnu' }}</span>
                                                    <span class="font-semibold text-stone">x {{ $item->quantity }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                                            <p class="text-sm font-semibold text-ink">
                                                Total : {{ \App\Support\Money::format($order->total_amount) }}
                                            </p>

                                            @if (isset($nextStatus[$order->status]))
                                                <form method="POST" action="{{ route('staff.orders.update', $order) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ $nextStatus[$order->status] }}">
                                                    <x-primary-button>
                                                        {{ $nextStatusLabels[$nextStatus[$order->status]] }}
                                                    </x-primary-button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
