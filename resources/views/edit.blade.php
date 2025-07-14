<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Editar Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">

    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4 max-h-[600px] overflow-y-auto bg-white p-4 rounded-xl border border-gray-200 shadow-md">
                <div class="bg-white shadow-md rounded-xl p-4 mb-4 border border-gray-200">
                    <h2 class="font-bold text-lg">Editar Rota</h2>
                    <div id="modalPonto" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-md w-96">
                            <h2 class="text-xl font-bold mb-4">Adicionar Ponto Turístico</h2>
                            <input type="hidden" id="modal-index">
                            <div class="mb-2">
                                <label>Título:</label>
                                <input type="text" id="modal-titulo" class="w-full border rounded p-2" />
                            </div>
                            <div class="mb-2">
                                <label>Descrição:</label>
                                <textarea id="modal-descricao" class="w-full border rounded p-2"></textarea>
                            </div>
                            <div class="mb-2">
                                <input type="file" id="modal-imagens" multiple class="w-full border p-2" />
                            </div>
                            <div id="modal-imagens-preview" class="mt-2 text-sm text-gray-700 hidden">
                                <ul class="list-disc list-inside mt-1" id="modal-imagens-list"></ul>
                            </div>
                            <div class="flex justify-end gap-2 mt-4">
                                <button onclick="fecharModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                                <button id="btn-salvar-ponto" type="button" onclick="salvarPonto(event)" class="bg-brown text-white px-4 py-2 rounded">Guardar</button>
                                <button id="btn-eliminar-ponto" onclick="eliminarPonto()" class="hidden bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Eliminar Ponto</button>
                            </div>
                        </div>
                    </div>

                    <form id="rotaForm" action="{{ route('rotas.update', $rota->id) }}" method="POST" enctype="multipart/form-data">

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
                            <label for="descricao_longa" class="block text-gray-700">Descrição Longa:</label>
                            <textarea name="descricao_longa" id="descricao_longa" rows="6" class="border border-gray-300 rounded-lg p-2 w-full">{{ $rota->descricaoLonga }}</textarea>
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
                            <label for="imagem" class="block text-gray-700">Imagem:</label>
                            <input type="file" class="border border-gray-300 rounded-lg p-2 w-full" id="imagem" name="imagem">
                            @error('imagem')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror

                            @if ($rota->imagem)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Imagem atual:</p>
                                <img src="{{ asset('storage/' . $rota->imagem) }}" alt="Imagem da rota" class="w-48 h-auto rounded shadow-md mt-1">
                            </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="distancia" class="block text-gray-700">Distância (km):</label>
                            <input type="text" name="distancia" id="distancia" value="{{ $rota->distancia }}" readonly class="border border-gray-300 rounded-lg p-2 w-full bg-gray-100">
                            <p class="text-gray-400 text-sm font-bold mb-2">A distância é calculada automaticamente ao desenhar a rota</p>
                        </div>
                        <input type="hidden" name="coordenadas" id="coordenadas" value="">
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar Alterações</button>
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
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        let polylineLayer = null;
        let pontosTuristicos = [];



        const markerRefs = [];

        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: false,
                rectangle: false,
                circle: false,
                marker: true,
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

        function salvarNaSessao() {
            try {
                const dadosParaSalvar = pontosTuristicos.map(p => ({
                    titulo: p.titulo,
                    descricao: p.descricao,
                    coordenadas: p.coordenadas
                }));
                localStorage.setItem('pontosTuristicos', JSON.stringify(dadosParaSalvar));
            } catch (e) {}
        }

        function adicionarMarker(latlng, preenchido = false, pontoIndex = null) {
            const cor = preenchido ? 'blue' : 'gray';
            const marker = L.circleMarker(latlng, {
                color: cor,
                fillColor: cor,
                fillOpacity: 1,
                radius: 8
            }).addTo(drawnItems);

            const index = markerRefs.length;
            markerRefs.push(marker);

            marker.on('click', () => {
                if (preenchido && pontoIndex !== null) {
                    abrirModalVisualizacao(pontoIndex);
                } else {
                    abrirModalEdicao(latlng, index);
                }
            });

            return index;
        }

        function abrirModalEdicao(latlng, markerIndex) {
            const modal = document.getElementById('modalPonto');
            modal.style.display = 'flex';
            modal.dataset.lat = latlng.lat;
            modal.dataset.lng = latlng.lng;
            modal.dataset.index = markerIndex;

            document.getElementById('modal-titulo').value = '';
            document.getElementById('modal-descricao').value = '';
            document.getElementById('modal-imagens').value = '';
            document.getElementById('modal-titulo').disabled = false;
            document.getElementById('modal-descricao').disabled = false;
            document.getElementById('btn-salvar-ponto').style.display = 'inline-block';
            document.getElementById('modal-imagens-preview').classList.add('hidden');
            document.getElementById('modal-imagens-list').innerHTML = '';
            document.getElementById('modal-imagens').classList.remove('hidden');
            document.getElementById('modal-imagens').disabled = false;
            document.getElementById('modal-imagens').value = '';
            document.getElementById('btn-eliminar-ponto').classList.remove('hidden');
        }

        function abrirModalVisualizacao(index) {
            const ponto = pontosTuristicos[index];
            const modal = document.getElementById('modalPonto');
            modal.style.display = 'flex';

            modal.dataset.lat = ponto.coordenadas.lat;
            modal.dataset.lng = ponto.coordenadas.lng;
            modal.dataset.index = index;

            document.getElementById('modal-titulo').value = ponto.titulo || '';
            document.getElementById('modal-descricao').value = ponto.descricao || '';

            // Desativa inputs
            document.getElementById('modal-titulo').disabled = true;
            document.getElementById('modal-descricao').disabled = true;
            document.getElementById('modal-imagens').disabled = true;

            // Oculta a secção de imagens
            document.getElementById('modal-imagens').classList.add('hidden');
            document.getElementById('modal-imagens-preview').classList.add('hidden');

            // Mostra botões relevantes
            document.getElementById('btn-salvar-ponto').style.display = 'none';
            document.getElementById('btn-eliminar-ponto').classList.remove('hidden');
        }


        function fecharModal() {
            document.getElementById('modalPonto').style.display = 'none';
            document.getElementById('btn-eliminar-ponto').classList.add('hidden');
        }

        function salvarPonto(e) {
            e.preventDefault();

            const titulo = document.getElementById('modal-titulo').value.trim();
            const descricao = document.getElementById('modal-descricao').value.trim();
            const midias = document.getElementById('modal-imagens').files;

            if (!titulo || !descricao) {
                alert("Preencha o título e a descrição do ponto turístico.");
                return;
            }

            if (midias.length === 0) {
                alert("Adicione pelo menos uma mídia (imagem, vídeo ou áudio).");
                return;
            }

            let imagens = [],
                videos = [],
                audios = [];

            for (let i = 0; i < midias.length; i++) {
                const file = midias[i];
                if (file.type.startsWith("image")) imagens.push(file);
                else if (file.type.startsWith("video")) videos.push(file);
                else if (file.type.startsWith("audio")) audios.push(file);
            }

            if (imagens.length < 1) {
                alert("Adicione pelo menos uma imagem.");
                return;
            }

            if (videos.length !== 1) {
                alert("Adicione exatamente um vídeo.");
                return;
            }

            if (audios.length !== 1) {
                alert("Adicione exatamente um áudio.");
                return;
            }

            const lat = parseFloat(document.getElementById('modalPonto').dataset.lat);
            const lng = parseFloat(document.getElementById('modalPonto').dataset.lng);
            const index = parseInt(document.getElementById('modalPonto').dataset.index);

            const ponto = {
                titulo,
                descricao,
                imagens: Array.from(midias),
                coordenadas: {
                    lat,
                    lng
                }
            };

            pontosTuristicos[index] = ponto;

            drawnItems.removeLayer(markerRefs[index]);
            adicionarMarker(L.latLng(lat, lng), true, index);

            fecharModal();
            salvarNaSessao();
        }


        function eliminarPonto() {
            const index = parseInt(document.getElementById('modalPonto').dataset.index);
            if (markerRefs[index]) drawnItems.removeLayer(markerRefs[index]);
            markerRefs.splice(index, 1);
            pontosTuristicos.splice(index, 1);
            salvarNaSessao();
            fecharModal();
        }

        function calculateDistance(latlngs) {
            let total = 0;
            for (let i = 0; i < latlngs.length - 1; i++) {
                total += map.distance(latlngs[i], latlngs[i + 1]) / 1000;
            }
            return total.toFixed(2);
        }

        function serializeCoordinates(latlngs) {
            return latlngs.map(latlng => ({
                lat: latlng.lat,
                lng: latlng.lng
            }));
        }

        map.on('draw:created', function(e) {
            const layer = e.layer;

            if (e.layerType === 'marker') {
                const latlng = layer.getLatLng();
                adicionarMarker(latlng, false, null);
                return;
            }

            if (e.layerType === 'polyline') {
                const latlngs = layer.getLatLngs();
                if (polylineLayer) drawnItems.removeLayer(polylineLayer);
                polylineLayer = layer;
                drawnItems.addLayer(polylineLayer);

                document.getElementById('distancia').value = calculateDistance(latlngs);
                document.getElementById('coordenadas').value = JSON.stringify(serializeCoordinates(latlngs));
            }
        });

        map.on('draw:deleted', () => {
            polylineLayer = null;
            document.getElementById('distancia').value = '';
            document.getElementById('coordenadas').value = '';
        });

        map.on('draw:edited', function(e) {
            e.layers.eachLayer(layer => {
                if (layer instanceof L.Polyline) {
                    const latlngs = layer.getLatLngs();
                    document.getElementById('distancia').value = calculateDistance(latlngs);
                    document.getElementById('coordenadas').value = JSON.stringify(serializeCoordinates(latlngs));
                }
            });
        });

        window.addEventListener('load', () => {
            const pontosBD = @json($rota -> pontos);
            pontosTuristicos.length = 0;
            markerRefs.length = 0;
            drawnItems.clearLayers();

            pontosBD.forEach((ponto) => {
                const coords = typeof ponto.coordenadas === "string" ?
                    JSON.parse(ponto.coordenadas) :
                    ponto.coordenadas;

                const pontoObj = {
                    id: ponto.id, // <- ID do ponto existente
                    titulo: ponto.titulo,
                    descricao: ponto.descricao,
                    coordenadas: coords,
                    imagens: ponto.midias?.map(m => m.caminho) || [],
                    existente: true // <- Marca que vem do BD
                };

                const index = pontosTuristicos.length;
                pontosTuristicos.push(pontoObj);
                adicionarMarker(L.latLng(coords.lat, coords.lng), true, index);
            });


            const coordenadas = @json(json_decode($rota -> coordenadas));
            if (coordenadas.length > 0) {
                const latlngs = coordenadas.map(coord => L.latLng(coord.lat, coord.lng));
                const linha = L.polyline(latlngs, {
                    color: 'blue',
                    weight: 5
                }).addTo(drawnItems);
                polylineLayer = linha;
                document.getElementById('distancia').value = calculateDistance(latlngs);
                document.getElementById('coordenadas').value = JSON.stringify(coordenadas);
                map.fitBounds(linha.getBounds());
            }
        });

        document.getElementById('rotaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            const titulo = document.getElementById('titulo').value.trim();
            const descricao = document.getElementById('descricao').value.trim();
            const descricaoLonga = document.getElementById('descricao_longa').value.trim();
            const zona = document.getElementById('zona').value.trim();
            const imagem = document.getElementById('imagem').files[0];
            const coordenadas = document.getElementById('coordenadas').value;

            if (!titulo || !descricao || !descricaoLonga || !zona || !coordenadas || pontosTuristicos.length === 0) {
                alert("Preencha todos os campos obrigatórios e adicione pelo menos um ponto turístico.");
                return;
            }

            if (imagem) formData.append('imagem', imagem);

            pontosTuristicos.forEach((ponto, index) => {
                formData.append(`pontos[${index}][titulo]`, ponto.titulo);
                formData.append(`pontos[${index}][descricao]`, ponto.descricao);
                formData.append(`pontos[${index}][coordenadas]`, JSON.stringify(ponto.coordenadas));

                if (ponto.id) {
                    formData.append(`pontos[${index}][id]`, ponto.id);
                }

                // Só envia mídias se forem novas (não strings)
                if (!ponto.existente || ponto.imagens.some(i => typeof i !== 'string')) {
                    ponto.imagens.forEach(img => {
                        if (typeof img !== 'string') {
                            formData.append(`pontos[${index}][midias][]`, img);
                        }
                    });
                }
            });


            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(res => {
                if (res.redirected) {
                    localStorage.removeItem('pontosTuristicos');
                    window.location.href = res.url;
                } else {
                    alert("Erro ao salvar rota.");
                }
            });
        });
    </script>
</x-layout>