<x-layout>
    <x-slot:heading>
        <h1 class="text-2xl font-bold text-center mb-6">Editar Ponto Turístico</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <!-- Caixa principal -->
    <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-lg p-6">

        <form method="POST" action="{{ route('pontos.update', ['ponto' => $ponto->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Formulário com scroll -->
                <div class="overflow-y-auto max-h-[600px] pr-2">
                    <!-- Título -->
                    <div class="mb-4">
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $ponto->titulo) }}" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-brown">
                    </div>

                    <!-- Descrição -->
                    <div class="mb-4">
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Descrição</label>
                        <textarea name="descricao" rows="4"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-brown">{{ old('descricao', $ponto->descricao) }}</textarea>
                    </div>

                    <input type="hidden" name="coordenadas" id="coordenadas" value="{{ old('coordenadas', $ponto->coordenadas) }}">

                    <!-- Mídias Existentes -->
                    @if ($ponto->midias->count())
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-700 mb-2">Mídias Existentes</h3>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach ($ponto->midias as $midia)
                            <div class="relative border rounded p-2">
                                @if ($midia->tipo === 'imagem')
                                <img src="{{ asset('storage/' . $midia->caminho) }}" class="w-full h-32 object-cover rounded">
                                @elseif ($midia->tipo === 'video')
                                <video controls class="w-full h-32 rounded">
                                    <source src="{{ asset('storage/' . $midia->caminho) }}" type="video/mp4">
                                </video>
                                @elseif ($midia->tipo === 'audio')
                                <audio controls class="w-full mt-6">
                                    <source src="{{ asset('storage/' . $midia->caminho) }}" type="audio/mpeg">
                                </audio>
                                @endif
                                <div class="absolute top-2 right-2">
                                    <input type="checkbox" name="remover_midias[]" value="{{ $midia->id }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Marque as mídias que deseja remover.</p>
                    </div>
                    @endif

                    <!-- Upload novas mídias -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-700 mb-2">Adicionar Novas Mídias</h3>
                        <label class="block text-sm font-medium text-gray-700">Imagens</label>
                        <input type="file" name="imagens[]" multiple accept="image/*" class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mt-4">Vídeos</label>
                        <input type="file" name="videos[]" multiple accept="video/*" class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mt-4">Áudios</label>
                        <input type="file" name="audios[]" multiple accept="audio/*" class="mb-2">
                    </div>
                </div>

                <!-- Mapa + Instruções -->
                <div class="flex flex-col justify-between">
                    <!-- Mapa -->
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-4">Localização do Ponto</h2>
                        <div id="map" class="w-full h-[500px] rounded border"></div>
                    </div>

                    <!-- Instruções -->
                    <div class="p-4 bg-gray-100 rounded-xl">
                        <h3 class="font-medium mb-2">Instruções:</h3>
                        <ul class="list-disc pl-5 text-sm text-gray-700">
                            <li>Arraste o marcador para alterar a localização do ponto turístico.</li>
                            <li>As coordenadas serão atualizadas automaticamente.</li>
                            <li>Depois, clique em "Guardar Alterações".</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-center gap-4 mt-8">
                <button type="submit" class="bg-brown text-white px-6 py-2 rounded hover:bg-brown-dark">
                    Salvar Alterações
                </button>
                <a href="{{ route('rotas.show', $rota->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Script do mapa -->
    <script>
        const ponto = @json($ponto);
        const coords = JSON.parse(ponto.coordenadas || '{"lat": 39.5, "lng": -8.0}');

        const map = L.map('map').setView([coords.lat, coords.lng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([coords.lat, coords.lng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            const pos = marker.getLatLng();
            document.getElementById('coordenadas').value = JSON.stringify({
                lat: pos.lat,
                lng: pos.lng
            });
        });
    </script>
</x-layout>
