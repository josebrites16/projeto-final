<button {{ $attributes->merge(['class' => 'bg-brown text-white px-4 py-2 rounded hover:bg-brown-dark', 'type' => 'submit' ]) }}>
    {{ $slot }}
</button>