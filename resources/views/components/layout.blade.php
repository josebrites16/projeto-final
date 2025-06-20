<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
  <div class="min-h-full">
    <nav class="bg-gray-800 relative">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            @if (!request()->is('login'))
            <!-- Sidebar fixa -->
            <div class="hidden md:flex fixed left-0 top-0 h-screen w-64 bg-gray-800 flex-col p-4 space-y-2">
              <div class="mb-4">
                <img class="size-10" alt="Logo">
              </div>
              <!-- Sidebar Links -->´
              @auth
              <x-nav-link href="/users" :active="request()->is('users')">Users</x-nav-link>
              <x-nav-link href="/admins" :active="request()->is('admins')">Administradores</x-nav-link>
              <x-nav-link href="/rotas" :active="request()->is('rotas')">Rotas</x-nav-link>
              <x-nav-link href="/rotas/create" :active="request()->is('rotas/create')">Criar Rota</x-nav-link>
              <x-nav-link href="/register" :active="request()->is('register')">Criar Administrador</x-nav-link>
              <x-nav-link href="/faqs" :active="request()->is('faqs')">FAQ</x-nav-link>
              @endauth


            </div>
            @endif
            <div class="hidden md:block">
              <div class="ml-4 flex items-center md:ml-6">
                @auth
                <div class="flex items-center space-x-4 absolute right-4 top-1/2 -translate-y-1/2 z-10">


                  <!-- Profile dropdown -->
                  <div class="relative inline-block text-left">
                    <button id="profile-button" type="button" class="h-10 w-10 rounded-full overflow-hidden border-2 border-white shadow focus:outline-none focus:ring-2 focus:ring-white">
                      <img class="h-full w-full object-cover" src="https://laracasts.com/images/lary-ai-face.svg" alt="Avatar">
                    </button>

                    <!-- Dropdown menu -->
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                      <div class="py-2 px-4 text-sm text-gray-700">
                        <p><strong>{{ Auth::user()->name }}</strong></p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                      </div>
                      <div class="border-t border-gray-100"></div>
                      <form method="POST" action="/logout" class="px-4 py-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-800 text-sm">Logout</button>
                      </form>
                    </div>
                  </div>

                </div>

                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const button = document.getElementById('profile-button');
                    const dropdown = document.getElementById('profile-dropdown');

                    button.addEventListener('click', function(e) {
                      e.preventDefault();
                      dropdown.classList.toggle('hidden');
                    });

                    document.addEventListener('click', function(e) {
                      if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                      }
                    });
                  });
                </script>
                @endauth

              </div>
              <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden" aria-controls="mobile-menu" aria-expanded="false">
                  <span class="absolute -inset-0.5"></span>
                  <span class="sr-only">Open main menu</span>
                  <!-- Menu open: "hidden", Menu closed: "block" -->
                  <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                  </svg>
                  <!-- Menu open: "block", Menu closed: "hidden" -->
                  <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
    </nav>

    <header class="bg-white shadow-sm w-full">
      <div class="@if (!request()->is('login')) md:ml-64 @endif">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $heading }}</h1>
        </div>
      </div>
    </header>

    <main>
      <div class="@if (!request()->is('login')) md:ml-64 @endif">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          {{ $slot }}
        </div>
      </div>
    </main>
  </div>

</body>

</html>