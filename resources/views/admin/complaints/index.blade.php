@php
    $typeLabels = [
        'climatisation' => 'Climatisation',
        'eau_chaude' => 'Eau chaude',
        'television' => 'Télévision',
        'wifi' => 'Wi-Fi',
        'plomberie' => 'Plomberie',
        'electricite' => 'Electricité',
        'autre' => 'Autre',
    ];

    $priorityLabels = [
        'basse' => 'Basse',
        'moyenne' => 'Moyenne',
        'urgente' => 'Urgente',
    ];

    $statusLabels = [
        'ouverte' => 'Ouverte',
        'en_cours' => 'En cours',
        'resolue' => 'Résolue',
    ];

    $statusClasses = [
        'ouverte' => 'status-pending',
        'en_cours' => 'status-neutral',
        'resolue' => 'status-positive',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-2xl font-semibold leading-tight text-ink">
                Gestion des réclamations
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="soft-link">
                <- Retour au tableau de bord
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-sage/20 bg-sage/10 p-4 text-sage">
                    {{ session('success') }}
                </div>
            @endif

            <div class="hotel-panel">
                <div class="p-6">
                    @if ($complaints->isEmpty())
                        <p class="text-stone">Aucune réclamation.</p>
                    @else
                        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                            @foreach ($complaints as $complaint)
                                <article class="key-card {{ $complaint->priority === 'urgente' ? 'border-coral/40' : '' }}">
                                    <div class="flex flex-wrap items-start justify-between gap-4 p-5">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                                {{ $typeLabels[$complaint->type] ?? $complaint->type }} · {{ $complaint->user->name }}
                                            </p>
                                            <p class="mt-2 room-number">
                                                Chambre {{ $complaint->room?->number ?? 'N/A' }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="status-badge {{ $complaint->priority === 'urgente' ? 'status-urgent' : 'status-neutral' }}">
                                                {{ $priorityLabels[$complaint->priority] ?? $complaint->priority }}
                                            </span>
                                            <span class="status-badge {{ $statusClasses[$complaint->status] ?? 'status-neutral' }}">
                                                {{ $statusLabels[$complaint->status] ?? $complaint->status }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="border-t border-ink/10 px-5 py-4">
                                        @if ($complaint->status !== 'resolue')
                                            <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}" class="grid gap-3 sm:grid-cols-[1fr_1fr_auto] sm:items-end">
                                                @csrf
                                                @method('PATCH')

                                                <div>
                                                    <x-input-label for="assigned_to_{{ $complaint->id }}" value="Technicien" />
                                                    <select id="assigned_to_{{ $complaint->id }}" name="assigned_to" class="mt-1 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass">
                                                        <option value="">- Non assigné -</option>
                                                        @foreach ($techniciens as $technicien)
                                                            <option value="{{ $technicien->id }}" @selected($complaint->assigned_to == $technicien->id)>
                                                                {{ $technicien->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div>
                                                    <x-input-label for="status_{{ $complaint->id }}" value="Statut" />
                                                    <select id="status_{{ $complaint->id }}" name="status" class="mt-1 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass">
                                                        <option value="ouverte" @selected($complaint->status === 'ouverte')>Ouverte</option>
                                                        <option value="en_cours" @selected($complaint->status === 'en_cours')>En cours</option>
                                                        <option value="resolue">Résolue</option>
                                                    </select>
                                                </div>

                                                <x-primary-button class="sm:mb-0.5">Mettre à jour</x-primary-button>
                                            </form>
                                        @else
                                            <span class="text-sm text-stone">
                                                Résolue le {{ $complaint->resolved_at?->format('d/m/Y H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
