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
                Mes réclamations
            </h2>
            <a href="{{ route('client.reclamations.create') }}"
               class="inline-flex items-center rounded-md bg-coral px-4 py-2 text-sm font-semibold text-ink transition-colors duration-200 hover:bg-ink hover:text-parchment">
                Nouvelle réclamation
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
                        <p class="text-stone">Aucune réclamation pour le moment.</p>
                    @else
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            @foreach ($complaints as $complaint)
                                <article class="key-card">
                                    <div class="flex flex-wrap items-start justify-between gap-4 p-5">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone">
                                                Réclamation {{ $typeLabels[$complaint->type] ?? $complaint->type }}
                                            </p>
                                            <p class="mt-2 room-number">
                                                Chambre {{ $complaint->room?->number ?? 'N/A' }}
                                            </p>
                                            <p class="mt-2 text-sm text-stone">
                                                {{ $complaint->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="status-badge {{ $complaint->priority === 'urgente' ? 'status-urgent' : 'status-neutral' }}">
                                                {{ $priorityLabels[$complaint->priority] ?? $complaint->priority }}
                                            </span>
                                            <span class="status-badge {{ $statusClasses[$complaint->status] ?? 'status-neutral' }}">
                                                {{ str_replace('_', ' ', $complaint->status) }}
                                            </span>
                                        </div>
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
