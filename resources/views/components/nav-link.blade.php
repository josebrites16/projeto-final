@props(['active' => false])

<a class="block w-full px-4 py-2 text-sm font-medium rounded-md 
    {{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
    aria-current="{{ $active ? 'page' : 'false' }}"
    {{ $attributes }}
>
    {{ $slot }}
</a>