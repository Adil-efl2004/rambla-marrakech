@php
    $firstName = str($user->name)->before(' ');

    $lummiImages = [
        'hero' => 'https://assets.lummi.ai/assets/QmQfwpNar7rJQWKTqyiTrU6WQvpokRaua9JU3DHmfsV9Js?auto=format&w=1920',
        'reservations' => 'https://assets.lummi.ai/assets/QmazgFd94WbsVuJ459V5ypjKebuZPjHefWDNfEQ552yTJj?auto=format&w=900',
        'roomService' => 'https://assets.lummi.ai/assets/QmRujw7Ya5vWhKy4M9KNk3kfquZDsrEDu4ngoCroYM5uEZ?auto=format&w=900',
        'reclamations' => 'https://assets.lummi.ai/assets/QmNnTGYEaVrzznwzdK1M1zp9UDQJyLPS2BF2SaiNtrB2oG?auto=format&w=900',
    ];

    $orderStatusLabels = [
        'recue' => 'Reçue',
        'en_preparation' => 'En préparation',
        'en_livraison' => 'En livraison',
    ];

    $complaintStatusLabels = [
        'ouverte' => 'Ouverte',
        'en_cours' => 'En cours',
    ];

    $complaintTypeLabels = [
        'climatisation' => 'Climatisation',
        'eau_chaude' => 'Eau chaude',
        'television' => 'Télévision',
        'wifi' => 'Wi-Fi',
        'plomberie' => 'Plomberie',
        'electricite' => 'Electricité',
        'autre' => 'Autre',
    ];
@endphp

<x-app-layout>
    <div class="pb-14">
        <section class="relative overflow-hidden bg-ink text-parchment">
            <img src="{{ $lummiImages['hero'] }}" alt="Terrasse méditerranéenne inspirée d'un riad" class="absolute inset-0 h-full w-full object-cover opacity-55" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/80 to-ink/25"></div>
            <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                <div class="max-w-3xl">
                    <p class="mb-4 text-sm font-semibold uppercase tracking-[0.25em] text-brass">Rambla Marrakech</p>
                    <h1 class="font-display text-4xl font-semibold leading-tight sm:text-6xl">
                        Bienvenue, {{ $firstName }}
                    </h1>
                    <p class="mt-5 text-lg text-parchment/85">
                        Chambre {{ $user->room?->number ?? 'non attribuée' }} · <span class="text-brass">Rambla Marrakech</span>
                    </p>
                </div>
            </div>
        </section>

        <section class="mx-auto -mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <a href="{{ route('client.reservations.index') }}"
                   class="group key-card overflow-hidden transition duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                    <img src="{{ $lummiImages['reservations'] }}" alt="Salon de suite minimaliste" class="h-48 w-full object-cover" loading="lazy">
                    <div class="p-6">
                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-brass/15 text-brass">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M4 11h16M5 6h14a1 1 0 011 1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a1 1 0 011-1z" />
                            </svg>
                        </span>
                        <h2 class="mt-6 text-2xl font-semibold text-ink">Réserver</h2>
                        <p class="mt-3 text-sm leading-6 text-stone">Chambre, service ou expérience, organisez votre séjour en quelques gestes.</p>
                    </div>
                </a>

                <a href="{{ route('client.room-service.index') }}"
                   class="group key-card overflow-hidden transition duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                    <img src="{{ $lummiImages['roomService'] }}" alt="Canopée balnéaire élégante" class="h-48 w-full object-cover" loading="lazy">
                    <div class="p-6">
                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-brass/15 text-brass">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 17h16M6 17a6 6 0 0112 0M12 7V5m-7 6l1.5 1.5M19 11l-1.5 1.5M8 21h8" />
                            </svg>
                        </span>
                        <h2 class="mt-6 text-2xl font-semibold text-ink">Room Service</h2>
                        <p class="mt-3 text-sm leading-6 text-stone">Commandez une assiette, un dessert ou une boisson depuis votre chambre.</p>
                    </div>
                </a>

                <a href="{{ route('client.reclamations.index') }}"
                   class="group key-card overflow-hidden transition duration-200 hover:-translate-y-1 hover:border-coral hover:shadow-lg">
                    <img src="{{ $lummiImages['reclamations'] }}" alt="Oreiller blanc minimaliste" class="h-48 w-full object-cover" loading="lazy">
                    <div class="p-6">
                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-coral/15 text-coral">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.7 6.3a4 4 0 01-5 5L5 16v3h3l4.7-4.7a4 4 0 005-5l-2.4 2.4-3-3 2.4-2.4z" />
                            </svg>
                        </span>
                        <h2 class="mt-6 text-2xl font-semibold text-ink">Signaler un problème</h2>
                        <p class="mt-3 text-sm leading-6 text-stone">Un détail à corriger dans la chambre ? L'équipe intervient rapidement.</p>
                    </div>
                </a>
            </div>
        </section>

        @if ($activeOrders->isNotEmpty() || $activeComplaints->isNotEmpty())
            <section class="mx-auto mt-12 grid max-w-7xl grid-cols-1 gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                @if ($activeOrders->isNotEmpty())
                    <div>
                        <h2 class="mb-4 text-2xl font-semibold text-ink">Vos commandes en cours</h2>
                        <div class="space-y-4">
                            @foreach ($activeOrders as $order)
                                <article class="key-card p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">Commande #{{ $order->id }}</p>
                                            <p class="mt-2 font-display text-2xl font-semibold text-brass">Chambre {{ $order->room?->number ?? $user->room?->number ?? 'N/A' }}</p>
                                        </div>
                                        <span class="status-badge status-pending">{{ $orderStatusLabels[$order->status] ?? $order->status }}</span>
                                    </div>
                                    <p class="mt-3 text-sm text-stone">
                                        {{ $order->items->take(2)->map(fn ($item) => $item->quantity.'x '.$item->menuItem?->name)->filter()->join(', ') }}
                                    </p>
                                    <p class="mt-3 text-sm font-semibold text-ink">Total : {{ \App\Support\Money::format($order->total_amount) }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($activeComplaints->isNotEmpty())
                    <div>
                        <h2 class="mb-4 text-2xl font-semibold text-ink">Vos réclamations actives</h2>
                        <div class="space-y-4">
                            @foreach ($activeComplaints as $complaint)
                                <article class="key-card p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">{{ $complaintTypeLabels[$complaint->type] ?? $complaint->type }}</p>
                                            <p class="mt-2 font-display text-2xl font-semibold text-brass">Chambre {{ $complaint->room?->number ?? $user->room?->number ?? 'N/A' }}</p>
                                        </div>
                                        <span class="status-badge {{ $complaint->priority === 'urgente' ? 'status-urgent' : 'status-neutral' }}">
                                            {{ $complaintStatusLabels[$complaint->status] ?? $complaint->status }}
                                        </span>
                                    </div>
                                    <p class="mt-3 text-sm text-stone">{{ $complaint->created_at->format('d/m/Y H:i') }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>
        @endif

        <footer class="mx-auto mt-14 max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <p class="font-display text-lg font-semibold text-ink">Rambla Marrakech</p>
            <p class="mt-1 text-sm text-stone">Hospitalité feutrée au coeur de Marrakech.</p>
        </footer>
    </div>
</x-app-layout>
