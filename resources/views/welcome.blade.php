<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Rambla Marrakech, une adresse paisible au coeur de la ville ocre.">
    <title>Rambla Marrakech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity 700ms ease, transform 700ms ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } html { scroll-behavior: auto; } }
    </style>
</head>
<body class="bg-parchment font-sans text-ink antialiased">
    <header class="absolute inset-x-0 top-0 z-20">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-10" aria-label="Navigation principale">
            <a href="{{ url('/') }}" class="font-display text-xl font-semibold text-parchment sm:text-2xl">Rambla Marrakech</a>
            <div class="flex items-center gap-5 text-sm font-semibold text-parchment sm:gap-7">
                @auth
                    <a href="{{ url('/dashboard') }}" class="transition-colors duration-200 hover:text-brass">Mon sejour</a>
                @else
                    <a href="{{ route('login') }}" class="transition-colors duration-200 hover:text-brass">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden border border-parchment/60 px-4 py-2 transition-colors duration-200 hover:border-brass hover:bg-brass hover:text-ink sm:inline-flex">Creer un compte</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="relative flex min-h-screen items-end overflow-hidden bg-ink">
            <img src="https://images.pexels.com/photos/24839180/pexels-photo-24839180.jpeg?auto=compress&cs=tinysrgb&w=2200" alt="Cour interieure d'un riad a Marrakech" class="absolute inset-0 h-full w-full object-cover" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/50 to-ink/25"></div>
            <div class="relative mx-auto w-full max-w-7xl px-6 pb-16 pt-40 text-parchment sm:pb-20 lg:px-10 lg:pb-24">
                <p class="mb-6 text-xs font-semibold uppercase tracking-[0.28em] text-brass">Marrakech, Maroc</p>
                <h1 class="font-script text-6xl font-bold leading-[0.82] text-parchment sm:text-7xl md:text-8xl lg:text-9xl">Rambla<br>Marrakech</h1>
                <div class="mt-9 flex flex-col items-start gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="max-w-md text-base leading-relaxed text-parchment/85 sm:text-lg">Une maison marquee par le calme, la lumiere et l'hospitalite marocaine.</p>
                    <a href="#experience" class="inline-flex items-center gap-3 border-b border-brass pb-2 text-sm font-semibold uppercase tracking-[0.18em] text-parchment transition-colors duration-200 hover:text-brass">Decouvrir <span aria-hidden="true">&darr;</span></a>
                </div>
            </div>
        </section>

        <section id="experience" class="bg-white px-6 py-20 sm:py-28 lg:px-10 lg:py-36">
            <div class="mx-auto max-w-7xl">
                <div class="reveal max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-brass">L'experience Rambla</p>
                    <h2 class="mt-5 font-display text-4xl font-semibold leading-tight text-ink sm:text-5xl">Une pause pensee dans les moindres details.</h2>
                </div>
                <div class="mt-14 grid gap-12 md:grid-cols-3 md:gap-8 lg:mt-20 lg:gap-12">
                    <article class="reveal" style="transition-delay: 80ms">
                        <div class="aspect-[4/5] overflow-hidden bg-parchment">
                            <img src="https://images.pexels.com/photos/15531322/pexels-photo-15531322.jpeg?auto=compress&cs=tinysrgb&w=1100" alt="Chambre marocaine elegante" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                        </div>
                        <h3 class="mt-6 font-display text-2xl font-semibold text-ink">Chambres</h3>
                        <p class="mt-3 max-w-sm leading-relaxed text-stone">Des refuges enveloppants, ou textiles, bois et lumiere composent une douceur tres personnelle.</p>
                    </article>
                    <article class="reveal" style="transition-delay: 160ms">
                        <div class="aspect-[4/5] overflow-hidden bg-parchment">
                            <img src="https://images.pexels.com/photos/9143471/pexels-photo-9143471.jpeg?auto=compress&cs=tinysrgb&w=1100" alt="Salle de restaurant elegante a Marrakech" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                        </div>
                        <h3 class="mt-6 font-display text-2xl font-semibold text-ink">Gastronomie</h3>
                        <p class="mt-3 max-w-sm leading-relaxed text-stone">Une table genereuse qui honore les produits du Maroc, du premier the a la derniere douceur.</p>
                    </article>
                    <article class="reveal" style="transition-delay: 240ms">
                        <div class="aspect-[4/5] overflow-hidden bg-parchment">
                            <img src="https://images.pexels.com/photos/33279021/pexels-photo-33279021.jpeg?auto=compress&cs=tinysrgb&w=1100" alt="Hammam marocain avec huiles de soin" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                        </div>
                        <h3 class="mt-6 font-display text-2xl font-semibold text-ink">Bien-etre</h3>
                        <p class="mt-3 max-w-sm leading-relaxed text-stone">Le temps ralentit entre les vapeurs du hammam et des rituels inspires des traditions locales.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-parchment px-4 py-20 sm:px-6 sm:py-28 lg:px-10 lg:py-36">
            <div class="mx-auto max-w-7xl">
                <div class="reveal mb-10 flex items-end justify-between gap-6 sm:mb-14">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-brass">En images</p>
                        <h2 class="mt-4 font-display text-4xl font-semibold text-ink sm:text-5xl">L'esprit de la maison.</h2>
                    </div>
                    <span class="hidden text-sm text-stone sm:block">Rambla Marrakech</span>
                </div>
                <div class="grid auto-rows-[190px] grid-cols-2 gap-3 sm:auto-rows-[250px] sm:gap-4 lg:grid-cols-4 lg:auto-rows-[210px]">
                    <figure class="reveal col-span-2 row-span-2 overflow-hidden bg-ink">
                        <img src="https://images.pexels.com/photos/30257102/pexels-photo-30257102.jpeg?auto=compress&cs=tinysrgb&w=1600" alt="Riad marocain avec fontaine et mosaIques" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </figure>
                    <figure class="reveal overflow-hidden bg-ink" style="transition-delay: 80ms">
                        <img src="https://images.pexels.com/photos/15531101/pexels-photo-15531101.jpeg?auto=compress&cs=tinysrgb&w=900" alt="Salle a manger avec arches marocaines" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </figure>
                    <figure class="reveal overflow-hidden bg-ink" style="transition-delay: 140ms">
                        <img src="https://images.pexels.com/photos/34936237/pexels-photo-34936237.jpeg?auto=compress&cs=tinysrgb&w=900" alt="Lobby d'hotel de style marocain" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </figure>
                    <figure class="reveal col-span-2 overflow-hidden bg-ink" style="transition-delay: 200ms">
                        <img src="https://images.pexels.com/photos/15531325/pexels-photo-15531325.jpeg?auto=compress&cs=tinysrgb&w=1400" alt="Vue sur une cour de riad a Marrakech" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </figure>
                </div>
            </div>
        </section>

        <section class="bg-ink px-6 py-24 text-center text-parchment sm:py-32 lg:px-10 lg:py-40">
            <div class="reveal mx-auto max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-brass">Votre sejour commence ici</p>
                <h2 class="mt-5 font-display text-4xl font-semibold leading-tight sm:text-5xl">Entrez dans la maison.</h2>
                <p class="mt-6 text-base leading-relaxed text-parchment/75 sm:text-lg">Retrouvez vos services, vos reservations et chaque attention preparee pour votre sejour.</p>
                <div class="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ route('login') }}" class="inline-flex min-h-12 items-center justify-center bg-brass px-7 text-sm font-bold text-ink transition-colors duration-200 hover:bg-parchment">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex min-h-12 items-center justify-center border border-parchment/60 px-7 text-sm font-bold text-parchment transition-colors duration-200 hover:border-brass hover:text-brass">Creer un compte</a>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-parchment/15 bg-ink px-6 py-7 text-xs text-parchment/60 lg:px-10">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-3 sm:flex-row">
            <span class="font-display text-sm text-parchment">Rambla Marrakech</span>
            <div class="flex gap-5"><span>&copy; {{ now()->year }}</span><span>Mentions legales</span></div>
        </div>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14 });

        document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
    </script>
</body>
</html>
