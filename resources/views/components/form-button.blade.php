<button {{ $attributes->merge(['class' => 'bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600', 'type' => 'submit' ]) }}>
    {{ $slot }}
</button>