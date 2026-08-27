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

    $priorityLabels = [
        'basse'   => 'Basse',
        'moyenne' => 'Moyenne',
        'urgente' => 'Urgente',
    ];

    $statusClasses = [
        'ouverte'  => 'status-pending',
        'en_cours' => 'status-neutral',
        'resolue'  => 'status-positive',
    ];

    $statusLabels = [
        'ouverte'  => 'Ouverte',
        'en_cours' => 'En cours',
        'resolue'  => 'Résolue',
    ];
@endphp

<x-app-layout>
    {{-- ── Hero ── --}}
    <section class="bg-ink text-parchment">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Assistance</p>
                <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Mes réclamations</h1>
                <p class="mt-4 max-w-2xl text-parchment/75">Suivez l'avancement de vos signalements auprès de l'équipe technique.</p>
            </div>
            <a href="{{ route('client.reclamations.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-coral px-5 py-3
                      text-sm font-semibold uppercase tracking-widest text-ink
                      transition-colors duration-200 hover:bg-parchment hover:text-ink
                      focus:outline-none focus:ring-2 focus:ring-coral focus:ring-offset-2 focus:ring-offset-ink">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nouvelle réclamation
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

            @if ($complaints->isEmpty())
                <div class="hotel-panel p-12 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-coral/10">
                        <svg class="h-8 w-8 text-coral" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-display text-xl font-semibold text-ink">Aucune réclamation</h3>
                    <p class="mt-2 text-sm text-stone">Tout va bien — aucun problème signalé pour le moment.</p>
                    <a href="{{ route('client.reclamations.create') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-lg bg-coral px-5 py-2.5
                              text-sm font-semibold uppercase tracking-widest text-ink
                              transition-colors duration-200 hover:bg-ink hover:text-parchment">
                        Signaler un problème
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @foreach ($complaints as $complaint)
                        <article class="key-card transition-all duration-200 hover:-translate-y-1 hover:border-coral/60 hover:shadow-lg">
                            <div class="p-6">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        {{-- Icône type --}}
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg
                                                    {{ $complaint->priority === 'urgente' ? 'bg-coral/10' : 'bg-brass/10' }}">
                                            <svg class="h-5 w-5 {{ $complaint->priority === 'urgente' ? 'text-coral' : 'text-brass' }}"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                                {{ $typeLabels[$complaint->type] ?? $complaint->type }}
                                            </p>
                                            <p class="mt-1 font-display text-3xl font-semibold leading-none text-brass">
                                                Ch. {{ $complaint->room?->number ?? '—' }}
                                            </p>
                                            <p class="mt-1 text-sm text-stone">
                                                {{ $complaint->created_at->format('d/m/Y à H:i') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end gap-2">
                                        <span class="status-badge {{ $complaint->priority === 'urgente' ? 'status-urgent' : 'status-neutral' }}">
                                            {{ $priorityLabels[$complaint->priority] ?? $complaint->priority }}
                                        </span>
                                        <span class="status-badge {{ $statusClasses[$complaint->status] ?? 'status-neutral' }}">
                                            {{ $statusLabels[$complaint->status] ?? str_replace('_', ' ', $complaint->status) }}
                                        </span>
                                    </div>
                                </div>

                                @if ($complaint->description)
                                    <p class="mt-4 border-t border-ink/10 pt-4 text-sm text-stone line-clamp-2">
                                        {{ $complaint->description }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
