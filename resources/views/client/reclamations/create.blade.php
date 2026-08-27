@php
    $typeLabels = [
        'climatisation' => 'Climatisation',
        'eau_chaude'    => 'Eau chaude',
        'television'    => 'Télévision',
        'wifi'          => 'Wi-Fi',
        'plomberie'     => 'Plomberie',
        'electricite'   => 'Électricité',
        'autre'         => 'Autre',
    ];

    $typeIcons = [
        'climatisation' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z" />',
        'eau_chaude'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18z" />',
        'television'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z" />',
        'wifi'          => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0z" />',
        'plomberie'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z" />',
        'electricite'   => '<path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />',
        'autre'         => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 5.25h.008v.008H12v-.008z" />',
    ];
@endphp

<x-app-layout>
    {{-- ── Hero ── --}}
    <section class="bg-ink text-parchment">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Assistance</p>
            <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Signaler un problème</h1>
            <p class="mt-4 max-w-2xl text-parchment/75">Notre équipe technique prend en charge votre réclamation dans les plus brefs délais.</p>
        </div>
    </section>

    <div class="bg-parchment py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('client.reclamations.store') }}" class="space-y-8">
                @csrf

                {{-- ── Section 1 : Type de problème ── --}}
                <div class="hotel-panel p-8">
                    <h2 class="font-display text-2xl font-semibold text-ink">Type de problème</h2>
                    <p class="mt-1 text-sm text-stone">Sélectionnez la catégorie qui correspond à votre situation.</p>

                    <div class="mt-6">
                        <div class="relative">
                            <select id="type" name="type"
                                    class="block w-full appearance-none rounded-lg border border-ink/20 bg-white
                                           py-3 pl-4 pr-10 text-sm text-ink shadow-none
                                           transition-colors duration-200
                                           focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass"
                                    required>
                                <option value="">— Sélectionner un type —</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @selected(old('type') === $type)>
                                        {{ $typeLabels[$type] ?? $type }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-brass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                </div>

                {{-- ── Section 2 : Description ── --}}
                <div class="hotel-panel p-8">
                    <h2 class="font-display text-2xl font-semibold text-ink">Description</h2>
                    <p class="mt-1 text-sm text-stone">Décrivez le problème avec le plus de détails possible.</p>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-semibold text-ink">
                            Votre description
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Ex : La climatisation ne fonctionne plus depuis ce matin, la chambre est à 30°C…"
                            class="mt-2 block w-full rounded-lg border border-ink/20 bg-white
                                   px-4 py-3 text-sm text-ink placeholder-stone/50 shadow-none
                                   transition-colors duration-200
                                   focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass
                                   resize-none">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Note priorité --}}
                    <div class="mt-5 flex items-start gap-3 rounded-lg border border-coral/20 bg-coral/8 px-4 py-3">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-coral" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="text-sm text-ink">
                            Les problèmes de <strong>climatisation, eau chaude, plomberie et électricité</strong> sont traités en priorité urgente.
                        </p>
                    </div>
                </div>

                {{-- ── Actions ── --}}
                <div class="flex flex-wrap items-center gap-4 pb-4">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-coral px-6 py-3.5
                               text-sm font-semibold uppercase tracking-widest text-ink
                               transition-colors duration-200
                               hover:bg-ink hover:text-parchment
                               focus:outline-none focus:ring-2 focus:ring-coral focus:ring-offset-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12zm0 0h7.5" />
                        </svg>
                        Envoyer la réclamation
                    </button>
                    <a href="{{ route('client.reclamations.index') }}"
                       class="text-sm font-semibold text-stone transition-colors duration-200 hover:text-ink">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
