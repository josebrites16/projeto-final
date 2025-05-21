<x-layout>
    <x-slot:heading>
        <h1 class="text-2xl font-bold text-center mb-4">Lista de Administradores</h1>
    </x-slot:heading>

    <!-- Fonte para envelope-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-4xl mx-auto p-4 md:ml-64">
        <!-- pesquisa -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-6 border border-gray-200">
            <form action="{{ route('users.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Pesquisar utilizador...">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if(count($users) > 0)
                @foreach($users as $user)
                @if($user->tipo === 'admin')
                    <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                        <a href="/users/{{ $user['id'] }}" class="text-blue-500 hover:underline hover:text-blue-700">
                            <h2 class="text-lg font-semibold">{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
                        </a>
                        <p class="text-gray-600 mt-1"><i class="fas fa-envelope text-gray-500 mr-1"></i>{{ $user['email'] }}</p>
                    </div>
                @endif
                @endforeach
            @else
                <div class="text-center py-8 col-span-2">
                    <p class="text-gray-500">Nenhum administrador encontrado.</p>
                </div>
            @endif
        </div>
    </div>
</x-layout>
