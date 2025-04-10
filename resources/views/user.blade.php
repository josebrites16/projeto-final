<x-layout>
    <x-slot:heading>
        User
    </x-slot:heading>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"

   <h2 class= "font-bold text-lg">{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
   <p>Email: {{ $user['email']}}</p>
</x-layout>