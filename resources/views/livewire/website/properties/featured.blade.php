<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $perPage = 6;
    public $selectedProperty = null;
    public $showModal = false;

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function showDetails($propertyId)
    {
        $this->selectedProperty = \App\Models\Property::find($propertyId);
        $this->showModal = true;
    }

    public function with(): array
    {
        return [
            'properties' => \App\Models\Property::with('location')
                ->take($this->perPage)
                ->get()
        ];
    }
}; ?>

<div class="py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center justify-between gap-6 mb-8 md:flex-row">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Featured Properties</h2>
                <p class="mt-2 text-gray-600">Discover our handpicked selection of premium properties</p>
            </div>
            <a href="/properties"
                class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-300 bg-black rounded-full hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                View All Properties
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
            @foreach($properties as $property)
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 overflow-hidden w-full max-w-sm rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="relative h-48 sm:h-40">
                        @if($property->images && count($property->images) > 0)
                            <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full
                                        @if($property->status === 'available') bg-green-100 text-green-800
                                        @elseif($property->status === 'sold') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3 line-clamp-2">
                            {{ $property->title }}
                        </h3>
                        <div class="flex items-center text-gray-500 dark:text-gray-400 mb-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $property->location->name ?? 'Location not set' }}
                        </div>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 space-y-2 sm:space-y-0">
                            <span
                                class="text-2xl font-bold text-gray-900 dark:text-white">₦{{ number_format($property->price) }}</span>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">{{ ucfirst($property->type) }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-sm text-gray-500 dark:text-gray-400">
                            @if($property->bedrooms)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ $property->bedrooms }} Beds
                                </div>
                            @endif
                            @if($property->bathrooms)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    {{ $property->bathrooms }} Baths
                                </div>
                            @endif
                            @if($property->area)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    {{ number_format($property->area) }} sq ft
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                            <button wire:click="showDetails({{ $property->id }})"
                                class="w-full cursor-pointer bg-black hover:bg-gray-800 text-white py-2 px-4 rounded flex items-center justify-center transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Quick View
                            </button>
                            <a href="/properties/{{ $property->slug }}"
                                class="w-full bg-[#FFF114] hover:bg-yellow-300 text-black py-2 px-4 rounded text-center transition duration-300">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($properties) >= $perPage)
            <div class="text-center mt-8">
                <button wire:click="loadMore"
                    class="w-full sm:w-auto bg-[#FFF114] text-black px-6 py-2 rounded hover:bg-yellow-300 transition duration-300">
                    Load More Properties
                </button>
            </div>
        @endif <!-- Property Details Modal -->
        @if($showModal && $selectedProperty)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div
                    class="flex items-center justify-center min-h-screen px-2 sm:px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-black bg-opacity-40 transition-opacity"></div> <span
                        class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                    <div
                        class="relative inline-block align-bottom bg-white text-left overflow-hidden border border-gray-200 transform transition-all sm:my-8 sm:align-middle w-full max-w-[95%] sm:max-w-5xl">
                        <div class="bg-white px-4 sm:px-6 pt-4 sm:pt-6 pb-4 sm:pb-6">
                            <div class="flex flex-col sm:flex-row sm:items-start">
                                <div class="mt-2 sm:mt-0 text-left w-full">
                                    <div
                                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6">
                                        <h3 class="text-2xl sm:text-3xl leading-6 font-semibold text-gray-900"
                                            id="modal-title">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                                {{ $selectedProperty->title }}
                                                <span
                                                    class="inline-block px-3 py-1 text-sm {{ $selectedProperty->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                                                    {{ ucfirst($selectedProperty->status) }}
                                                </span>
                                            </div>
                                        </h3>
                                    </div>
                                    <div class="mt-4">
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                                            <div x-data="{
                                                                                    images: {{ json_encode($selectedProperty->images ?? []) }},
                                                                                    activeSlide: 0,
                                                                                    prev() { this.activeSlide = this.activeSlide === 0 ? this.images.length - 1 : this.activeSlide - 1 },
                                                                                    next() { this.activeSlide = this.activeSlide === this.images.length - 1 ? 0 : this.activeSlide + 1 }
                                                                                }" class="relative">
                                                <template x-if="images.length > 0">
                                                    <div class="relative h-64 sm:h-96">
                                                        <template x-for="(image, index) in images" :key="index">
                                                            <div x-show="activeSlide === index" class="absolute inset-0">
                                                                <img :src="'/storage/' + image" :alt="'Property Image ' + (index + 1)" class="w-full h-full object-cover">
                                                            </div>
                                                        </template>
                                                        <button @click="prev"
                                                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 sm:p-2 rounded-full">
                                                            <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 19l-7-7 7-7" />
                                                            </svg>
                                                        </button>
                                                        <button @click="next"
                                                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 sm:p-2 rounded-full">
                                                            <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="space-y-4 sm:space-y-6">
                                                <div class="flex items-start space-x-2">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500 flex-shrink-0"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p class="text-sm sm:text-base text-gray-600">
                                                        {{ $selectedProperty->description }}
                                                    </p>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-xs sm:text-sm text-gray-500">Price</p>
                                                            <p class="font-semibold text-base sm:text-lg">
                                                                ₦{{ number_format($selectedProperty->price) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-xs sm:text-sm text-gray-500">Type</p>
                                                            <p class="font-semibold text-base sm:text-lg">
                                                                {{ ucfirst($selectedProperty->type) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-xs sm:text-sm text-gray-500">Bedrooms</p>
                                                            <p class="font-semibold text-base sm:text-lg">
                                                                {{ $selectedProperty->bedrooms }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-xs sm:text-sm text-gray-500">Bathrooms</p>
                                                            <p class="font-semibold text-base sm:text-lg">
                                                                {{ $selectedProperty->bathrooms }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2 col-span-1 sm:col-span-2">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-500 flex-shrink-0"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-xs sm:text-sm text-gray-500">Location</p>
                                                            <p class="font-semibold text-base sm:text-lg">
                                                                {{ $selectedProperty->location->name }},
                                                                {{ $selectedProperty->location->city }},
                                                                {{ $selectedProperty->location->state }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-4">
                            <a href="/properties/{{ $selectedProperty->slug }}/enquiry"
                                class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 hover:bg-blue-700 flex items-center justify-center space-x-2 mb-2 sm:mb-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <span>Make Enquiry</span>
                            </a>
                            <a href="/properties/{{ $selectedProperty->slug }}/book-tour"
                                class="w-full sm:w-auto bg-green-600 text-white px-6 py-2 hover:bg-green-700 flex items-center justify-center space-x-2 mb-2 sm:mb-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Book a Tour</span>
                            </a>
                            <a href="/properties/{{ $selectedProperty->slug }}/virtual-tour"
                                class="w-full sm:w-auto bg-purple-600 text-white px-6 py-2 hover:bg-purple-700 flex items-center justify-center space-x-2 mb-2 sm:mb-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Virtual Tour</span>
                            </a>
                            <button type="button"
                                class="w-full sm:w-auto bg-[#FFF114] text-black px-6 py-2 hover:bg-yellow-300 flex items-center justify-center space-x-2"
                                wire:click="$set('showModal', false)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Close</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
