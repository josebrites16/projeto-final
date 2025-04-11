<x-layout>
    <x-slot:heading>
        <h1 class="text-2xl font-bold text-center mb-6">Nova FAQ</h1>
    </x-slot:heading>

    <div class="max-w-2xl mx-auto p-4 md:ml-64">
        <form method="POST" action="{{ route('faqs.store') }}" class="space-y-4 bg-white shadow-md p-6 rounded-lg border border-gray-200">
            @csrf

            <div>
                <label class="block font-semibold">Pergunta:</label>
                <input type="text" name="pergunta" class="w-full border border-gray-300 p-2 rounded" required>
            </div>

            <div>
                <label class="block font-semibold">Resposta:</label>
                <textarea name="resposta" class="w-full border border-gray-300 p-2 rounded" rows="4" required></textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
        </form>
    </div>
</x-layout>
