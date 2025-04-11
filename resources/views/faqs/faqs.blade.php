<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-6">Perguntas Frequentes</h1>
    </x-slot:heading>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-4xl mx-auto p-4 md:ml-64">

        <!-- Botão "Adicionar FAQ" com ícone apenas -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('faqs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-lg">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <!-- Lista de FAQs -->
        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <!-- Pergunta e resposta -->
                    <div>
                        <h2 class="font-semibold text-lg text-blue-600">{{ $faq->pergunta }}</h2>
                        <p class="text-gray-700 mt-2">{{ $faq->resposta }}</p>
                    </div>

                    <!-- Ícones de ação -->
                    <div class="flex gap-2 text-xl self-end md:self-auto">
                        <a href="{{ route('faqs.edit', $faq->id) }}" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST"
                              onsubmit="return confirm('Tem a certeza que deseja eliminar esta FAQ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</x-layout>
