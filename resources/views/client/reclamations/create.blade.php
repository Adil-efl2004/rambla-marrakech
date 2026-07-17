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
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-ink">
            Nouvelle réclamation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="hotel-panel">
                <div class="p-6">
                    <form method="POST" action="{{ route('client.reclamations.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="type" value="Type de problème" />
                            <select id="type" name="type" class="mt-1 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass" required>
                                <option value="">- Sélectionner -</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @selected(old('type') === $type)>
                                        {{ $typeLabels[$type] ?? $type }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass"
                                      placeholder="Décrivez le problème rencontré...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <p class="rounded-md border border-coral/15 bg-coral/10 p-3 text-sm text-ink">
                            Les problèmes de climatisation, eau chaude, plomberie et électricité sont traités en priorité urgente.
                        </p>

                        <div class="flex items-center gap-4">
                            <x-danger-button>Envoyer la réclamation</x-danger-button>
                            <a href="{{ route('client.reclamations.index') }}" class="soft-link">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
