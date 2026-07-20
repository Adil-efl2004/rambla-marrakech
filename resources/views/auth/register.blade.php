<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Créer un compte — {{ config('app.name', 'Rambla Marrakech') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-ink antialiased">

<div class="grid min-h-screen md:grid-cols-2">

    {{-- ── LEFT COLUMN : image immersive (masquée sur mobile) ── --}}
    <div class="relative hidden md:block">
        {{-- Image de fond : patio marocain de luxe, Marrakech (Pexels #6634469 — libre de droits) --}}
        <img
            src="https://images.pexels.com/photos/6634469/pexels-photo-6634469.jpeg?auto=compress&cs=tinysrgb&w=1400"
            alt="Patio intérieur du Rambla Marrakech"
            class="absolute inset-0 h-full w-full object-cover"
        >

        {{-- Overlay dégradé sombre --}}
        <div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-ink/10"></div>

        {{-- Nom de l'hôtel positionné en bas --}}
        <div class="absolute bottom-12 left-10 right-10">
            <p class="font-display text-xs font-semibold uppercase tracking-[0.25em] text-brass/80 mb-3">
                Marrakech, Maroc
            </p>
            <h1 class="font-display text-5xl font-semibold leading-tight text-parchment">
                Rambla<br>Marrakech
            </h1>
            <div class="mt-5 h-px w-12 bg-brass"></div>
        </div>
    </div>

    {{-- ── RIGHT COLUMN : formulaire ── --}}
    <div class="flex min-h-screen flex-col justify-center bg-parchment px-6 py-12 sm:px-12 lg:px-16">
        <div class="mx-auto w-full max-w-md">

            {{-- Logo mobile (visible uniquement sous md) --}}
            <div class="mb-10 md:hidden text-center">
                <h1 class="font-display text-3xl font-semibold text-ink">Rambla Marrakech</h1>
                <div class="mx-auto mt-3 h-px w-10 bg-brass"></div>
            </div>

            {{-- En-tête --}}
            <div class="mb-10">
                <h2 class="font-display text-4xl font-semibold text-ink">Créer un compte</h2>
                <p class="mt-2 text-sm text-stone">Rejoignez-nous et profitez de nos services en ligne.</p>
            </div>

            {{-- ── Bouton Google ── --}}
            <a
                href="{{ route('auth.google') }}"
                class="flex w-full items-center justify-center gap-3 rounded-lg border border-ink/20 bg-white px-4 py-3 text-sm font-medium text-ink shadow-none transition-colors duration-200 hover:border-ink/40 hover:bg-ink/5 focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2 mb-6"
            >
                {{-- Logo Google SVG officiel --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5 shrink-0" aria-hidden="true">
                    <path fill="#EA4335" d="M24 9.5c3.14 0 5.95 1.08 8.17 2.86l6.1-6.1C34.46 3.1 29.5 1 24 1 14.82 1 7.07 6.48 3.69 14.18l7.1 5.52C12.5 13.67 17.77 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.5 24.5c0-1.64-.15-3.22-.42-4.74H24v8.98h12.67c-.55 2.9-2.2 5.36-4.67 7.02l7.18 5.58C43.27 37.3 46.5 31.36 46.5 24.5z"/>
                    <path fill="#FBBC05" d="M10.79 28.3A14.6 14.6 0 0 1 9.5 24c0-1.49.26-2.93.71-4.3l-7.1-5.52A23.94 23.94 0 0 0 .5 24c0 3.86.92 7.5 2.55 10.72l7.74-6.42z"/>
                    <path fill="#34A853" d="M24 47c5.5 0 10.12-1.82 13.5-4.94l-7.18-5.58c-1.81 1.22-4.13 1.94-6.32 1.94-6.23 0-11.5-4.17-13.21-9.76l-7.74 6.42C7.07 41.52 14.82 47 24 47z"/>
                    <path fill="none" d="M0 0h48v48H0z"/>
                </svg>
                Continuer avec Google
            </a>

            {{-- Séparateur --}}
            <div class="relative mb-6 flex items-center">
                <div class="flex-grow border-t border-ink/15"></div>
                <span class="mx-4 shrink-0 text-xs font-medium uppercase tracking-widest text-stone/60">ou</span>
                <div class="flex-grow border-t border-ink/15"></div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nom --}}
                <div>
                    <x-input-label for="name" :value="__('Nom complet')" />
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="mt-1.5 block w-full rounded-lg border border-ink/20 bg-white px-4 py-3 text-sm text-ink placeholder-stone/60 shadow-none transition-colors duration-200 focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass"
                        placeholder="Prénom Nom"
                    >
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Adresse e-mail')" />
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        class="mt-1.5 block w-full rounded-lg border border-ink/20 bg-white px-4 py-3 text-sm text-ink placeholder-stone/60 shadow-none transition-colors duration-200 focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass"
                        placeholder="vous@exemple.com"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Mot de passe --}}
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="mt-1.5 block w-full rounded-lg border border-ink/20 bg-white px-4 py-3 text-sm text-ink shadow-none transition-colors duration-200 focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirmation du mot de passe --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="mt-1.5 block w-full rounded-lg border border-ink/20 bg-white px-4 py-3 text-sm text-ink shadow-none transition-colors duration-200 focus:border-brass focus:outline-none focus:ring-1 focus:ring-brass"
                    >
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Bouton principal --}}
                <div class="pt-1">
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-brass px-4 py-3.5 text-sm font-semibold uppercase tracking-widest text-ink transition-colors duration-200 hover:bg-ink hover:text-parchment focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2 active:bg-ink/90"
                    >
                        Créer mon compte
                    </button>
                </div>

                {{-- Lien connexion --}}
                <p class="text-center text-sm text-stone">
                    Déjà inscrit ?
                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-brass transition-colors duration-200 hover:text-ink"
                    >
                        Se connecter
                    </a>
                </p>

            </form>
        </div>
    </div>

</div>

</body>
</html>
