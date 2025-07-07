<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Bem-vindo</h1>
    </x-slot:heading>

    <div class="max-w-md mx-auto px-6">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Login</h2>

            <form action="/login" method="POST" class="space-y-6">
                @csrf

                <x-form-field>
                    <x-form-label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</x-form-label>
                    <x-form-input type="email" id="email" name="email" :value="old('email')" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    <x-form-error name="email" />
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</x-form-label>
                    <x-form-input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    <x-form-error name="password" />
                </x-form-field>

                <div class="flex items-center justify-between pt-4">
                    <a href="/rotas" class="text-sm text-gray-500 hover:text-gray-700 transition">Cancelar</a>
                    <x-form-button class="bg-brown x-5 py-2 rounded-lg transition font-medium shadow-md">Entrar</x-form-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
