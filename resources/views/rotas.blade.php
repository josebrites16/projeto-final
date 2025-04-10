<x-layout>
    <x-slot:heading>
        <h1 class="text-2xl font-bold text-center mb-4">Lista de Rotas</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <!-- Adicionar Font Awesome para o ícone de lupa -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-6xl mx-auto p-4 md:ml-64">
        <!-- Barra de pesquisa e filtros -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-6 border border-gray-200">
            <form action="{{ route('rotas.index') }}" method="GET" class="space-y-4">
                <div class="flex items-center">
                    <div class="relative flex-grow">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Pesquisar rotas...">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="ml-2">
                        <button type="button" id="toggleFilters"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            <i class="fas fa-filter mr-2"></i>Filtros
                        </button>
                    </div>
                </div>

                <!-- Área de filtros (inicialmente oculta) -->
                <div id="filterArea" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="zona" class="block text-gray-700 text-sm font-bold mb-2">Zona:</label>
                            <div class="flex items-center">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4 max-h-[600px] overflow-y-auto border border-gray-200 p-4 rounded-lg shadow-md bg-white">
                @if(count($rotas) > 0)
                @foreach($rotas as $rota)
                <div class="bg-white shadow-md rounded-lg p-4 mb-4 border border-gray-200">
                    <a href="/rotas/{{ $rota['id'] }}" class="text-blue-500 hover:underline hover:text-blue-700">
                        <h2 class="text-lg font-semibold"> {{ $rota['titulo'] }}</h2>
                    </a>
                    <p class="text-gray-600 mt-2">Descrição: {{ $rota['descricao'] }}</p>
                    <p class="text-gray-600 ">Distância: {{ $rota['distancia'] }} km</p>
                    @if(isset($rota['zona']))
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>
                        <p class="text-gray-600 font-bold">Zona: {{ $rota['zona'] }}</p>
                        <i class="fas fa-trash text-red-500 ml-auto cursor-pointer"
                            onclick="confirmDeletion(event, {{ $rota['id'] }})"></i>
                        <form id="delete-form-{{ $rota['id'] }}" action="{{ route('rotas.destroy', $rota['id']) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
                @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Nenhuma rota encontrada.</p>
                </div>
                @endif
            </div>

            <div class="sticky top-4 bg-white shadow-md rounded-lg p-4 border border-gray-200 h-full">
                <div id="map" class="h-[600px] rounded-lg shadow-md border border-gray-200"></div>
            </div>
        </div>

        <script>
            function confirmDeletion(event, rotaId) {
                event.preventDefault();
                if (confirm('Tem a certeza que deseja eliminar esta rota?')) {
                    document.getElementById(`delete-form-${rotaId}`).submit();
                }
            }
        </script>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        // Toggle para exibir/ocultar a área de filtros
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterArea = document.getElementById('filterArea');
            filterArea.classList.toggle('hidden');
        });

        const map = L.map('map').fitBounds([
            [36.8381, -9.5266],
            [42.1543, -6.1891]
        ]);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const rotas = @json($rotas);

        rotas.forEach(rota => {
            try {
                const coordenadas = JSON.parse(rota.coordenadas);
                if (coordenadas.length > 0) {
                    const primeiraCoordenada = coordenadas[0];

                    const marker = L.marker([primeiraCoordenada.lat, primeiraCoordenada.lng]).addTo(map);

                    marker.bindPopup(`
                        <strong>${rota.titulo}</strong><br>
                        <a href="/rotas/${rota.id}" class="text-blue-500 underline">Ver Detalhes</a>
                    `);
                }
            } catch (error) {
                console.error(`Erro ao processar coordenadas da rota ${rota.id}:`, error);
            }
        });
    </script>

</x-layout>