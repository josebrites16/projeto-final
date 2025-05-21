<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-6">Criar Administrador</h1>
    </x-slot:heading>

    <div class="max-w-3xl mx-auto p-6 md:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
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
                    <x-form-button>Criar</x-form-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
