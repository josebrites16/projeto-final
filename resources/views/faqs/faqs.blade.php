<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">Perguntas frequentes</h1>
    </x-slot:heading>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Container centralizado -->
    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Botão "Adicionar FAQ" com ícone apenas -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('faqs.create') }}" class="bg-brown text-white px-4 py-2 rounded hover:bg-brown-dark transition text-lg">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <!-- Lista de FAQs -->
        <div class="space-y-4">
            @forelse($faqs as $faq)
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Pergunta e resposta -->
                <div>
                    <h2 class="font-semibold text-lg text-brown">{{ $faq->pergunta }}</h2>
                    <p class="text-gray-700 mt-2">{{ $faq->resposta }}</p>
                </div>

                <!-- Ícones de ação -->
                <div class="flex gap-2 text-xl self-end md:self-auto">
                    <a href="{{ route('faqs.edit', $faq->id) }}" class="text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form id="deleteForm-{{ $faq->id }}" action="{{ route('faqs.destroy', $faq->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showDeleteModal {{ $faq->id }})" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>

                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200 text-center text-gray-500">
                Não existem FAQs no momento.
            </div>
            @endforelse
        </div>
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Confirmar eliminação</h2>
                <p class="text-gray-600 mb-6">Tem a certeza que deseja eliminar esta FAQ?</p>
                <div class="flex justify-center gap-4">
                    <button id="confirmDeleteBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Eliminar</button>
                    <button onclick="hideModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let deleteFormId = null;

        function showDeleteModal(id) {
            deleteFormId = 'deleteForm-' + id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function hideModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
            if (deleteFormId) {
                document.getElementById(deleteFormId).submit();
            }
        });
    </script>

</x-layout>