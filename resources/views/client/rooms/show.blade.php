@php
    $bedLabels = [
        'simple' => 'Lit simple',
        'double' => 'Lit double',
        'queen'  => 'Lit queen size',
        'king'   => 'Lit king size',
        'twin'   => 'Lits jumeaux',
    ];
    $typeLabels = ['simple' => 'Chambre Simple', 'double' => 'Chambre Double', 'suite' => 'Suite'];
    $photos     = $room->photos;
    $cover      = $photos->first();
    $secondary  = $photos->skip(1)->first();
@endphp

<x-app-layout>
    {{-- ── Hero ── --}}
    <section class="bg-ink text-parchment">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-sm text-parchment/60">
                <a href="{{ route('client.rooms.index') }}" class="transition-colors hover:text-brass">Chambres</a>
                <span>›</span>
                <span class="text-parchment">Chambre {{ $room->number }}</span>
            </div>
            <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">
                {{ $typeLabels[$room->type] ?? ucfirst($room->type) }} — N°&nbsp;{{ $room->number }}
            </h1>
            <p class="mt-3 text-parchment/70">
                Étage {{ $room->floor }} · {{ $bedLabels[$room->bed_type] ?? $room->bed_type }}
            </p>
        </div>
    </section>

    <div class="bg-parchment py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">

                {{-- ── Colonne gauche : galerie + description ── --}}
                <div class="space-y-8 lg:col-span-2">

                    {{-- Galerie --}}
                    <div class="hotel-panel overflow-hidden"
                         x-data="{ active: 0, photos: {{ $photos->pluck('url')->toJson() }} }">

                        {{-- Photo principale --}}
                        <div class="relative aspect-[16/9] overflow-hidden bg-ink/5">
                            <template x-for="(url, i) in photos" :key="i">
                                <img :src="url"
                                     :alt="'Photo ' + (i+1)"
                                     x-show="active === i"
                                     x-transition:enter="transition duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="absolute inset-0 h-full w-full object-cover"
                                     loading="lazy">
                            </template>

                            @if ($photos->isEmpty())
                                <div class="flex h-full items-center justify-center">
                                    <svg class="h-16 w-16 text-ink/20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Flèches navigation (si > 1 photo) --}}
                            @if ($photos->count() > 1)
                                <button @click="active = (active - 1 + photos.length) % photos.length"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center
                                               rounded-full bg-ink/50 text-parchment backdrop-blur-sm
                                               transition-colors hover:bg-ink/80 focus:outline-none"
                                        aria-label="Photo précédente">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                </button>
                                <button @click="active = (active + 1) % photos.length"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center
                                               rounded-full bg-ink/50 text-parchment backdrop-blur-sm
                                               transition-colors hover:bg-ink/80 focus:outline-none"
                                        aria-label="Photo suivante">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        {{-- Miniatures --}}
                        @if ($photos->count() > 1)
                            <div class="flex gap-3 p-4" x-data>
                                @foreach ($photos as $i => $photo)
                                    <button @click="active = {{ $i }}"
                                            :class="active === {{ $i }} ? 'ring-2 ring-brass ring-offset-1' : 'opacity-60 hover:opacity-100'"
                                            class="h-16 w-24 shrink-0 overflow-hidden rounded-md transition-all duration-200 focus:outline-none">
                                        <img src="{{ $photo->url }}" alt="Miniature {{ $i + 1 }}"
                                             class="h-full w-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Caractéristiques --}}
                    <div class="hotel-panel p-8">
                        <h2 class="font-display text-2xl font-semibold text-ink">Caractéristiques</h2>

                        <div class="mt-6 grid grid-cols-2 gap-6 sm:grid-cols-3">
                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brass/10">
                                    <svg class="h-5 w-5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-stone">Surface</p>
                                    <p class="mt-0.5 font-display text-xl font-semibold text-ink">{{ $room->surface_m2 ?? '—' }} m²</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brass/10">
                                    <svg class="h-5 w-5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-stone">Capacité</p>
                                    <p class="mt-0.5 font-display text-xl font-semibold text-ink">{{ $room->capacity ?? '—' }} pers.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brass/10">
                                    <svg class="h-5 w-5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5M3 12v5h18v-5M7 12V9h10v3" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-stone">Lit</p>
                                    <p class="mt-0.5 font-display text-xl font-semibold text-ink">{{ $bedLabels[$room->bed_type] ?? $room->bed_type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Équipements --}}
                    @if (!empty($room->amenities))
                        <div class="hotel-panel p-8">
                            <h2 class="font-display text-2xl font-semibold text-ink">Équipements</h2>
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($room->amenities as $amenity)
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-brass/20
                                                 bg-brass/5 px-3 py-1.5 text-sm font-medium text-ink">
                                        <svg class="h-3.5 w-3.5 text-brass" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true">
                                            <circle cx="6" cy="6" r="3"/>
                                        </svg>
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Description --}}
                    @if ($room->description)
                        <div class="hotel-panel p-8">
                            <h2 class="font-display text-2xl font-semibold text-ink">À propos de cette chambre</h2>
                            <p class="mt-4 leading-relaxed text-stone">{{ $room->description }}</p>
                        </div>
                    @endif
                </div>

                {{-- ── Colonne droite : prix + réservation ── --}}
                <div class="lg:sticky lg:top-6 lg:self-start">
                    <div class="hotel-panel p-7">
                        <p class="text-xs font-semibold uppercase tracking-wide text-stone">Tarif</p>
                        <p class="mt-2 font-display text-4xl font-semibold text-brass">
                            {{ \App\Support\Money::format($room->price_per_night) }}
                        </p>
                        <p class="text-sm text-stone">par nuit</p>

                        <div class="mt-6 space-y-3 border-t border-ink/10 pt-6 text-sm text-stone">
                            <div class="flex justify-between">
                                <span>Type</span>
                                <span class="font-semibold text-ink capitalize">{{ $typeLabels[$room->type] ?? $room->type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Étage</span>
                                <span class="font-semibold text-ink">{{ $room->floor }}</span>
                            </div>
                            @if ($room->surface_m2)
                                <div class="flex justify-between">
                                    <span>Surface</span>
                                    <span class="font-semibold text-ink">{{ $room->surface_m2 }} m²</span>
                                </div>
                            @endif
                            @if ($room->capacity)
                                <div class="flex justify-between">
                                    <span>Capacité</span>
                                    <span class="font-semibold text-ink">{{ $room->capacity }} personne{{ $room->capacity > 1 ? 's' : '' }}</span>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('client.reservations.create', ['room' => $room->id]) }}"
                           class="mt-7 flex w-full items-center justify-center gap-2 rounded-lg bg-brass
                                  px-6 py-3.5 text-sm font-semibold uppercase tracking-widest text-ink
                                  transition-colors duration-200 hover:bg-ink hover:text-parchment
                                  focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" />
                            </svg>
                            Réserver cette chambre
                        </a>

                        <a href="{{ route('client.rooms.index') }}"
                           class="mt-4 block text-center text-sm font-semibold text-stone transition-colors hover:text-ink">
                            ← Toutes les chambres
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
