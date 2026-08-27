@php
    $statusClasses = [
        'en_attente' => 'status-pending',
        'confirmee'  => 'status-positive',
        'annulee'    => 'status-urgent',
        'terminee'   => 'status-neutral',
    ];
    $statusLabels = [
        'en_attente' => 'En attente',
        'confirmee'  => 'Confirmée',
        'annulee'    => 'Annulée',
        'terminee'   => 'Terminée',
    ];
@endphp

<x-app-layout>
    {{-- ── Hero ── --}}
    <section class="bg-ink text-parchment">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Conciergerie</p>
                <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Vos réservations</h1>
                <p class="mt-4 max-w-2xl text-parchment/75">Retrouvez vos chambres et services réservés auprès de Rambla Marrakech.</p>
            </div>
            <a href="{{ route('client.reservations.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brass px-5 py-3
                      text-sm font-semibold uppercase tracking-widest text-ink
                      transition-colors duration-200 hover:bg-parchment hover:text-ink
                      focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2 focus:ring-offset-ink">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nouvelle réservation
            </a>
        </div>
    </section>

    <div class="bg-parchment py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-8 flex items-start gap-3 rounded-lg border border-sage/25 bg-sage/10 px-5 py-4 text-sm font-medium text-sage">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @error('cancel')
                <div class="mb-8 flex items-start gap-3 rounded-lg border border-coral/25 bg-coral/10 px-5 py-4 text-sm font-medium text-coral">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror

            @if ($reservations->isEmpty())
                {{-- État vide --}}
                <div class="hotel-panel p-12 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brass/10">
                        <svg class="h-8 w-8 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-display text-xl font-semibold text-ink">Aucune réservation</h3>
                    <p class="mt-2 text-sm text-stone">Vous n'avez pas encore effectué de réservation.</p>
                    <a href="{{ route('client.reservations.create') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-lg bg-brass px-5 py-2.5
                              text-sm font-semibold uppercase tracking-widest text-ink
                              transition-colors duration-200 hover:bg-ink hover:text-parchment">
                        Faire une réservation
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @foreach ($reservations as $reservation)
                        @php
                            $isRoom = $reservation->reservable_type === \App\Models\Room::class;
                            $reservableLabel = $reservation->reservable
                                ? ($reservation->reservable->name ?? 'Chambre '.$reservation->reservable->number)
                                : 'Non disponible';
                        @endphp
                        <article class="key-card transition-all duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                            <div class="p-6">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        {{-- Icône type --}}
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brass/10">
                                            @if ($isRoom)
                                                <svg class="h-5 w-5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5M3 12v5h18v-5M7 12V9h10v3" />
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                                {{ $isRoom ? 'Séjour' : 'Service hôtelier' }}
                                            </p>
                                            <p class="mt-1 font-display text-3xl font-semibold leading-none text-brass">
                                                {{ $isRoom ? 'Ch. '.$reservation->reservable?->number : 'Svc' }}
                                            </p>
                                            <p class="mt-1 text-sm text-stone">{{ $reservableLabel }}</p>
                                        </div>
                                    </div>
                                    <span class="status-badge {{ $statusClasses[$reservation->status] ?? 'status-neutral' }}">
                                        {{ $statusLabels[$reservation->status] ?? str_replace('_', ' ', $reservation->status) }}
                                    </span>
                                </div>

                                <div class="mt-5 grid gap-4 border-t border-ink/10 pt-5 text-sm sm:grid-cols-3">
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

                                {{-- ── Action annulation ── --}}
                                @if (in_array($reservation->status, ['en_attente', 'confirmee']))
                                    <div class="mt-4 border-t border-ink/10 pt-4">
                                        @if ($reservation->isCancellableByClient())
                                            <form
                                                method="POST"
                                                action="{{ route('client.reservations.cancel', $reservation) }}"
                                                onsubmit="return confirm('Confirmer l\'annulation de cette réservation ? Cette action est irréversible.')"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-coral/40 bg-transparent
                                                           px-4 py-2 text-xs font-semibold uppercase tracking-wide text-coral
                                                           transition-colors duration-200
                                                           hover:border-coral hover:bg-coral/5
                                                           focus:outline-none focus:ring-2 focus:ring-coral/50 focus:ring-offset-1"
                                                >
                                                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                    Annuler la réservation
                                                </button>
                                            </form>
                                        @else
                                            <p class="flex items-center gap-1.5 text-xs text-stone/70">
                                                <svg class="h-3.5 w-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25z" />
                                                </svg>
                                                Annulation impossible à moins de {{ \App\Models\Reservation::CANCELLATION_DEADLINE_HOURS }}h de l'arrivée — contactez la réception
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
