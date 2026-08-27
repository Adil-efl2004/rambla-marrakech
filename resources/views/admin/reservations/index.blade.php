@php
    $statusLabels = [
        'en_attente' => 'En attente',
        'confirmee'  => 'Confirmée',
        'annulee'    => 'Annulée',
        'terminee'   => 'Terminée',
    ];

    $statusClasses = [
        'en_attente' => 'status-pending',
        'confirmee'  => 'status-positive',
        'annulee'    => 'status-urgent',
        'terminee'   => 'status-neutral',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-2xl font-semibold leading-tight text-ink">
                Gestion des réservations
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="soft-link">
                ← Retour au tableau de bord
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-md border border-sage/20 bg-sage/10 p-4 text-sm text-sage">
                    {{ session('success') }}
                </div>
            @endif

            <div class="hotel-panel">
                <div class="p-6">

                    {{-- Compteur rapide --}}
                    @php
                        $enAttente = $reservations->where('status', 'en_attente')->count();
                    @endphp
                    @if ($enAttente > 0)
                        <div class="mb-6 flex items-center gap-3 rounded-lg border border-brass/25 bg-brass/8 px-4 py-3">
                            <svg class="h-4 w-4 shrink-0 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <p class="text-sm font-semibold text-ink">
                                {{ $enAttente }} réservation{{ $enAttente > 1 ? 's' : '' }} en attente de traitement
                            </p>
                        </div>
                    @endif

                    @if ($reservations->isEmpty())
                        <p class="text-stone">Aucune réservation enregistrée.</p>
                    @else
                        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                            @foreach ($reservations as $reservation)
                                @php
                                    $isRoom = $reservation->reservable_type === \App\Models\Room::class;
                                    $reservable = $reservation->reservable;
                                    $reservableLabel = $reservable
                                        ? ($isRoom
                                            ? 'Chambre '.$reservable->number.' — '.$reservable->type
                                            : $reservable->name)
                                        : 'Supprimé';
                                @endphp

                                <article class="key-card {{ $reservation->status === 'en_attente' ? 'border-brass/40' : '' }}">

                                    {{-- En-tête de la carte --}}
                                    <div class="flex flex-wrap items-start justify-between gap-4 p-5">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                                {{ $isRoom ? 'Séjour' : 'Service hôtelier' }}
                                                · {{ $reservation->user->name }}
                                            </p>
                                            <p class="mt-2 room-number">
                                                @if ($isRoom)
                                                    Ch. {{ $reservable?->number ?? '—' }}
                                                @else
                                                    {{ $reservable?->name ?? '—' }}
                                                @endif
                                            </p>
                                            <p class="mt-1 text-sm text-stone">{{ $reservation->user->email }}</p>
                                        </div>

                                        <span class="status-badge {{ $statusClasses[$reservation->status] ?? 'status-neutral' }}">
                                            {{ $statusLabels[$reservation->status] ?? $reservation->status }}
                                        </span>
                                    </div>

                                    {{-- Détails dates + prix --}}
                                    <div class="grid grid-cols-3 gap-4 border-t border-ink/10 px-5 py-4 text-sm">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">Arrivée</p>
                                            <p class="mt-1 font-medium text-ink">{{ $reservation->start_datetime->format('d/m/Y') }}</p>
                                            <p class="text-stone">{{ $reservation->start_datetime->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">Départ</p>
                                            <p class="mt-1 font-medium text-ink">{{ $reservation->end_datetime?->format('d/m/Y') ?? '—' }}</p>
                                            <p class="text-stone">{{ $reservation->end_datetime?->format('H:i') ?? '' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">Montant</p>
                                            <p class="mt-1 font-display text-xl font-semibold text-brass">
                                                {{ \App\Support\Money::format($reservation->total_price) }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="border-t border-ink/10 px-5 py-4">
                                        @if ($reservation->status === 'en_attente')
                                            <div class="flex flex-wrap gap-3">
                                                {{-- Confirmer --}}
                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmee">
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 rounded-lg bg-brass px-4 py-2
                                                                   text-sm font-semibold uppercase tracking-wide text-ink
                                                                   transition-colors duration-200 hover:bg-ink hover:text-parchment
                                                                   focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-1">
                                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        Confirmer
                                                    </button>
                                                </form>

                                                {{-- Annuler --}}
                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="annulee">
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 rounded-lg border border-ink/20 bg-white px-4 py-2
                                                                   text-sm font-semibold uppercase tracking-wide text-stone
                                                                   transition-colors duration-200 hover:border-coral/50 hover:bg-coral/5 hover:text-coral
                                                                   focus:outline-none focus:ring-2 focus:ring-coral/50 focus:ring-offset-1">
                                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                        </svg>
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif ($reservation->status === 'confirmee')
                                            {{-- Seule action restante : annuler une confirmée --}}
                                            <div class="flex flex-wrap items-center gap-3">
                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="annulee">
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 rounded-lg border border-ink/20 bg-white px-4 py-2
                                                                   text-sm font-semibold uppercase tracking-wide text-stone
                                                                   transition-colors duration-200 hover:border-coral/50 hover:bg-coral/5 hover:text-coral
                                                                   focus:outline-none focus:ring-2 focus:ring-coral/50 focus:ring-offset-1">
                                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                        </svg>
                                                        Annuler la réservation
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-sm text-stone">
                                                @if ($reservation->status === 'annulee')
                                                    Annulée le {{ $reservation->updated_at->format('d/m/Y à H:i') }}
                                                @else
                                                    Séjour terminé le {{ $reservation->updated_at->format('d/m/Y') }}
                                                @endif
                                            </span>
                                        @endif
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
