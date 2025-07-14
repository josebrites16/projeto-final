<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Detalhes da Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


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
                <div class="w-full md:w-1/3 flex justify-center">
                    <img src="{{ asset('storage/' . $rota->imagem) }}" alt="Imagem da Rota"
                        class="rounded-lg shadow-md border border-gray-200 max-h-[600px] object-cover">
                </div>
                @endif

                <!-- Mapa -->
                <div class="w-full md:w-1/3">
                    <div id="map" class="h-[600px] rounded-lg shadow-md border border-gray-200 w-full z-0"></div>
                </div>

                <!-- Lista de Pontos Turísticos -->
                <div class="w-full md:w-1/3 overflow-y-auto max-h-[600px] border border-gray-200 rounded-lg p-4 bg-white shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Pontos Turísticos</h2>
                    @forelse($rota->pontos as $ponto)
                    <div class="mb-4 border-b pb-2 border-gray-200 flex justify-between items-start gap-2">
                        <div>
                            <h3 class="text-lg font-bold text-brown">{{ $ponto->titulo }}</h3>
                            <p class="text-gray-600">{{ $ponto->descricao }}</p>
                        </div>
                        <div class="flex gap-2 text-xl">
                            <!-- Editar -->
                            <a href="{{ route('pontos.edit', ['rota' => $rota->id, 'ponto' => $ponto->id]) }}" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit text-yellow-500 hover:text-yellow-700"></i>
                            </a>

                            <!-- Eliminar -->
                            <form id="delete-ponto-{{ $ponto->id }}" action="{{ route('pontos.destroy', $ponto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeletePontoModal({{ $ponto->id }})" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash text-red-600 hover:text-red-800"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">Nenhum ponto turístico adicionado.</p>
                    @endforelse


                </div>
            </div>

            <!-- Botões de ação -->
            <div class="flex justify-center gap-4 mt-4">
                <a href="/rotas/{{ $rota['id'] }}/edit" class="bg-brown text-white px-4 py-2 rounded hover:bg-brown-dark">
                    Editar Rota
                </a>

                <button onclick="showModal({{ $rota['id'] }})"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-600">
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


            <!-- Modal genérico de eliminação -->
            <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[1000] items-center justify-center">
                <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                    <h2 id="deleteModalTitle" class="text-lg font-bold text-gray-800 mb-4">Confirmar eliminação</h2>
                    <p id="deleteModalMessage" class="text-gray-600 mb-6">Tem a certeza que deseja eliminar este item?</p>
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
                    deleteType = 'rota';
                    document.getElementById('deleteModalTitle').innerText = 'Confirmar eliminação';
                    document.getElementById('deleteModalMessage').innerText = 'Tem a certeza que deseja eliminar esta rota?';
                    document.getElementById('deleteModal').classList.remove('hidden');
                    document.getElementById('deleteModal').classList.add('flex');
                }

                function showDeletePontoModal(pontoId) {
                    deleteId = pontoId;
                    deleteType = 'ponto';
                    document.getElementById('deleteModalTitle').innerText = 'Confirmar eliminação';
                    document.getElementById('deleteModalMessage').innerText = 'Tem a certeza que deseja eliminar este ponto turístico?';
                    document.getElementById('deleteModal').classList.remove('hidden');
                    document.getElementById('deleteModal').classList.add('flex');
                }

                function hideModal() {
                    document.getElementById('deleteModal').classList.add('hidden');
                    document.getElementById('deleteModal').classList.remove('flex');
                    deleteId = null;
                    deleteType = null;
                }

                function confirmDelete() {
                    if (deleteId && deleteType) {
                        if (deleteType === 'rota') {
                            document.getElementById(`delete-form-${deleteId}`).submit();
                        } else if (deleteType === 'ponto') {
                            document.getElementById(`delete-ponto-${deleteId}`).submit();
                        }
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

                function showDeletePontoModal(pontoId) {
                    deleteId = pontoId;
                    deleteType = 'ponto';
                    document.getElementById('deleteModalTitle').innerText = 'Confirmar eliminação';
                    document.getElementById('deleteModalMessage').innerText = 'Tem a certeza que deseja eliminar este ponto turístico?';
                    document.getElementById('deleteModal').classList.remove('hidden');
                    document.getElementById('deleteModal').classList.add('flex');
                }
            </script>
</x-layout>