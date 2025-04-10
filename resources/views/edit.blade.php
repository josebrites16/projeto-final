<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Editar Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">

    <div class="max-w-6xl mx-auto p-4 md:ml-64">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4 max-h-[600px] overflow-y-auto border border-gray-200 p-4 rounded-lg shadow-md bg-white">
                <div class="bg-white shadow-md rounded-lg p-4 mb-4 border border-gray-200">
                    <h2 class="font-bold text-lg">Editar Rota</h2>
                    <form id="rotaForm" action="{{ route('rotas.update', $rota->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="titulo" class="block text-gray-700">Título:</label>
                            <input type="text" name="titulo" id="titulo" value="{{ $rota->titulo }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <div class="mb-4">
                            <label for="descricao" class="block text-gray-700">Descrição:</label>
                            <textarea name="descricao" id="descricao" rows="4" class="border border-gray-300 rounded-lg p-2 w-full">{{ $rota->descricao }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="zona" class="block text-gray-700">Zona:</label>
                            <select name="zona" id="zona" class="border border-gray-300 rounded-lg p-2 w-full">
                                <option value="">Selecione uma zona</option>
                                @foreach($zonas as $zonaOption)
                                    <option value="{{ $zonaOption }}" {{ $rota->zona == $zonaOption ? 'selected' : '' }}>{{ $zonaOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="distancia" class="block text-gray-700">Distância (km):</label>
                            <input type="text" name="distancia" id="distancia" value="{{ $rota->distancia }}" readonly class="border border-gray-300 rounded-lg p-2 w-full bg-gray-100">
                            <p class = "text-gray-400 text-sm font-bold mb-2">A distância é calculada automaticamente ao desenhar a rota</p>
                        </div>
                        <input type="hidden" name="coordenadas" id="coordenadas" value="">
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Salvar Alterações</button>
                            <a href="{{ route('rotas.show', $rota->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
                        </div>
                    </form>
                    
                    <div class="mt-4 p-2 bg-gray-100 rounded-lg">
                        <h3 class="font-medium mb-2">Instruções de Edição:</h3>
                        <ul class="list-disc pl-5 text-sm">
                            <li>Use as ferramentas de desenho no canto superior direito do mapa</li>
                            <li>Para editar uma rota existente, clique na opção "Editar camadas"</li>
                            <li>Para criar uma nova rota, use a opção "Desenhar polyline"</li>
                            <li>Você pode apagar e redesenhar a rota utilizando o botão "Deletar camadas"</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="sticky top-4 bg-white shadow-md rounded-lg p-4 border border-gray-200 h-full">
                <div id="map" class="h-[600px] rounded-lg shadow-md border border-gray-200"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

    

    <script>
        // Inicializa o mapa
        const map = L.map('map').setView([39.5, -8.0], 7);

        // Adiciona a camada de mapa base
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Inicializa a camada de desenho
        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        // Configura os controles de desenho
        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                poly: {
                    allowIntersection: false
                }
            },
            draw: {
                polygon: false,
                rectangle: false,
                circle: false,
                circlemarker: false,
                marker: false,
                polyline: {
                    shapeOptions: {
                        color: 'blue',
                        weight: 5,
                        opacity: 0.7
                    }
                }
            }
        });
        map.addControl(drawControl);

        // Carrega as coordenadas existentes da rota
        const coordenadas = @json(json_decode($rota['coordenadas']));
        
        let currentPolyline = null;
        
        // Exibe a rota existente se houver coordenadas
        if (coordenadas && coordenadas.length > 0) {
            const latlngs = coordenadas.map(coord => [coord.lat, coord.lng]);
            
            // Ajusta o mapa para mostrar toda a rota
            const bounds = L.latLngBounds(latlngs);
            map.fitBounds(bounds);
            
            // Adiciona a polyline ao mapa
            currentPolyline = L.polyline(latlngs, {
                color: 'blue',
                weight: 5,
                opacity: 0.7
            }).addTo(drawnItems);
            
            // Adiciona marcadores de início e fim
            L.marker(latlngs[0]).addTo(drawnItems).bindPopup("Início da Rota");
            L.marker(latlngs[latlngs.length - 1]).addTo(drawnItems).bindPopup("Fim da Rota");
        }
        
        // Função para calcular a distância em quilômetros entre dois pontos
        function calcDistance(latlng1, latlng2) {
            return map.distance(latlng1, latlng2) / 1000; // Converte de metros para km
        }
        
        // Função para calcular a distância total da rota
        function calculateTotalDistance(latlngs) {
            let totalDistance = 0;
            
            for (let i = 0; i < latlngs.length - 1; i++) {
                totalDistance += calcDistance(latlngs[i], latlngs[i + 1]);
            }
            
            return totalDistance.toFixed(2); // Arredonda para 2 casas decimais
        }
        
        // Função para serializar as coordenadas para o formato esperado pela API
        function serializeCoordinates(latlngs) {
            return latlngs.map(latlng => {
                return { lat: latlng.lat, lng: latlng.lng };
            });
        }
        
        // Evento quando uma camada é criada (nova rota desenhada)
        map.on('draw:created', function(e) {
            // Remove a polyline existente
            drawnItems.clearLayers();
            
            // Adiciona a nova camada
            const layer = e.layer;
            drawnItems.addLayer(layer);
            currentPolyline = layer;
            
            // Obtém as coordenadas
            const latlngs = layer.getLatLngs();
            
            // Calcula e atualiza a distância
            const distance = calculateTotalDistance(latlngs);
            document.getElementById('distancia').value = distance;
            
            // Atualiza o campo oculto de coordenadas
            const serializedCoords = serializeCoordinates(latlngs);
            document.getElementById('coordenadas').value = JSON.stringify(serializedCoords);
            
            // Adiciona marcadores de início e fim
            L.marker(latlngs[0]).addTo(drawnItems).bindPopup("Início da Rota");
            L.marker(latlngs[latlngs.length - 1]).addTo(drawnItems).bindPopup("Fim da Rota");
        });
        
        // Evento quando uma camada é editada
        map.on('draw:edited', function(e) {
            const layers = e.layers;
            
            layers.eachLayer(function(layer) {
                if (layer instanceof L.Polyline) {
                    const latlngs = layer.getLatLngs();
                    
                    // Calcula e atualiza a distância
                    const distance = calculateTotalDistance(latlngs);
                    document.getElementById('distancia').value = distance;
                    
                    // Atualiza o campo oculto de coordenadas
                    const serializedCoords = serializeCoordinates(latlngs);
                    document.getElementById('coordenadas').value = JSON.stringify(serializedCoords);
                    
                    // Atualiza os marcadores de início e fim
                    drawnItems.eachLayer(function(marker) {
                        if (marker instanceof L.Marker) {
                            drawnItems.removeLayer(marker);
                        }
                    });
                    
                    L.marker(latlngs[0]).addTo(drawnItems).bindPopup("Início da Rota");
                    L.marker(latlngs[latlngs.length - 1]).addTo(drawnItems).bindPopup("Fim da Rota");
                }
            });
        });
        
        // Evento quando uma camada é excluída
        map.on('draw:deleted', function(e) {
            // Limpa o valor da distância e coordenadas
            document.getElementById('distancia').value = "0";
            document.getElementById('coordenadas').value = "[]";
        });
        
        // Atualiza o campo de coordenadas com os valores iniciais
        if (coordenadas && coordenadas.length > 0) {
            const latlngs = coordenadas.map(coord => L.latLng(coord.lat, coord.lng));
            const distance = calculateTotalDistance(latlngs);
            document.getElementById('distancia').value = distance;
            document.getElementById('coordenadas').value = JSON.stringify(coordenadas);
        }
        
        // Submete o formulário quando ele for enviado
        document.getElementById('rotaForm').addEventListener('submit', function(e) {
            // Se não houver coordenadas, impede o envio
            if (!document.getElementById('coordenadas').value || document.getElementById('coordenadas').value === "[]") {
                e.preventDefault();
                alert("Por favor, desenhe uma rota no mapa antes de salvar.");
            }
        });
    </script>
    
</x-layout>