<x-layout>
    <x-slot:heading>
        Lista de Users
    </x-slot:heading>

    <ul>
        @foreach($users as $user)
        <li>
            <a href="/users/{{ $user['id'] }}" class="text-blue-500 hover:underline hover:text-blue-700 ">
                <strong>{{ $user['first_name'] }} {{ $user['last_name'] }}: </strong> {{$user['email']}}
            </a>
        </li>
        @endforeach
    </ul>
</x-layout>