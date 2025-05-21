@php
    $segments = request()->segments();
    $url = '';
@endphp

<div class="flex items-center space-x-2 py-4">
    <a href="/" class="text-gray-600 hover:text-gray-900">Home</a>
    @foreach($segments as $segment)
        @php
            $url .= '/' . $segment;
        @endphp
        <span class="text-gray-400">/</span>
        @if(!$loop->last)
            <a href="{{ $url }}" class="text-gray-600 hover:text-gray-900">{{ ucfirst($segment) }}</a>
        @else
            <span class="text-gray-900">{{ ucfirst($segment) }}</span>
        @endif
    @endforeach
</div>
