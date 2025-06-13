<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Detalhes da Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">

    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Bloco de detalhes -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-200">
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h1 class="text-3xl font-bold text-gray-800">{{ $rota['titulo'] }}</h1>
            </div>
            <div class="space-y-2 text-gray-700">
                <p><span class="font-semibold">Descrição:</span> {{ $rota['descricao'] }}</p>
                <p><span class="font-semibold">Distância:</span> {{ $rota['distancia'] }} km</p>
                <p><span class="font-semibold">Zona:</span> {{ $rota['zona'] }}</p>
            </div>
        </div>

        <!-- Imagem e Mapa lado a lado -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-200">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Imagem -->
                @if ($rota->imagem)
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="{{ asset('storage/' . $rota->imagem) }}" alt="Imagem da Rota"
                        class="rounded-lg shadow-md border border-gray-200 max-h-[600px] object-cover">
                </div>
                @endif

                <!-- Mapa -->
                <div class="w-full md:w-1/2">
                    <div id="map" class="h-[600px] rounded-lg shadow-md border border-gray-200 w-full z-0"></div>
                </div>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="flex justify-center gap-4 mt-4">
            <a href="/rotas/{{ $rota['id'] }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Editar Rota
            </a>

            <button onclick="showModal({{ $rota['id'] }})"
                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Eliminar Rota
            </button>

            <form id="delete-form-{{ $rota['id'] }}" action="{{ route('rotas.destroy', $rota['id']) }}" method="POST"
                class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <a href="/rotas" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Voltar à Lista
            </a>
        </div>
    </div>
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[1000] items-center justify-center">

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
        const map = L.map('map', {
            maxBounds: [
                [85, -180],
                [-85, 180]
            ],
            maxBoundsViscosity: 1.0,
            minZoom: 2,
            maxZoom: 18
        }).setView([39.5, -8.0], 6);


        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        const coordenadas = @json(json_decode($rota['coordenadas']));


        if (coordenadas.length > 0) {
            const latlngs = coordenadas.map(coord => [coord.lat, coord.lng]);


            const bounds = L.latLngBounds(latlngs);
            map.fitBounds(bounds);


            L.polyline(latlngs, {
                color: 'blue',
                weight: 5,
                opacity: 0.7
            }).addTo(map);


            L.marker(latlngs[0]).addTo(map).bindPopup("Início da Rota").openPopup();
            L.marker(latlngs[latlngs.length - 1]).addTo(map).bindPopup("Fim da Rota");

            const pontosTuristicos = @json($rota -> pontos);

            pontosTuristicos.forEach(ponto => {
                if (ponto.coordenadas) {
                    const coords = JSON.parse(ponto.coordenadas);
                    L.marker([coords.lat, coords.lng])
                        .addTo(map)
                        .bindPopup(`<strong>${ponto.titulo}</strong>`);
                }
            });
        }
    </script>
</x-layout>