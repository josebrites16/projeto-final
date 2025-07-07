<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">
            {{ $user->tipo === 'admin' ? 'Detalhes do Administrador' : 'Detalhes do Utilizador' }}
        </h1>
    </x-slot:heading>

    <!-- Fonte-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="max-w-4xl mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg p-6 mb-4 border border-gray-200">
            <h2 class="text-xl font-bold mb-2">{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
            <p class="text-gray-700"><i class="fas fa-envelope text-gray-500 mr-2"></i>Email: {{ $user['email'] }}</p>
        </div>

        <div class="mt-4 flex space-x-4 justify-center">
            @if(auth()->user()->id !== $user->id)
            <form id="deleteForm" action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" onclick="showDeleteModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    {{ $user->tipo === 'admin' ? 'Eliminar Administrador' : 'Eliminar Utilizador' }}
                </button>
            </form>
            @endif
            @if($user->tipo === 'user')
            <form action="{{ route('users.updateType', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipo" value="admin">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tornar Administrador</button>
            </form>
            @endif
        </div>
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Confirmar eliminação</h2>
                <p class="text-gray-600 mb-6">
                    Tem a certeza que deseja eliminar este {{ $user->tipo === 'admin' ? 'administrador' : 'utilizador' }}?
                </p>
                <div class="flex justify-center gap-4">
                    <button onclick="confirmDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Eliminar</button>
                    <button onclick="hideModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hideModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmDelete() {
            document.getElementById('deleteForm').submit();
        }
    </script>


</x-layout>