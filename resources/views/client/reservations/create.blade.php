@push('head-assets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* ── Flatpickr — thème Rambla ───────────────────────────────────────── */
        :root {
            --fp-brass:    #B8962E;   /* brass  */
            --fp-ink:      #1C1C1E;   /* ink    */
            --fp-parchment:#FAF7F2;   /* parchment */
            --fp-stone:    #6B7280;   /* stone  */
        }

        .flatpickr-calendar {
            background: var(--fp-parchment);
            border: 1px solid rgba(28,28,30,.12);
            border-radius: .75rem;
            box-shadow: 0 8px 32px rgba(28,28,30,.12);
            font-family: inherit;
        }
        .flatpickr-months { background: var(--fp-ink); border-radius: .75rem .75rem 0 0; }
        .flatpickr-months .flatpickr-month,
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year,
        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month { color: var(--fp-parchment) !important; fill: var(--fp-parchment) !important; }
        .flatpickr-months .flatpickr-prev-month:hover svg,
        .flatpickr-months .flatpickr-next-month:hover svg { fill: var(--fp-brass) !important; }

        .flatpickr-weekdays { background: var(--fp-ink); }
        span.flatpickr-weekday { background: var(--fp-ink); color: var(--fp-brass); font-weight: 600; font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; }

        .flatpickr-day { color: var(--fp-ink); border-radius: .5rem; }
        .flatpickr-day:hover { background: rgba(184,150,46,.15); border-color: transparent; }
        .flatpickr-day.today { border-color: var(--fp-brass); font-weight: 700; }
        .flatpickr-day.today:hover { background: rgba(184,150,46,.15); }
        .flatpickr-day.selected,
        .flatpickr-day.selected:hover { background: var(--fp-brass); border-color: var(--fp-brass); color: var(--fp-ink); font-weight: 700; }
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover {
            background: repeating-linear-gradient(135deg, transparent, transparent 4px, rgba(28,28,30,.06) 4px, rgba(28,28,30,.06) 5px);
            color: rgba(28,28,30,.3);
            border-color: transparent;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* Wrapper input Flatpickr — reprise du style projet */
        .fp-input-wrap { position: relative; }
        .fp-input-wrap input.flatpickr-input {
            display: block; width: 100%;
            border-radius: .5rem;
            border: 1px solid rgba(28,28,30,.2);
            background: #fff;
            padding: .75rem 2.5rem .75rem 1rem;
            font-size: .875rem; color: var(--fp-ink);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            cursor: pointer;
        }
        .fp-input-wrap input.flatpickr-input:focus {
            border-color: var(--fp-brass);
            box-shadow: 0 0 0 1px var(--fp-brass);
        }
        .fp-input-wrap input.flatpickr-input::placeholder { color: rgba(107,114,128,.6); }
        .fp-cal-icon {
            pointer-events: none; position: absolute; right: .75rem;
            top: 50%; transform: translateY(-50%);
            color: rgba(107,114,128,.5);
        }
    </style>
@endpush

<x-app-layout>
    {{-- ── Hero ── --}}
    <section class="bg-ink text-parchment">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Nouvelle réservation</p>
            <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Préparer votre prochain moment</h1>
            <p class="mt-4 max-w-2xl text-parchment/75">Choisissez une chambre libre ou un service, puis indiquez le créneau souhaité.</p>
        </div>
    </section>

    {{-- ── Contenu ── --}}
    <div class="bg-parchment py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('client.reservations.store') }}" class="space-y-8">
                @csrf

                {{-- ── Section 1 : Type de réservation ── --}}
                <div class="hotel-panel p-8">
                    <h2 class="font-display text-2xl font-semibold text-ink">Type de réservation</h2>
                    <p class="mt-1 text-sm text-stone">Sélectionnez ce que vous souhaitez réserver.</p>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Carte Chambre --}}
                        <label class="group relative cursor-pointer">
                            <input type="radio" name="type" value="room"
                                   class="sr-only peer"
                                   @checked(old('type', 'room') === 'room')>
                            <div class="flex items-start gap-4 rounded-lg border-2 border-ink/10 bg-white p-5
                                        transition-all duration-200
                                        hover:border-brass/50 hover:shadow-md
                                        peer-checked:border-brass peer-checked:bg-brass/5 peer-checked:shadow-md">
                                {{-- Icône lit --}}
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-ink/5
                                            transition-colors duration-200
                                            group-hover:bg-brass/10
                                            peer-checked:bg-brass/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone transition-colors duration-200 peer-checked:text-brass" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5M3 12v5h18v-5M7 12V9h10v3" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="block font-display text-xl font-semibold text-ink transition-colors duration-200
                                                 group-hover:text-brass peer-checked:text-brass">
                                        Chambre
                                    </span>
                                    <span class="mt-1 block text-sm text-stone">Réserver un espace pour votre séjour.</span>
                                </div>
                            </div>
                            {{-- Coche active --}}
                            <span class="pointer-events-none absolute right-4 top-4 hidden h-5 w-5 items-center justify-center rounded-full bg-brass peer-checked:flex">
                                <svg class="h-3 w-3 text-ink" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true">
                                    <path d="M10 3L5 8.5 2 5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </span>
                        </label>

                        {{-- Carte Service --}}
                        <label class="group relative cursor-pointer">
                            <input type="radio" name="type" value="service"
                                   class="sr-only peer"
                                   @checked(old('type') === 'service')>
                            <div class="flex items-start gap-4 rounded-lg border-2 border-ink/10 bg-white p-5
                                        transition-all duration-200
                                        hover:border-brass/50 hover:shadow-md
                                        peer-checked:border-brass peer-checked:bg-brass/5 peer-checked:shadow-md">
                                {{-- Icône cloche / service --}}
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-ink/5
                                            transition-colors duration-200
                                            group-hover:bg-brass/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="block font-display text-xl font-semibold text-ink transition-colors duration-200
                                                 group-hover:text-brass peer-checked:text-brass">
                                        Service
                                    </span>
                                    <span class="mt-1 block text-sm text-stone">Planifier une prestation de l'hôtel.</span>
                                </div>
                            </div>
                            {{-- Coche active --}}
                            <span class="pointer-events-none absolute right-4 top-4 hidden h-5 w-5 items-center justify-center rounded-full bg-brass peer-checked:flex">
                                <svg class="h-3 w-3 text-ink" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true">
                                    <path d="M10 3L5 8.5 2 5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </span>
                        </label>
                    </div>

                    <x-input-error :messages="$errors->get('type')" class="mt-3" />
                </div>

                {{-- ── Section 2 : Choix de la chambre ou du service ── --}}
                <div class="hotel-panel p-8">
                    <h2 class="font-display text-2xl font-semibold text-ink">Votre sélection</h2>
                    <p class="mt-1 text-sm text-stone">Choisissez parmi les disponibilités en cours.</p>

                    {{-- Select Chambre --}}
                    <div id="room-select" class="mt-6">
                        <label for="room_id" class="block text-sm font-semibold text-ink">Chambre disponible</label>
                        <div class="relative mt-2">
                            <select id="room_id" name="reservable_id"
                                    class="block w-full appearance-none rounded-lg border border-ink/20 bg-white
                                           py-3 pl-4 pr-10 text-sm text-ink shadow-none
                                           transition-colors duration-200
                                           focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
                                <option value="">— Sélectionner une chambre —</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                            @selected(old('reservable_id') == $room->id && old('type', 'room') === 'room'
                                                      || (!old('type') && $preselectedRoom == $room->id))>
                                        N° {{ $room->number }}
                                        — {{ ucfirst($room->type) }}
                                        @if ($room->surface_m2) · {{ $room->surface_m2 }} m² @endif
                                        @if ($room->capacity) · {{ $room->capacity }} pers. @endif
                                        ({{ \App\Support\Money::format($room->price_per_night) }}/nuit)
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-brass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        {{-- ── Prévisualisation chambre ── --}}
                        <div id="room-preview" class="mt-4 hidden overflow-hidden rounded-lg border border-brass/30 bg-white shadow-sm">
                            <div class="flex flex-col sm:flex-row">
                                {{-- Photo --}}
                                <div class="relative h-44 w-full shrink-0 overflow-hidden bg-ink/5 sm:h-auto sm:w-48">
                                    <img id="preview-photo" src="" alt=""
                                         class="h-full w-full object-cover">
                                    <div id="preview-no-photo"
                                         class="hidden absolute inset-0 flex items-center justify-center">
                                        <svg class="h-10 w-10 text-ink/20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v13.5a1.5 1.5 0 0 0 1.5 1.5z" />
                                        </svg>
                                    </div>
                                </div>
                                {{-- Infos --}}
                                <div class="flex flex-col justify-between p-5">
                                    <div>
                                        <p id="preview-title" class="font-display text-xl font-semibold text-brass"></p>
                                        <div class="mt-2 flex flex-wrap gap-4 text-sm text-stone">
                                            <span id="preview-surface" class="flex items-center gap-1">
                                                <svg class="h-3.5 w-3.5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                                </svg>
                                                <span id="preview-surface-val"></span>
                                            </span>
                                            <span id="preview-capacity" class="flex items-center gap-1">
                                                <svg class="h-3.5 w-3.5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                </svg>
                                                <span id="preview-capacity-val"></span>
                                            </span>
                                            <span id="preview-bed" class="flex items-center gap-1">
                                                <svg class="h-3.5 w-3.5 text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 12V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5M3 12v5h18v-5M7 12V9h10v3" />
                                                </svg>
                                                <span id="preview-bed-val"></span>
                                            </span>
                                        </div>
                                        <div id="preview-amenities" class="mt-3 flex flex-wrap gap-1.5"></div>
                                    </div>
                                    <a id="preview-link" href="#"
                                       class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brass transition-colors hover:text-ink">
                                        Voir la fiche complète →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Select Service --}}
                    <div id="service-select" class="mt-6 hidden">
                        <label for="service_id" class="block text-sm font-semibold text-ink">Service actif</label>
                        <div class="relative mt-2">
                            <select id="service_id"
                                    class="block w-full appearance-none rounded-lg border border-ink/20 bg-white
                                           py-3 pl-4 pr-10 text-sm text-ink shadow-none
                                           transition-colors duration-200
                                           focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass">
                                <option value="">— Sélectionner un service —</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                            @selected(old('reservable_id') == $service->id && old('type') === 'service')>
                                        {{ $service->name }} ({{ \App\Support\Money::format($service->price) }})
                                    </option>
                                @endforeach
                            </select>
                            {{-- Chevron brass custom --}}
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-brass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('reservable_id')" class="mt-3" />
                </div>

                {{-- ── Section 3 : Dates & Notes ── --}}
                <div class="hotel-panel p-8">
                    <h2 class="font-display text-2xl font-semibold text-ink">Créneau & détails</h2>
                    <p class="mt-1 text-sm text-stone">Précisez vos dates et toute demande particulière.</p>

                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- Date début --}}
                        <div>
                            <label for="start-date-picker" class="block text-sm font-semibold text-ink">
                                Date et heure d'arrivée
                            </label>
                            <div class="fp-input-wrap mt-2">
                                <input
                                    id="start-date-picker"
                                    name="start_datetime"
                                    type="text"
                                    value="{{ old('start_datetime') }}"
                                    placeholder="Sélectionner une date…"
                                    required
                                    autocomplete="off"
                                    readonly
                                >
                                <svg class="fp-cal-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <x-input-error :messages="$errors->get('start_datetime')" class="mt-2" />
                        </div>

                        {{-- Date fin --}}
                        <div>
                            <label for="end-date-picker" class="block text-sm font-semibold text-ink">
                                Date et heure de départ <span class="font-normal text-stone">(optionnel)</span>
                            </label>
                            <div class="fp-input-wrap mt-2">
                                <input
                                    id="end-date-picker"
                                    name="end_datetime"
                                    type="text"
                                    value="{{ old('end_datetime') }}"
                                    placeholder="Sélectionner une date…"
                                    autocomplete="off"
                                    readonly
                                >
                                <svg class="fp-cal-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <x-input-error :messages="$errors->get('end_datetime')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ── Bandeau disponibilité temps réel ── --}}
                    <div id="availability-banner" class="mt-5 hidden" role="status" aria-live="polite">
                        {{-- État : vérification en cours --}}
                        <div id="avail-checking"
                             class="hidden items-center gap-2 rounded-lg border border-ink/10 bg-white px-4 py-3 text-sm text-stone">
                            <svg class="h-4 w-4 animate-spin text-brass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                            Vérification de la disponibilité…
                        </div>
                        {{-- État : disponible --}}
                        <div id="avail-ok"
                             class="hidden items-center gap-2 rounded-lg border border-sage/30 bg-sage/10 px-4 py-3 text-sm font-semibold text-sage">
                            <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                            </svg>
                            Chambre disponible pour ces dates.
                        </div>
                        {{-- État : indisponible --}}
                        <div id="avail-ko"
                             class="hidden items-center gap-2 rounded-lg border border-coral/30 bg-coral/10 px-4 py-3 text-sm font-semibold text-coral">
                            <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Chambre indisponible pour ces dates. Choisissez d'autres dates ou une autre chambre.
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-semibold text-ink">
                            Notes <span class="font-normal text-stone">(optionnel)</span>
                        </label>
                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Demande particulière, heure d'arrivée, préférences…"
                            class="mt-2 block w-full rounded-lg border border-ink/20 bg-white
                                   px-4 py-3 text-sm text-ink placeholder-stone/50 shadow-none
                                   transition-colors duration-200
                                   focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass
                                   resize-none">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>

                {{-- ── Actions ── --}}
                <div class="flex flex-wrap items-center gap-4 pb-4">
                    <button
                        id="submit-btn"
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brass px-6 py-3.5
                               text-sm font-semibold uppercase tracking-widest text-ink
                               transition-colors duration-200
                               hover:bg-ink hover:text-parchment
                               focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2
                               disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-brass disabled:hover:text-ink"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                        Créer la réservation
                    </button>
                    <a href="{{ route('client.reservations.index') }}"
                       class="text-sm font-semibold text-stone transition-colors duration-200 hover:text-ink">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>

@push('body-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
    <script>
        // ── Données injectées par PHP ────────────────────────────────────────────
        const ROOMS_DATA         = @json($roomsJson);
        const ROOMS_BOOKED       = @json($roomsBookedRanges);   // { room_id: [{from, to}, ...] }
        const CHECK_URL          = '{{ route('client.reservations.check-availability') }}';

        const BED_LABELS = { simple:'Lit simple', double:'Lit double', queen:'Lit queen', king:'Lit king', twin:'Lits jumeaux' };

        // ── Éléments DOM ─────────────────────────────────────────────────────────
        const roomSelectEl      = document.getElementById('room_id');
        const submitBtn         = document.getElementById('submit-btn');
        const previewBox        = document.getElementById('room-preview');
        const previewPhoto      = document.getElementById('preview-photo');
        const previewNoPhoto    = document.getElementById('preview-no-photo');
        const previewTitle      = document.getElementById('preview-title');
        const previewSurface    = document.getElementById('preview-surface');
        const previewSurfaceV   = document.getElementById('preview-surface-val');
        const previewCapacityEl = document.getElementById('preview-capacity');
        const previewCapacityV  = document.getElementById('preview-capacity-val');
        const previewBedEl      = document.getElementById('preview-bed');
        const previewBedV       = document.getElementById('preview-bed-val');
        const previewAmenities  = document.getElementById('preview-amenities');
        const previewLink       = document.getElementById('preview-link');
        const availBanner       = document.getElementById('availability-banner');
        const availChecking     = document.getElementById('avail-checking');
        const availOk           = document.getElementById('avail-ok');
        const availKo           = document.getElementById('avail-ko');

        // ── Flatpickr — config de base ───────────────────────────────────────────
        const FP_COMMON = {
            locale:      'fr',
            enableTime:  true,
            time_24hr:   true,
            dateFormat:  'Y-m-d H:i',
            minuteIncrement: 30,
            minDate:     'today',
            disableMobile: true,
            disable:     [],
        };

        const fpStart = flatpickr('#start-date-picker', {
            ...FP_COMMON,
            placeholder: 'Date d\'arrivée…',
            onChange(selected) {
                // La date de départ ne peut pas être avant l'arrivée
                if (selected[0]) fpEnd.set('minDate', selected[0]);
                scheduleCheck();
            },
        });

        const fpEnd = flatpickr('#end-date-picker', {
            ...FP_COMMON,
            placeholder: 'Date de départ… (optionnel)',
            onChange() { scheduleCheck(); },
        });

        // ── Mise à jour des plages désactivées selon la chambre sélectionnée ─────
        function updateFlatpickrDisabled(roomId) {
            const ranges = (roomId && ROOMS_BOOKED[roomId]) ? ROOMS_BOOKED[roomId] : [];
            fpStart.set('disable', ranges);
            fpEnd.set('disable', ranges);
            // Reset les valeurs si la date sélectionnée tombe dans une plage bloquée
            fpStart.redraw();
            fpEnd.redraw();
        }

        // ── Disponibilité temps réel (fetch) ─────────────────────────────────────
        let debounceTimer = null;
        let lastFetchCtrl = null;

        function showAvailState(state) {
            availBanner.classList.toggle('hidden', state === 'hidden');
            availChecking.classList.toggle('hidden', state !== 'checking');
            availOk.classList.toggle('hidden',       state !== 'ok');
            availKo.classList.toggle('hidden',       state !== 'ko');
            [availChecking, availOk, availKo].forEach(el => {
                el.classList.toggle('flex', !el.classList.contains('hidden'));
            });
            submitBtn.disabled = (state === 'ko' || state === 'checking');
        }

        function checkAvailability() {
            const roomId = roomSelectEl.value;
            const start  = document.getElementById('start-date-picker').value;
            const end    = document.getElementById('end-date-picker').value;
            const type   = document.querySelector('input[name="type"]:checked')?.value;

            if (type !== 'room' || !roomId || !start) { showAvailState('hidden'); return; }

            if (lastFetchCtrl) lastFetchCtrl.abort();
            lastFetchCtrl = new AbortController();
            showAvailState('checking');

            const params = new URLSearchParams({ room_id: roomId, start });
            if (end) params.set('end', end);

            fetch(`${CHECK_URL}?${params}`, {
                signal: lastFetchCtrl.signal,
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(r => r.json())
            .then(data => showAvailState(data.available ? 'ok' : 'ko'))
            .catch(err => { if (err.name !== 'AbortError') showAvailState('hidden'); });
        }

        function scheduleCheck() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(checkAvailability, 400);
        }

        // ── Prévisualisation chambre ─────────────────────────────────────────────
        function updatePreview() {
            const id = roomSelectEl.value;
            if (!id || !ROOMS_DATA[id]) { previewBox.classList.add('hidden'); return; }
            const r = ROOMS_DATA[id];

            previewTitle.textContent = `Chambre N° ${r.number} — ${r.type.charAt(0).toUpperCase() + r.type.slice(1)}`;
            if (r.photo) {
                previewPhoto.src = r.photo; previewPhoto.alt = `Chambre ${r.number}`;
                previewPhoto.classList.remove('hidden'); previewNoPhoto.classList.add('hidden');
            } else {
                previewPhoto.classList.add('hidden'); previewNoPhoto.classList.remove('hidden');
            }
            if (r.surface_m2) { previewSurfaceV.textContent = r.surface_m2 + ' m²'; previewSurface.classList.remove('hidden'); }
            else previewSurface.classList.add('hidden');
            if (r.capacity) { previewCapacityV.textContent = r.capacity + ' pers.'; previewCapacityEl.classList.remove('hidden'); }
            else previewCapacityEl.classList.add('hidden');
            if (r.bed_type) { previewBedV.textContent = BED_LABELS[r.bed_type] ?? r.bed_type; previewBedEl.classList.remove('hidden'); }
            else previewBedEl.classList.add('hidden');

            previewAmenities.innerHTML = '';
            (r.amenities || []).forEach(a => {
                const s = document.createElement('span');
                s.className = 'rounded-full border border-brass/20 bg-brass/5 px-2.5 py-0.5 text-xs font-medium text-ink';
                s.textContent = a;
                previewAmenities.appendChild(s);
            });
            previewLink.href = r.show_url;
            previewBox.classList.remove('hidden');
        }

        // ── Listener : changement de chambre ─────────────────────────────────────
        roomSelectEl.addEventListener('change', () => {
            updatePreview();
            updateFlatpickrDisabled(roomSelectEl.value);
            // Reset les dates quand on change de chambre
            fpStart.clear(); fpEnd.clear();
            showAvailState('hidden');
        });

        // ── Toggle chambre / service ─────────────────────────────────────────────
        const typeInputs    = document.querySelectorAll('input[name="type"]');
        const roomSelect    = document.getElementById('room-select');
        const serviceSelect = document.getElementById('service-select');
        const roomInput     = document.getElementById('room_id');
        const serviceInput  = document.getElementById('service_id');

        function updateCardStyles() {
            typeInputs.forEach(input => {
                const card = input.closest('label').querySelector('div');
                card.classList.toggle('border-brass',  input.checked);
                card.classList.toggle('bg-brass/5',    input.checked);
                card.classList.toggle('shadow-md',     input.checked);
                card.classList.toggle('border-ink/10', !input.checked);
            });
        }

        function toggleReservable() {
            const isRoom = document.querySelector('input[name="type"]:checked')?.value === 'room';
            roomSelect.classList.toggle('hidden', !isRoom);
            serviceSelect.classList.toggle('hidden', isRoom);
            if (isRoom) {
                roomInput.name = 'reservable_id';   roomInput.required = true;
                serviceInput.name = '';              serviceInput.required = false;
            } else {
                serviceInput.name = 'reservable_id'; serviceInput.required = true;
                roomInput.name = '';                 roomInput.required = false;
                previewBox.classList.add('hidden');
                showAvailState('hidden');
            }
            updateCardStyles();
        }

        typeInputs.forEach(input => input.addEventListener('change', () => { toggleReservable(); scheduleCheck(); }));
        toggleReservable();

        // ── Restauration si old() présent (erreur de validation) ─────────────────
        if (roomSelectEl.value) {
            updatePreview();
            updateFlatpickrDisabled(roomSelectEl.value);
            scheduleCheck();
        }
    </script>
@endpush
</x-app-layout>
