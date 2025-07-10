@if ($paginator->hasPages())
    <nav class="text-center mt-4">
        @foreach ($paginator->links() as $link)
            <a
                href="{{ $link['url'] ?? '#' }}"
                class="inline-block py-2 px-3 rounded-lg text-black text-xs
                    {{ $link['active'] ? 'bg-gray-200' : '' }}
                    {{ !$link['url'] ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gray-100' }}"
                {!! !$link['url'] ? 'aria-disabled=true' : '' !!}
                {!! $link['active'] ? 'aria-current=page' : '' !!}
            >
                {!! $link['label'] !!}
            </a>
        @endforeach
    </nav>
@endif
