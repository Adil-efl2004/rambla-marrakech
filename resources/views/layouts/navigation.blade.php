@php
    $user = Auth::user();
    $homeRoute = match ($user?->role) {
        'client' => route('client.dashboard'),
        'serveur' => route('staff.orders.index'),
        'technicien', 'admin' => route('admin.dashboard'),
        default => route('dashboard'),
    };

    $primaryLinks = match ($user?->role) {
        'client' => [
            ['label' => 'Séjour',       'href' => route('client.dashboard'),          'active' => request()->routeIs('client.dashboard')],
            ['label' => 'Chambres',     'href' => route('client.rooms.index'),         'active' => request()->routeIs('client.rooms.*')],
            ['label' => 'Réserver',     'href' => route('client.reservations.index'),  'active' => request()->routeIs('client.reservations.*')],
            ['label' => 'Room Service', 'href' => route('client.room-service.index'),  'active' => request()->routeIs('client.room-service.*')],
            ['label' => 'Assistance',   'href' => route('client.reclamations.index'),  'active' => request()->routeIs('client.reclamations.*')],
        ],
        'serveur' => [
            ['label' => 'Commandes', 'href' => route('staff.orders.index'), 'active' => request()->routeIs('staff.orders.*')],
        ],
        'technicien', 'admin' => [
            ['label' => 'Tableau de bord', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
            ['label' => 'Réservations', 'href' => route('admin.reservations.index'), 'active' => request()->routeIs('admin.reservations.*')],
            ['label' => 'Réclamations', 'href' => route('admin.complaints.index'), 'active' => request()->routeIs('admin.complaints.*')],
        ],
        default => [],
    };
@endphp

<nav x-data="{ open: false }" class="bg-ink text-parchment">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="{{ $homeRoute }}" class="group flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-brass/40 bg-parchment/5 font-display text-xl font-semibold text-brass">
                        R
                    </span>
                    <span class="font-display text-xl font-semibold tracking-wide text-parchment transition-colors duration-200 group-hover:text-brass">
                        Rambla Marrakech
                    </span>
                </a>

                <div class="hidden items-center gap-8 sm:flex">
                    @foreach ($primaryLinks as $link)
                        <a href="{{ $link['href'] }}"
                           class="border-b-2 py-7 text-sm font-semibold transition-colors duration-200 {{ $link['active'] ? 'border-brass text-brass' : 'border-transparent text-parchment/80 hover:border-brass hover:text-parchment' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-md border border-brass/20 px-3 py-2 text-sm font-semibold text-parchment transition-colors duration-200 hover:border-brass hover:text-brass focus:outline-none">
                            <span>{{ $user?->name }}</span>
                            <svg class="h-4 w-4 shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-parchment transition-colors duration-200 hover:bg-parchment/10 hover:text-brass focus:outline-none">
                    <svg class="h-6 w-6 shrink-0" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-brass/20 sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            @foreach ($primaryLinks as $link)
                <x-responsive-nav-link :href="$link['href']" :active="$link['active']">
                    {{ $link['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="border-t border-brass/20 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-semibold text-parchment">{{ $user?->name }}</div>
                <div class="text-sm font-medium text-parchment/60">{{ $user?->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
