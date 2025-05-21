@php
    $property = App\Models\Property::where('slug', request()->segment(2))->firstOrFail();
@endphp
<x-layouts.web>
    <section>
        <div class="container mx-auto px-4 pt-8">
            <nav class="text-sm">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ url('/') }}" class="text-gray-600 hover:text-primary-600">Home</a>
                        <svg class="w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ url('/properties') }}" class="text-gray-600 hover:text-primary-600">Properties</a>
                        <svg class="w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li class="text-gray-800">{{ $property->name ?? $property->title }}</li>
                </ol>
            </nav>
        </div>
    </section>
    <div class="flex justify-center">
        <livewire:website.properties.property :property="$property" />
    </div>
    @include('components.web.cta')
</x-layouts.web>
