<x-app-layout>
    <section class="bg-ink text-parchment">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Nouvelle réservation</p>
            <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Préparer votre prochain moment</h1>
            <p class="mt-4 max-w-2xl text-parchment/75">Choisissez une chambre libre ou un service, puis indiquez le créneau souhaité.</p>
        </div>
    </section>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('client.reservations.store') }}" class="space-y-6">
                @csrf

                <div class="hotel-panel p-6">
                    <h2 class="text-2xl font-semibold text-ink">Type de réservation</h2>
                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <label class="cursor-pointer rounded-lg border border-ink/10 bg-parchment p-5 transition duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                            <input type="radio" name="type" value="room" class="sr-only peer" @checked(old('type', 'room') === 'room')>
                            <span class="font-display text-2xl font-semibold text-ink peer-checked:text-brass">Chambre</span>
                            <span class="mt-2 block text-sm text-stone">Réserver un espace pour votre séjour.</span>
                        </label>

                        <label class="cursor-pointer rounded-lg border border-ink/10 bg-parchment p-5 transition duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                            <input type="radio" name="type" value="service" class="sr-only peer" @checked(old('type') === 'service')>
                            <span class="font-display text-2xl font-semibold text-ink peer-checked:text-brass">Service</span>
                            <span class="mt-2 block text-sm text-stone">Planifier une prestation de l'hôtel.</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <div class="hotel-panel p-6">
                    <div id="room-select">
                        <x-input-label for="room_id" value="Chambre disponible" />
                        <select id="room_id" name="reservable_id" class="mt-2 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass">
                            <option value="">- Sélectionner -</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('reservable_id') == $room->id && old('type', 'room') === 'room')>
                                    N° {{ $room->number }} - {{ $room->type }} ({{ \App\Support\Money::format($room->price_per_night) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="service-select" class="hidden">
                        <x-input-label for="service_id" value="Service actif" />
                        <select id="service_id" class="mt-2 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass">
                            <option value="">- Sélectionner -</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(old('reservable_id') == $service->id && old('type') === 'service')>
                                    {{ $service->name }} ({{ \App\Support\Money::format($service->price) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-input-error :messages="$errors->get('reservable_id')" class="mt-2" />
                </div>

                <div class="hotel-panel p-6">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <x-input-label for="start_datetime" value="Date et heure de début" />
                            <x-text-input id="start_datetime" name="start_datetime" type="datetime-local"
                                          class="mt-2 block w-full" :value="old('start_datetime')" required />
                            <x-input-error :messages="$errors->get('start_datetime')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="end_datetime" value="Date et heure de fin (optionnel)" />
                            <x-text-input id="end_datetime" name="end_datetime" type="datetime-local"
                                          class="mt-2 block w-full" :value="old('end_datetime')" />
                            <x-input-error :messages="$errors->get('end_datetime')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-5">
                        <x-input-label for="notes" value="Notes (optionnel)" />
                        <textarea id="notes" name="notes" rows="3"
                                  class="mt-2 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4">
                    <x-primary-button>Créer la réservation</x-primary-button>
                    <a href="{{ route('client.reservations.index') }}" class="soft-link">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const typeInputs = document.querySelectorAll('input[name="type"]');
        const roomSelect = document.getElementById('room-select');
        const serviceSelect = document.getElementById('service-select');
        const roomInput = document.getElementById('room_id');
        const serviceInput = document.getElementById('service_id');

        function toggleReservable() {
            const selectedType = document.querySelector('input[name="type"]:checked')?.value || 'room';
            const isRoom = selectedType === 'room';
            roomSelect.classList.toggle('hidden', !isRoom);
            serviceSelect.classList.toggle('hidden', isRoom);

            if (isRoom) {
                roomInput.name = 'reservable_id';
                roomInput.required = true;
                serviceInput.name = '';
                serviceInput.required = false;
            } else {
                serviceInput.name = 'reservable_id';
                serviceInput.required = true;
                roomInput.name = '';
                roomInput.required = false;
            }
        }

        typeInputs.forEach(input => input.addEventListener('change', toggleReservable));
        toggleReservable();
    </script>
</x-app-layout>
