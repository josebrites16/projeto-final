<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Detalhes da Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">

    <div class="max-w-6xl mx-auto p-4 md:ml-64 ">

        <div class="bg-white shadow-md rounded-lg p-4 mb-4 border border-gray-200">
            <h2 class="font-bold text-lg">{{$rota['titulo']}}</h2>
            <p class="text-gray-600 mt-2"> Descrição: {{ $rota['descricao']}}</p>
            <p class="text-gray-600"> Distância: {{ $rota['distancia']}} km</p>
            <p class="text-gray-600"> Zona: {{ $rota['zona']}}</p>

            <div class="flex flex-col md:flex-row gap-4 mt-4">
                {{-- Imagem --}}
                @if ($rota->imagem)
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="{{ asset('storage/' . $rota->imagem) }}" alt="Imagem da Rota"
                        class="rounded-lg shadow-md border border-gray-200 max-h-[600px] object-cover">
                </div>
                @endif

                {{-- Mapa --}}
                <div class="w-full md:w-1/2">
                    <div id="map" class="h-[600px] rounded-lg shadow-md border border-gray-200 w-full"></div>
                </div>
            </div>
            <div class="mt-4 flex space-x-4 justify-center">
                <a href="/rotas/{{ $rota['id'] }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Editar Rota</a>

                <form action="{{ route('rotas.destroy', $rota->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar esta rota?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar Rota</button>
                </form>
                <a href="/rotas" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar á Lista</a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([39.5, -8.0], 7);


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

            const pontosTuristicos = @json($rota->pontos);

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