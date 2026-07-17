<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-ink">
            Tableau de bord Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="key-card p-8 text-center">
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-stone">
                        Réclamations urgentes
                    </p>
                    <div class="relative inline-block">
                        <span class="font-display text-6xl font-bold text-coral">{{ $urgentesCount }}</span>
                        @if ($urgentesCount > 0)
                            <span class="absolute -top-2 -right-6 flex h-6 w-6 items-center justify-center rounded-full bg-coral text-xs font-bold text-ink">
                                !
                            </span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('admin.complaints.index') }}"
                   class="key-card flex items-center justify-center p-8 transition-colors duration-200 hover:border-brass/60 hover:bg-brass/5">
                    <span class="text-lg font-semibold text-ink">Gérer les réclamations -></span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
