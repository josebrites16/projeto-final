<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center mb-6">Login</h1>
    </x-slot:heading>

    <div class="max-w-3xl mx-auto p-6 md:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Login</h2>

            <form  action="/login" method="POST" class="space-y-5">
                @csrf
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

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="/rotas" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">Cancelar</a>
                    <x-form-button>Login</x-form-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
