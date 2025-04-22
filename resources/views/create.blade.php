<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Criar Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">

    <div class="max-w-6xl mx-auto p-4 md:ml-64">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
            <div class="space-y-4 max-h-[600px] overflow-y-auto border border-gray-200 p-4 rounded-lg shadow-md bg-white">
                <div class="bg-white shadow-md rounded-lg p-4 mb-4 border border-gray-200">
                    <h2 class="font-bold text-lg">Nova Rota</h2>
                    <form id="rotaForm" action="{{ route('rotas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                            <input type="text" id="titulo" name="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="descricao" class="block text-gray-700font-bold mb-2">Descrição:</label>
                            <input type="text" id="descricao" name="descricao" class=" shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline " required>
                        </div>
                        <div class="mb-4">
                            <label for="zona" class="block text-gray-700 text-sm font-bold mb-2">Zona:</label>
                            <select name="zona" id="zona" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Todas as zonas</option>
                                @foreach($zonas ?? [] as $zonaOption)
                                <option value="{{ $zonaOption }}" {{ ($zona ?? '') == $zonaOption ? 'selected' : '' }}>
                                    {{ $zonaOption }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="imagem" class="block text-gray-700">Imagem:</label>
                            <input type="file" class="border border-gray-300 rounded-lg p-2 w-full" id="imagem" name="imagem">
                            @error('imagem')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="distancia" class="block text-gray-700 text-sm font-bold mb-2">Distância (Km):</label>
                            <input type="text" id="distancia" name="distancia" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                            <p class="text-gray-400 text-sm font-bold mb-2">A distância é calculada automaticamente ao desenhar a rota</p>
                        </div>
                </div>
                <input type="hidden" name="coordenadas" id="coordenadas">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Salvar Alterações</button>
                <a href="/rotas" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar á Lista</a>
                </form>
                <div class="mt-4 p-2 bg-gray-100 rounded-lg">
                    <h3 class="font-medium mb-2">Instruções de Criação:</h3>
                    <ul class="list-disc pl-5 text-sm">
                        <li>Use as ferramentas de desenho no canto superior direito do mapa.</li>
                        <li> A distância total será calculada automaticamente.</li>
                        <li> Após desenhar a rota, clique em "Salvar Rota" para armazenar as informações.</li>
                        <li> Você pode apagar e redesenhar a rota utilizando o botão "Deletar camadas"</li>
                        <li> Certifique-se de que a rota está desenhada corretamente antes de salvar.</li>
                        <li> Você pode editar ou excluir a rota posteriormente.</li>
                    </ul>
                </div>
            </div>
            <div class="sticky top-4 bg-white shadow-md rounded-lg p-4 border border-gray-200 h-[600px]">
                <div id="map" class="h-full rounded-lg shadow-md border border-gray-200"></div>
            </div>
        </div>

        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
        <script>
            const map = L.map('map').setView([39.5, -8.0], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            const drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                },
                draw: {
                    polygon: false,
                    rectangle: false,
                    circle: false,
                    marker: false,
                    circlemarker: false,
                    polyline: {
                        shapeOptions: {
                            color: 'blue',
                            weight: 5
                        }
                    }
                }
            });
            map.addControl(drawControl);

            function calculateDistance(latlngs) {
                let totalDistance = 0;
                for (let i = 0; i < latlngs.length - 1; i++) {
                    totalDistance += map.distance(latlngs[i], latlngs[i + 1]) / 1000;
                }
                return totalDistance.toFixed(2);
            }

            function serializeCoordinates(latlngs) {
                return latlngs.map(latlng => ({
                    lat: latlng.lat,
                    lng: latlng.lng
                }));
            }

            map.on('draw:created', function(e) {
                drawnItems.clearLayers();
                const layer = e.layer;
                drawnItems.addLayer(layer);
                const latlngs = layer.getLatLngs();
                document.getElementById('distancia').value = calculateDistance(latlngs);
                document.getElementById('coordenadas').value = JSON.stringify(serializeCoordinates(latlngs));
            });

            document.getElementById('rotaForm').addEventListener('submit', function(e) {
                if (!document.getElementById('coordenadas').value) {
                    e.preventDefault();
                    alert("Desenhe uma rota antes de salvar.");
                }
            });
        </script>
</x-layout>