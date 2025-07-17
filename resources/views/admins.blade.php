<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">Lista de Administradores</h1>
    </x-slot:heading>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-4xl mx-auto px-4 py-6">
        <!-- pesquisa -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-6 border border-gray-200">
            <form action="{{ route('admins.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown"
                    placeholder="Pesquisar Administrador...">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($users as $user)
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                <a href="/users/{{ $user['id'] }}" class="text-brown hover:underline hover:text-brown-dark">
                    <h2 class="text-lg font-semibold">{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
                </a>
                <p class="text-gray-600 mt-1">
                    <i class="fas fa-envelope text-gray-500 mr-1"></i>{{ $user['email'] }}
                </p>
            </div>
            @empty
            <div class="text-center py-8 col-span-2">
                <p class="text-gray-500">Nenhum administrador encontrado.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6 flex justify-center">
            {{ $users->links() }}
        </div>

    </div>
</x-layout>