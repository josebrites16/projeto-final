<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-4">Detalhes do Utilizador</h1>
    </x-slot:heading>

    <!-- Fonte-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-4xl mx-auto p-4 md:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6 mb-4 border border-gray-200">
            <h2 class="text-xl font-bold mb-2">{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
            <p class="text-gray-700"><i class="fas fa-envelope text-gray-500 mr-2"></i>Email: {{ $user['email'] }}</p>
        </div>

        <div class="mt-4 flex space-x-4 justify-center">
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar este utilizador?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar Utilizador</button>
            </form>
            <a href="/users" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar à Lista</a>
            <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tornar administrador</a> <!-- adicionar na tabela de users is_admin -->
        </div>
    </div>

    
</x-layout>
