<x-layouts.web>
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Our Locations</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach(\App\Models\Location::with('properties')->get() as $location)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="relative h-96">
                            @if($location->images && count($location->images) > 0)
                                <img src="{{ Storage::url($location->images[0]) }}" alt="{{ $location->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                @php
                                    $firstProperty = $location->properties->first();
                                    $propertyImage = $firstProperty && $firstProperty->images ? $firstProperty->images[0] : null;
                                @endphp
                                @if($propertyImage)
                                    <img src="{{ Storage::url($propertyImage) }}" alt="{{ $location->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                @endif
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                                <h2 class="text-3xl font-bold text-white">{{ $location->name }}</h2>
                                <p class="text-gray-200 mt-2">{{ $location->description }}</p>
                                <div class="mt-4 flex items-center text-white">
                                    <span class="text-lg">{{ $location->properties->count() }} Properties Available</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white">
                            @if($location->google_map_link)
                                <a href="{{ $location->google_map_link }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    View on Google Maps
                                </a>
                            @endif
                            <a href="/properties?location={{ $location->id }}"
                                class="mt-4 w-full bg-[#FFF114] hover:bg-yellow-300 text-black px-6 py-3 rounded text-center block transition duration-300">
                                View Properties
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('components.web.cta')
</x-layouts.web>
