<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">Lista de Rotas</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Search & Filter -->
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-6 mb-8">
            <form action="{{ route('rotas.index') }}" method="GET">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg placeholder-gray-400 text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Pesquisar rotas...">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <button type="button" id="toggleFilters"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                        <i class="fas fa-filter mr-2"></i>Filtros
                    </button>
                </div>

                <!-- Filter Area -->
                <div id="filterArea" class="hidden mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="zona" class="block text-gray-700 font-semibold mb-1">Zona:</label>
                            <div class="flex">
                                <select name="zona" id="zona"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Todas as zonas</option>
                                    @foreach($zonas ?? [] as $zonaOption)
                                        <option value="{{ $zonaOption }}" {{ ($zona ?? '') == $zonaOption ? 'selected' : '' }}>
                                            {{ $zonaOption }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="ml-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                    Aplicar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Rota e Mapa -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4 max-h-[600px] overflow-y-auto bg-white p-4 rounded-xl border border-gray-200 shadow-md">
                @forelse($rotas as $rota)
                <div class="flex flex-col md:flex-row border border-gray-200 p-4 rounded-xl shadow-sm bg-white">
                    <div class="md:w-1/2 pr-4">
                        <div class="flex justify-between items-start">
                            <a href="/rotas/{{ $rota['id'] }}" class="text-blue-600 hover:underline text-lg font-semibold">
                                {{ $rota['titulo'] }}
                            </a>
                            <button onclick="showModal({{ $rota['id'] }})">
                                <i class="fas fa-trash text-red-600 hover:text-red-800"></i>
                            </button>
                        </div>
                        <p class="text-gray-700 mt-2">Descrição: {{ $rota['descricao'] }}</p>
                        <p class="text-gray-700">Distância: {{ $rota['distancia'] }} km</p>
                        @if(isset($rota['zona']))
                        <p class="text-gray-800 font-bold mt-2">
                            <i class="fas fa-map-marker-alt mr-1 text-gray-500"></i> Zona: {{ $rota['zona'] }}
                        </p>
                        @endif
                        <form id="delete-form-{{ $rota['id'] }}" action="{{ route('rotas.destroy', $rota['id']) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    <div class="md:w-1/2 mt-4 md:mt-0">
                        @if(isset($rota['imagem']))
                        <img src="{{ asset('storage/' . $rota['imagem']) }}" alt="Imagem da Rota"
                            class="rounded-lg object-cover h-48 w-full">
                        @else
                        <div class="h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            Sem imagem
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-gray-500">Nenhuma rota disponível.</p>
                @endforelse
            </div>

            <!-- Mapa -->
            <div class="sticky top-4 bg-white p-4 rounded-xl border border-gray-200 shadow-md h-[600px]">
                <div id="map" class="h-full rounded-lg border border-gray-300"></div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Confirmar eliminação</h2>
            <p class="text-gray-600 mb-6">Tem a certeza que deseja eliminar esta rota?</p>
            <div class="flex justify-center gap-4">
                <button onclick="confirmDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Eliminar</button>
                <button onclick="hideModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        // Modal
        let deleteId = null;
        function showModal(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }
        function hideModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            deleteId = null;
        }
        function confirmDelete() {
            if (deleteId) {
                document.getElementById(`delete-form-${deleteId}`).submit();
            }
        }

        // Toggle filtros
        document.getElementById('toggleFilters').addEventListener('click', function () {
            const area = document.getElementById('filterArea');
            area.classList.toggle('hidden');
        });

        // Leaflet Map
        const map = L.map('map', {
            maxBounds: [[85, -180], [-85, 180]],
            maxBoundsViscosity: 1.0,
            minZoom: 2,
            maxZoom: 18
        }).setView([39.5, -8.0], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const rotas = @json($rotas);

        rotas.forEach(rota => {
            try {
                const coords = JSON.parse(rota.coordenadas);
                if (coords.length > 0) {
                    const first = coords[0];
                    const marker = L.marker([first.lat, first.lng]).addTo(map);
                    marker.bindPopup(`
                        <strong>${rota.titulo}</strong><br>
                        <a href="/rotas/${rota.id}" class="text-blue-600 underline">Ver Detalhes</a>
                    `);
                }
            } catch (error) {
                console.warn("Erro nas coordenadas da rota:", rota.id, error);
            }
        });
    </script>
</x-layout>
