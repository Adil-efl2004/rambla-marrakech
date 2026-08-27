<x-app-layout>
    {{-- ── Hero ── --}}
    <section class="bg-ink text-parchment">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Hébergement</p>
            <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Nos chambres</h1>
            <p class="mt-4 max-w-2xl text-parchment/75">
                Découvrez nos espaces disponibles et trouvez la chambre qui correspond à votre séjour.
            </p>
        </div>
    </section>

    <div class="bg-parchment py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- ── Filtre de dates ── --}}
            <form method="GET" action="{{ route('client.rooms.index') }}"
                  class="hotel-panel mb-10 p-6">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-40">
                        <label for="filter-start" class="block text-sm font-semibold text-ink">Arrivée</label>
                        <div class="relative mt-2">
                            <input id="filter-start" name="start" type="date"
                                   value="{{ $start ?? '' }}"
                                   class="block w-full rounded-lg border border-ink/20 bg-white
                                          py-3 pl-4 pr-10 text-sm text-ink
                                          transition-colors focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass
                                          [color-scheme:light]">
                        </div>
                    </div>
                    <div class="flex-1 min-w-40">
                        <label for="filter-end" class="block text-sm font-semibold text-ink">Départ</label>
                        <div class="relative mt-2">
                            <input id="filter-end" name="end" type="date"
                                   value="{{ $end ?? '' }}"
                                   class="block w-full rounded-lg border border-ink/20 bg-white
                                          py-3 pl-4 pr-10 text-sm text-ink
                                          transition-colors focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass
                                          [color-scheme:light]">
                        </div>
                    </div>
                    <button type="submit"
                            class="rounded-lg bg-brass px-5 py-3 text-sm font-semibold uppercase tracking-widest text-ink
                                   transition-colors hover:bg-ink hover:text-parchment
                                   focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-1">
                        Filtrer
                    </button>
                    @if ($hasFilter)
                        <a href="{{ route('client.rooms.index') }}"
                           class="text-sm font-semibold text-stone transition-colors hover:text-ink">
                            Réinitialiser
                        </a>
                    @endif
                </div>

                {{-- Résultat du filtre ou avertissement sans filtre --}}
                @if ($hasFilter)
                    <p class="mt-4 text-sm font-medium text-sage">
                        {{ $rooms->count() }} chambre{{ $rooms->count() > 1 ? 's' : '' }} disponible{{ $rooms->count() > 1 ? 's' : '' }}
                        du {{ \Carbon\Carbon::parse($start)->translatedFormat('d/m/Y') }}
                        au {{ \Carbon\Carbon::parse($end)->translatedFormat('d/m/Y') }}.
                    </p>
                @else
                    <p class="mt-4 flex items-center gap-2 text-sm text-stone">
                        <svg class="h-4 w-4 shrink-0 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Toutes les chambres à statut libre sont affichées. Entrez vos dates pour vérifier la disponibilité exacte.
                    </p>
                @endif
            </form>

            @php
                $typeLabels = ['simple' => 'Chambre Simple', 'double' => 'Chambre Double', 'suite' => 'Suite'];
                $bedLabels  = ['simple' => 'Lit simple', 'double' => 'Lit double', 'queen' => 'Lit queen', 'king' => 'Lit king', 'twin' => 'Lits jumeaux'];
                $grouped    = $rooms->groupBy('type');
                $typeOrder  = ['simple', 'double', 'suite'];
            @endphp

            @forelse ($typeOrder as $type)
                @php $group = $grouped->get($type, collect()); @endphp
                @if ($group->isNotEmpty())
                    <div class="mb-12">
                        <h2 class="mb-6 font-display text-3xl font-semibold text-ink">
                            {{ $typeLabels[$type] ?? ucfirst($type) }}
                        </h2>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($group as $room)
                                @php $cover = $room->photos->first(); @endphp
                                <a href="{{ route('client.rooms.show', $room) }}"
                                   class="key-card group overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-xl">

                                    {{-- Photo --}}
                                    <div class="relative h-52 overflow-hidden bg-ink/5">
                                        @if ($cover)
                                            <img src="{{ $cover->url }}"
                                                 alt="Chambre {{ $room->number }}"
                                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                 loading="lazy">
                                        @else
                                            <div class="flex h-full items-center justify-center">
                                                <svg class="h-12 w-12 text-ink/20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                        {{-- Badge numéro --}}
                                        <span class="absolute left-3 top-3 rounded-md bg-ink/70 px-2.5 py-1 text-xs font-semibold text-parchment backdrop-blur-sm">
                                            N° {{ $room->number }}
                                        </span>
                                    </div>

                                    {{-- Infos --}}
                                    <div class="p-5">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="font-display text-2xl font-semibold text-brass">
                                                    {{ \App\Support\Money::format($room->price_per_night) }}
                                                    <span class="text-base font-normal text-stone">/ nuit</span>
                                                </p>
                                                <p class="mt-1 text-sm text-stone">{{ $bedLabels[$room->bed_type] ?? $room->bed_type }}</p>
                                            </div>
                                        </div>

                                        {{-- Caractéristiques rapides --}}
                                        <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold text-stone">
                                            @if ($room->surface_m2)
                                                <span class="flex items-center gap-1">
                                                    <svg class="h-3.5 w-3.5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                                    </svg>
                                                    {{ $room->surface_m2 }} m²
                                                </span>
                                            @endif
                                            @if ($room->capacity)
                                                <span class="flex items-center gap-1">
                                                    <svg class="h-3.5 w-3.5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                    </svg>
                                                    {{ $room->capacity }} pers.
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Amenities (3 premiers) --}}
                                        @if (!empty($room->amenities))
                                            <div class="mt-3 flex flex-wrap gap-1.5">
                                                @foreach (array_slice($room->amenities, 0, 3) as $amenity)
                                                    <span class="rounded-full border border-ink/10 bg-parchment px-2.5 py-0.5 text-xs font-medium text-stone">
                                                        {{ $amenity }}
                                                    </span>
                                                @endforeach
                                                @if (count($room->amenities) > 3)
                                                    <span class="rounded-full border border-brass/20 bg-brass/5 px-2.5 py-0.5 text-xs font-medium text-brass">
                                                        +{{ count($room->amenities) - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- CTA --}}
                                        <div class="mt-5 flex items-center justify-between">
                                            <span class="text-sm font-semibold text-brass transition-colors duration-200 group-hover:text-ink">
                                                Voir la chambre →
                                            </span>
                                            <a href="{{ route('client.reservations.create', ['room' => $room->id]) }}"
                                               onclick="event.stopPropagation()"
                                               class="rounded-lg bg-brass px-4 py-2 text-xs font-semibold uppercase tracking-wide text-ink
                                                      transition-colors duration-200 hover:bg-ink hover:text-parchment">
                                                Réserver
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="hotel-panel p-12 text-center">
                    <p class="text-stone">Aucune chambre disponible pour le moment.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
