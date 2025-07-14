<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-extrabold text-center mb-6 text-black tracking-wide">Criar Administrador</h1>
    </x-slot:heading>

    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        @if ($errors->has('email'))
        <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                <h2 class="text-lg font-bold text-red-700 mb-4">Erro ao criar administrador</h2>
                <p class="text-gray-600 mb-6">{{ $errors->first('email') }}</p>
                <div class="flex justify-center">
                    <button onclick="hideErrorModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Fechar</button>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200 w-full max-w-2xl">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Novo Administrador</h2>

            <form action="/register" method="POST" class="space-y-5">
                @csrf

                <x-form-field>
                    <x-form-label for="first_name">Primeiro Nome:</x-form-label>
                    <x-form-input id="first_name" name="first_name" required />
                    <x-form-error name="first_name" />
                </x-form-field>

                <x-form-field>
                    <x-form-label for="last_name">Último Nome:</x-form-label>
                    <x-form-input id="last_name" name="last_name" required />
                    <x-form-error name="last_name" />
                </x-form-field>

                <x-form-field>
                    <x-form-label for="email">Email:</x-form-label>
                    <x-form-input type="email" id="email" name="email" required />
                    <x-form-error name="email" />
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password">Password:</x-form-label>
                    <x-form-input type="password" id="password" name="password" required />
                    <x-form-error name="password" />
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password_conf">Confirmar Password:</x-form-label>
                    <x-form-input type="password" id="password_confirmation" name="password_confirmation" required />
                    <x-form-error name="password_confirmation" />
                </x-form-field>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="/rotas" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">Cancelar</a>
                    <x-form-button class="bg-brown x-5 py-2 rounded-lg transition font-medium shadow-md">Criar</x-form-button>
                </div>
            </form>
        </div>
    </div>
    <script>
    function hideErrorModal() {
        const modal = document.getElementById('errorModal');
        if (modal) modal.style.display = 'none';
    }
</script>
</x-layout>