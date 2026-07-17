@php
    $categoryLabels = [
        'entree' => 'Entrées',
        'plat' => 'Plats',
        'dessert' => 'Desserts',
        'boisson' => 'Boissons',
    ];
@endphp

<x-app-layout>
    <section class="relative overflow-hidden bg-ink text-parchment">
        <img src="https://assets.lummi.ai/assets/Qmf95LNnjXeiUJsGqyCqSx8JJPnQUJGCUshYY9RoRinWyX?auto=format&w=1600" alt="Patisserie elegante" class="absolute inset-0 h-full w-full object-cover opacity-40" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/85 to-ink/30"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass">Room Service</p>
            <h1 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Saveurs servies en chambre</h1>
            <p class="mt-4 max-w-2xl text-parchment/80">Composez votre commande, ajustez les quantités, puis envoyez-la à l'équipe restaurant.</p>
        </div>
    </section>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md border border-sage/20 bg-sage/10 p-4 text-sage">
                    {{ session('success') }}
                </div>
            @endif

            <x-input-error :messages="$errors->get('room')" class="mb-4" />
            <x-input-error :messages="$errors->get('items')" class="mb-4" />

            <form method="POST" action="{{ route('client.room-service.store') }}" id="order-form">
                @csrf

                <div class="space-y-12">
                    @forelse ($menuByCategory as $category => $items)
                        <section>
                            <div class="mb-5 flex items-end justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold uppercase tracking-wide text-stone">Carte</p>
                                    <h2 class="text-3xl font-semibold text-ink">{{ $categoryLabels[$category] ?? ucfirst($category) }}</h2>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                                @foreach ($items as $item)
                                    <article class="group hotel-panel transition duration-200 hover:-translate-y-1 hover:border-brass hover:shadow-lg">
                                        @if ($item->image_path)
                                            <div class="relative aspect-[4/3] overflow-hidden bg-ink">
                                                <img src="{{ $item->image_path }}" alt="{{ $item->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                                                <div class="absolute inset-0 bg-gradient-to-t from-ink/50 to-transparent"></div>
                                                <p class="absolute bottom-4 left-4 rounded-full bg-parchment/90 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-ink">
                                                    {{ $categoryLabels[$category] ?? ucfirst($category) }}
                                                </p>
                                            </div>
                                        @endif

                                        <div class="space-y-4 p-5">
                                            <div>
                                                <h3 class="text-xl font-semibold text-ink">{{ $item->name }}</h3>
                                                @if ($item->description)
                                                    <p class="mt-2 text-sm leading-6 text-stone">{{ $item->description }}</p>
                                                @endif
                                            </div>

                                            <div class="flex items-center justify-between gap-4">
                                                <p class="font-display text-2xl font-semibold text-brass">{{ \App\Support\Money::format($item->price) }}</p>

                                                <div class="flex items-center rounded-full border border-ink/10 bg-parchment">
                                                    <button type="button" class="quantity-step px-3 py-2 text-ink transition-colors duration-200 hover:text-brass" data-target="item-{{ $item->id }}" data-step="-1" aria-label="Retirer {{ $item->name }}">-</button>
                                                    <label class="sr-only" for="item-{{ $item->id }}">Quantité</label>
                                                    <input type="number" id="item-{{ $item->id }}"
                                                           name="items[{{ $item->id }}]" value="{{ old('items.'.$item->id, 0) }}"
                                                           min="0" max="99"
                                                           data-price="{{ $item->price }}"
                                                           class="quantity-input w-12 border-0 bg-transparent p-0 text-center text-sm font-semibold text-ink focus:ring-0">
                                                    <button type="button" class="quantity-step px-3 py-2 text-ink transition-colors duration-200 hover:text-brass" data-target="item-{{ $item->id }}" data-step="1" aria-label="Ajouter {{ $item->name }}">+</button>
                                                </div>
                                            </div>

                                            <button type="button" class="quantity-add w-full rounded-md border border-brass/40 px-4 py-2 text-sm font-semibold text-ink transition-colors duration-200 hover:bg-brass/10" data-target="item-{{ $item->id }}">
                                                Ajouter à la commande
                                            </button>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @empty
                        <div class="hotel-panel p-6">
                            <p class="text-stone">Aucun article disponible pour le moment.</p>
                        </div>
                    @endforelse
                </div>

                @if ($menuByCategory->isNotEmpty())
                    <div class="sticky bottom-4 z-10 mt-10">
                        <div class="hotel-panel border-brass/30 bg-parchment/95 p-5 backdrop-blur">
                            <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
                                <div>
                                    <x-input-label for="notes" value="Notes pour l'équipe (optionnel)" />
                                    <textarea id="notes" name="notes" rows="2"
                                              class="mt-1 block w-full rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass">{{ old('notes') }}</textarea>
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-4 lg:justify-end">
                                    <p class="text-lg font-semibold text-ink">
                                        Total : <span id="order-total">0,00</span> DH
                                    </p>
                                    <x-primary-button>Envoyer la commande</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.quantity-input');
        const totalEl = document.getElementById('order-total');

        function updateTotal() {
            let total = 0;
            inputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price) || 0;
                total += qty * price;
            });
            totalEl.textContent = total.toFixed(2).replace('.', ',');
        }

        document.querySelectorAll('.quantity-step, .quantity-add').forEach(button => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                const step = parseInt(button.dataset.step || 1);
                const current = parseInt(input.value) || 0;
                input.value = Math.max(0, Math.min(99, current + step));
                updateTotal();
            });
        });

        inputs.forEach(input => input.addEventListener('input', updateTotal));
        updateTotal();
    </script>
</x-app-layout>
