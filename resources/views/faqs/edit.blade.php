<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">Editar FAQ</h1>
    </x-slot:heading>

    <div class="max-w-6xl mx-auto px-4 py-6">
        <form method="POST" action="{{ route('faqs.update', $faq->id) }}" class="space-y-4 bg-white shadow-md p-6 rounded-lg border border-gray-200">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Pergunta:</label>
                <input type="text" name="pergunta" value="{{ old('pergunta', $faq->pergunta) }}"
                       class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Resposta:</label>
                <textarea name="resposta" class="w-full border border-gray-300 p-2 rounded" rows="4" required>{{ old('resposta', $faq->resposta) }}</textarea>
            </div>

           <x-form-button>Salvar Alterações</x-form-button>
        </form>
        </div>
</x-layout>
