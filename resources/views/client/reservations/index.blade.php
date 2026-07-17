@php
    $statusClasses = [
        'en_attente' => 'status-pending',
        'confirmee' => 'status-positive',
        'annulee' => 'status-urgent',
        'terminee' => 'status-neutral',
    ];
@endphp

<x-app-layout>
    <section class="bg-ink text-parchment">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Conciergerie</p>
                <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Vos réservations</h1>
                <p class="mt-4 max-w-2xl text-parchment/75">Retrouvez vos chambres et services réservés auprès de Rambla Marrakech.</p>
            </div>
            <a href="{{ route('client.reservations.create') }}"
               class="inline-flex items-center justify-center rounded-md bg-brass px-5 py-3 text-sm font-semibold text-ink transition-colors duration-200 hover:bg-parchment">
                Nouvelle réservation
            </a>
        </div>
    </section>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md border border-sage/20 bg-sage/10 p-4 text-sage">
                    {{ session('success') }}
                </div>
            @endif

            @if ($reservations->isNotEmpty())
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @foreach ($reservations as $reservation)
                        @php
                            $isRoom = $reservation->reservable_type === \App\Models\Room::class;
                            $reservableLabel = $reservation->reservable
                                ? ($reservation->reservable->name ?? 'Chambre '.$reservation->reservable->number)
                                : 'Non disponible';
                        @endphp

                        <article class="key-card transition duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                            <div class="p-6">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                            {{ $isRoom ? 'Séjour' : 'Service hôtelier' }}
                                        </p>
                                        <p class="mt-3 room-number">
                                            {{ $isRoom ? 'Chambre '.$reservation->reservable?->number : 'Service' }}
                                        </p>
                                        <p class="mt-3 text-sm text-stone">{{ $reservableLabel }}</p>
                                    </div>

                                    <span class="status-badge {{ $statusClasses[$reservation->status] ?? 'status-neutral' }}">
                                        {{ str_replace('_', ' ', $reservation->status) }}
                                    </span>
                                </div>

                                <div class="mt-6 grid gap-4 border-t border-ink/10 pt-5 text-sm text-ink sm:grid-cols-3">
                                    <div>
                                        <p class="font-semibold text-stone">Arrivée</p>
                                        <p>{{ $reservation->start_datetime->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-stone">Départ</p>
                                        <p>{{ $reservation->end_datetime?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-stone">Montant</p>
                                        <p class="font-semibold text-brass">{{ \App\Support\Money::format($reservation->total_price) }}</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
