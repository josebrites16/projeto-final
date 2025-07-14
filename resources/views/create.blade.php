<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">Criar Rota</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">

    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4 max-h-[600px] overflow-y-auto bg-white p-4 rounded-xl border border-gray-200 shadow-md">
                <div class="bg-white shadow-md rounded-xl p-4 mb-4 border border-gray-200">
                    <h2 class="font-bold text-lg">Nova Rota</h2>
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
                                <label>Midia:</label>
                                <input type="file" id="modal-imagens" multiple class="w-full border p-2" />
                            </div>
                            <div id="modal-imagens-preview" class="mt-2 text-sm text-gray-700 hidden">
                                <label>Midia já adicionadas:</label>
                                <ul class="list-disc list-inside mt-1" id="modal-imagens-list"></ul>
                            </div>
                            <div class="flex justify-end gap-2 mt-4">
                                <button onclick="fecharModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                                <button id="btn-salvar-ponto" type="button" onclick="salvarPonto(event)" class="bg-brown text-white px-4 py-2 rounded">
                                    Guardar
                                </button>
                                <button id="btn-eliminar-ponto" onclick="eliminarPonto()" class="hidden bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                    Eliminar Ponto
                                </button>

                            </div>
                        </div>
                    </div>
                    <form id="rotaForm" action="{{ route('rotas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                            <input type="text" id="titulo" name="titulo" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                            <input type="text" id="descricao" name="descricao" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="descricao_longa" class="block text-gray-700 text-sm font-bold mb-2">
                                Descrição Longa:
                            </label>
                            <textarea
                                id="descricao_longa"
                                name="descricao_longa"
                                rows="6"
                                class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline resize-y"
                                placeholder="Escreva aqui uma descrição detalhada da rota..."></textarea>
                        </div>
                        <div>
                            <label for="zona" class="block text-gray-700 text-sm font-bold mb-2">Zona:</label>
                            <select name="zona" id="zona" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-brown">
                                <option value="">Todas as zonas</option>
                                @foreach($zonas ?? [] as $zonaOption)
                                <option value="{{ $zonaOption }}" {{ ($zona ?? '') == $zonaOption ? 'selected' : '' }}>
                                    {{ $zonaOption }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="imagem" class="block text-gray-700 text-sm font-bold mb-2">Imagem:</label>
                            <input type="file" id="imagem" name="imagem" accept="image/*" class="mb-2">
                            @error('imagem')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="distancia" class="block text-gray-700 text-sm font-bold mb-2">Distância (Km):</label>
                            <input type="text" id="distancia" name="distancia" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" readonly>
                            <p class="text-gray-400 text-sm font-bold mb-2">A distância é calculada automaticamente ao desenhar a rota</p>
                        </div>

                        <input type="hidden" name="coordenadas" id="coordenadas">

                        <div class="flex gap-4">
                            <x-form-button>Criar</x-form-button>
                            <a href="/rotas" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar à Lista</a>
                        </div>
                    </form>
                    <div class="mt-4 p-4 bg-gray-100 rounded-xl">
                        <h3 class="font-medium mb-2">Instruções de Criação:</h3>
                        <ul class="list-disc pl-5 text-sm text-gray-700">
                            <li>Use as ferramentas de desenho no canto superior esquerdo do mapa.</li>
                            <li>A distância total será calculada automaticamente.</li>
                            <li>Após desenhar a rota, clique em "Criar" para armazenar as informações.</li>
                            <li>Para adicionar pontos turísticos, clique no mapa onde deseja adicionar um ponto.</li>
                            <li>Preencha os detalhes do ponto turístico no modal que aparece.</li>
                            <li>Os pontos turísticos preenchidos serão marcados em azul.</li>
                            <li>Pode apagar e redesenhar a rota utilizando o botão "Delete layers".</li>
                            <li>Certifique-se de que a rota está desenhada corretamente antes de salvar.</li>
                            <li>Pode editar ou excluir a rota posteriormente.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
                <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Aviso</h2>
                    <p id="alertMessage" class="text-gray-600 mb-6"></p>
                    <button onclick="hideAlertModal()" class="bg-brown hover:bg-brown-dark text-white px-4 py-2 rounded-lg">OK</button>
                </div>
            </div>

            <!-- Mapa -->
            <div class="sticky top-4 bg-white p-4 rounded-xl border border-gray-200 shadow-md h-[600px]">
                <div id="map" class="h-full rounded-lg border border-gray-300"></div>
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


        ['modalPonto', 'alertModal'].forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.querySelectorAll('input, textarea, select, button').forEach(el => {
                    L.DomEvent.disableClickPropagation(el);
                    L.DomEvent.disableScrollPropagation(el);
                });
            }
        });



        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        let polylineLayer = null;
        let pontosTuristicos = [];
        try {
            const dadosSalvos = JSON.parse(localStorage.getItem('pontosTuristicos')) || [];
            pontosTuristicos = dadosSalvos.map(p => ({
                ...p,
                imagens: []
            }));
        } catch (e) {
            console.warn("JSON inválido no localStorage. Limpando...");
            localStorage.removeItem('pontosTuristicos');
            pontosTuristicos = [];
        }

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
            } catch (e) {
                console.warn("Erro ao salvar no localStorage:", e);
            }
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

            const tituloInput = document.getElementById('modal-titulo');
            const descricaoInput = document.getElementById('modal-descricao');
            const imagensInput = document.getElementById('modal-imagens');
            const imagensPreview = document.getElementById('modal-imagens-preview');
            const imagensList = document.getElementById('modal-imagens-list');


            tituloInput.value = ponto.titulo || '';
            tituloInput.disabled = true;

            descricaoInput.value = ponto.descricao || '';
            descricaoInput.disabled = true;

            imagensInput.disabled = true;
            imagensInput.classList.add('hidden');

            imagensPreview.classList.remove('hidden');
            imagensList.innerHTML = '';

            if (ponto.imagens && ponto.imagens.length > 0) {
                ponto.imagens.forEach(img => {
                    let nome = '';

                    if (typeof img === 'string') {
                        nome = img;
                    } else if (img.name) {
                        nome = img.name;
                    }

                    imagensList.innerHTML += `<li>${nome}</li>`;
                });
            } else {
                imagensList.innerHTML = '<li><em>Sem imagens</em></li>';
            }

            document.getElementById('btn-salvar-ponto').style.display = 'none';
            document.getElementById('btn-salvar-ponto').style.display = 'none';
            document.getElementById('btn-eliminar-ponto').classList.remove('hidden');
        }


        function fecharModal() {
            document.getElementById('modalPonto').style.display = 'none';
            document.getElementById('btn-eliminar-ponto').classList.add('hidden');

        }

        function showAlertModal(message) {
            document.getElementById('alertMessage').textContent = message;
            const modal = document.getElementById('alertModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hideAlertModal() {
            const modal = document.getElementById('alertModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function salvarPonto(e) {
            e.preventDefault();

            const titulo = document.getElementById('modal-titulo').value.trim();
            const descricao = document.getElementById('modal-descricao').value.trim();
            const midias = document.getElementById('modal-imagens').files;

            if (!titulo || !descricao) {
                showAlertModal("Preencha o título e a descrição do ponto turístico.");
                return;
            }

            if (midias.length === 0) {
                showAlertModal("Adicione pelo menos uma mídia (imagem, vídeo ou áudio).");
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
                showAlertModal("Adicione pelo menos uma imagem.");
                return;
            }

            if (videos.length !== 1) {
                showAlertModal("Adicione exatamente um vídeo.");
                return;
            }

            if (audios.length !== 1) {
                showAlertModal("Adicione exatamente um áudio.");
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

            const latlng = L.latLng(lat, lng);
            adicionarMarker(latlng, true, index);
            fecharModal();
            salvarNaSessao();
        }


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
            const layer = e.layer;

            if (e.layerType === 'marker') {
                const latlng = layer.getLatLng();
                adicionarMarker(latlng, false, null);
                return;
            }

            if (e.layerType === 'polyline') {
                const novosPontos = layer.getLatLngs();

                if (polylineLayer) {
                    // Obter os pontos anteriores
                    const antigosPontos = polylineLayer.getLatLngs();
                    const combinados = antigosPontos.concat(novosPontos);

                    // Substituir a polyline anterior pela nova combinada
                    drawnItems.removeLayer(polylineLayer);
                    polylineLayer = L.polyline(combinados, {
                        color: 'blue',
                        weight: 5
                    });
                    drawnItems.addLayer(polylineLayer);

                    document.getElementById('distancia').value = calculateDistance(combinados);
                    document.getElementById('coordenadas').value = JSON.stringify(serializeCoordinates(combinados));
                } else {
                    polylineLayer = layer;
                    drawnItems.addLayer(polylineLayer);

                    document.getElementById('distancia').value = calculateDistance(novosPontos);
                    document.getElementById('coordenadas').value = JSON.stringify(serializeCoordinates(novosPontos));
                }
            }
        });

        map.on('draw:deleted', function(e) {
            polylineLayer = null;
            document.getElementById('distancia').value = '';
            document.getElementById('coordenadas').value = '';
        });

        map.on('draw:edited', function(e) {
            let novaLinha = null;

            e.layers.eachLayer(function(layer) {
                if (layer instanceof L.Polyline && !(layer instanceof L.Polygon)) {
                    novaLinha = layer;
                }
            });

            if (novaLinha) {
                polylineLayer = novaLinha;
                const latlngs = novaLinha.getLatLngs();

                document.getElementById('distancia').value = calculateDistance(latlngs);
                document.getElementById('coordenadas').value = JSON.stringify(serializeCoordinates(latlngs));
            }
        });



        document.getElementById('rotaForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            const titulo = document.getElementById('titulo').value.trim();
            const descricao = document.getElementById('descricao').value.trim();
            const zona = document.getElementById('zona').value.trim();
            const descricaoLonga = document.getElementById('descricao_longa').value.trim();
            const imagem = document.getElementById('imagem').files[0];
            const coordenadas = document.getElementById('coordenadas').value;

            if (!titulo) {
                showAlertModal("Preencha o título e a descrição do ponto turístico.");
                return;
            }
            if (!descricao || !descricaoLonga) {
                showAlertModal("Preencha a descrição e a descrição longa da rota.");
                return;
            }

            if (!zona) {
                showAlertModal("Selecione uma zona para a rota.");
                return;
            }

            if (!imagem) {
                showAlertModal("Adicione uma imagem à rota.");
                return;
            }

            if (!coordenadas) {
                showAlertModal("Desenhe a rota no mapa antes de salvar.");
                return;
            }

            if (pontosTuristicos.length === 0) {
                showAlertModal("Adicione pelo menos um ponto turístico à rota.");
                return;
            }

            pontosTuristicos.forEach((ponto, index) => {
                formData.append(`pontos[${index}][titulo]`, ponto.titulo);
                formData.append(`pontos[${index}][descricao]`, ponto.descricao);
                formData.append(`pontos[${index}][coordenadas]`, JSON.stringify(ponto.coordenadas));

                if (Array.isArray(ponto.imagens)) {
                    ponto.imagens.forEach(img => {
                        formData.append(`pontos[${index}][midias][]`, img);
                    });
                }
            });

            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.redirected) {
                    localStorage.removeItem('pontosTuristicos');
                    window.location.href = response.url;
                } else {
                    alert('Erro ao salvar');
                }
            });
        });

        window.addEventListener('load', () => {
            pontosTuristicos.forEach((ponto, index) => {
                const latlng = L.latLng(ponto.coordenadas.lat, ponto.coordenadas.lng);
                adicionarMarker(latlng, true, index);
            });
        });

        function eliminarPonto() {
            const index = parseInt(document.getElementById('modalPonto').dataset.index);

            if (isNaN(index) || index < 0 || index >= markerRefs.length) {
                showAlertModal("Erro ao eliminar ponto.");
                return;
            }

            // Remover do mapa
            if (markerRefs[index]) {
                drawnItems.removeLayer(markerRefs[index]);
            }


            markerRefs.splice(index, 1);


            if (pontosTuristicos[index]) {
                pontosTuristicos.splice(index, 1);
            }

            salvarNaSessao();
            fecharModal();


            markerRefs.forEach((marker, i) => {
                marker.off();
                marker.on('click', () => {
                    if (pontosTuristicos[i]) {
                        abrirModalVisualizacao(i);
                    } else {
                        abrirModalEdicao(marker.getLatLng(), i);
                    }
                });
            });
        }
    </script>

</x-layout>