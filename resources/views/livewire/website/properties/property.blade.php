<?php

use Livewire\Volt\Component;

new class extends Component {
    public $property;
    public $activeImage = 0;
    public $showShareModal = false;
    public $showEnquiryForm = false;

    public function mount($property)
    {
        $this->property = $property;
    }

    public function printProperty()
    {
        $this->dispatch('print-property');
    }
}; ?>

<div class="bg-white min-h-screen py-6 sm:py-12" x-data="{ activeImage: 0 }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div class="w-full sm:w-auto mb-4 sm:mb-0">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $property->status === 'Available' ? 'bg-green-100 text-green-800' : ($property->status === 'Soldout' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }} animate-pulse">
                        {{ $property->status }}
                    </span>
                </div>
                <div class="flex items-center text-gray-600 mt-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $property->location->name }}, {{ $property->location->city }}, {{ $property->location->state }}
                </div>
            </div>
            <div class="flex space-x-4">
                <button wire:click="printProperty"
                    class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition-colors cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </button>
                <button wire:click="$toggle('showShareModal')"
                    class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition-colors cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="relative h-[500px] rounded-xl overflow-hidden">
                    @if ($property->images && count($property->images) > 0)
                        @foreach ($property->images as $index => $image)
                            <div x-show="activeImage === {{ $index }}" class="absolute inset-0">
                                <img src="{{ Storage::url($image) }}" alt="{{ $property->title }}"
                                    class="w-full h-full object-cover">

                            </div>
                        @endforeach
                        <button
                            @click="activeImage = activeImage > 0 ? activeImage - 1 : {{ count($property->images) - 1 }}"
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            @click="activeImage = activeImage < {{ count($property->images) - 1 }} ? activeImage + 1 : 0"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endif
                </div>

                <div class="mt-8 grid grid-cols-4 gap-4">
                    @if ($property->images)
                        @foreach ($property->images as $index => $image)
                            <div @click="activeImage = {{ $index }}"
                                class="cursor-pointer rounded-lg overflow-hidden"
                                :class="{ 'ring-2 ring-[#FFF114]': activeImage === {{ $index }} }">
                                <img src="{{ Storage::url($image) }}" alt="{{ $property->title }}"
                                    class="w-full h-24 object-cover">
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold mb-4">Property Details</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Bedrooms</p>
                                <p class="font-semibold">{{ $property->bedrooms }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Bathrooms</p>
                                <p class="font-semibold">{{ $property->bathrooms }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Area</p>
                                <p class="font-semibold">{{ number_format($property->area) }} sq ft</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Type</p>
                                <p class="font-semibold">{{ ucfirst($property->type) }}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-8 border-gray-200">
                    <div class="prose max-w-none">
                        <h3 class="text-xl font-semibold mb-4">Description</h3>
                        <p class="text-gray-600">{{ $property->description }}</p>
                    </div>
                    <hr class="my-8 border-gray-200">
                    @if ($property->features && count($property->features) > 0)
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold mb-4">Features</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($property->features as $feature => $value)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">
                                            @if (is_bool($value))
                                                {{ $feature }}
                                            @else
                                                {{ $feature }}: {{ $value }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <hr class="my-8 border-gray-200 px-4">

                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Location Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($property->location->address)
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 mt-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Address</p>
                                        <p class="text-gray-700">{{ $property->location->address }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($property->location->neighborhood)
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 mt-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Neighborhood</p>
                                        <p class="text-gray-700">{{ $property->location->neighborhood }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($property->location->city)
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 mt-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">City</p>
                                        <p class="text-gray-700">{{ $property->location->city }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($property->location->state)
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 mt-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">State</p>
                                        <p class="text-gray-700">{{ $property->location->state }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($property->location->country)
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 mt-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Country</p>
                                        <p class="text-gray-700">{{ $property->location->country }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($property->location->postal_code)
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 mt-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Postal Code</p>
                                        <p class="text-gray-700">{{ $property->location->postal_code }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($property->location->google_map_link)
                            <div class="mt-4">
                                <a href="{{ $property->location->google_map_link }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    <span>View on Google Maps</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-6" x-data="{ activeForm: null }">
                    <div class="bg-gray-50 rounded-xl p-6 mb-6 shadow-lg backdrop-blur-sm">
                        <div class="text-3xl font-bold text-gray-900 mb-4">₦{{ number_format($property->price) }}
                        </div>
                        <div class="space-y-4">
                            <button @click="activeForm = 'enquiry'"
                                class="cursor-pointer group w-full bg-[#FFF114] hover:bg-yellow-300 text-black px-4 md:px-6 py-3 rounded-lg transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 shadow-md hover:shadow-xl flex items-center justify-center space-x-2">
                                <span class="text-sm md:text-base">Make Enquiry</span>
                                <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                            <button @click="activeForm = 'tour'"
                                class="cursor-pointer group w-full bg-black hover:bg-gray-800 text-white px-4 md:px-6 py-3 rounded-lg transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 shadow-md hover:shadow-xl flex items-center justify-center space-x-2">
                                <span class="text-sm md:text-base">Book a Tour</span>
                                <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div x-show="activeForm === 'enquiry'" x-transition.opacity class="animate-fade-in">
                        <livewire:website.properties.property-enquiry-form :property="$property" />
                    </div>
                    <div x-show="activeForm === 'tour'" x-transition.opacity class="animate-fade-in">
                        <livewire:website.properties.property-tour-form :property="$property" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
