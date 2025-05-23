<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Property;
use App\Models\Location;

new class extends Component {
    use WithPagination;

    public $list_type = 'grid';
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'type' => '',
        'status' => '',
        'price_min' => '',
        'price_max' => '',
        'bedrooms' => '',
        'bathrooms' => '',
        'location' => '',
    ];

    public function toggleListType()
    {
        $this->list_type = $this->list_type === 'grid' ? 'list' : 'grid';
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getPropertiesProperty()
    {
        return Property::query()
            ->when(
                $this->search,
                fn($query) =>
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
            )
            ->when(
                $this->filters['type'],
                fn($query) =>
                $query->where('type', $this->filters['type'])
            )
            ->when(
                $this->filters['status'],
                fn($query) =>
                $query->where('status', $this->filters['status'])
            )
            ->when(
                $this->filters['price_min'],
                fn($query) =>
                $query->where('price', '>=', $this->filters['price_min'])
            )
            ->when(
                $this->filters['price_max'],
                fn($query) =>
                $query->where('price', '<=', $this->filters['price_max'])
            )
            ->when(
                $this->filters['bedrooms'],
                fn($query) =>
                $query->where('bedrooms', $this->filters['bedrooms'])
            )
            ->when(
                $this->filters['bathrooms'],
                fn($query) =>
                $query->where('bathrooms', $this->filters['bathrooms'])
            )
            ->when(
                $this->filters['location'],
                fn($query) =>
                $query->where('location_id', $this->filters['location'])
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);
    }
}; ?>

<div class="bg-white min-h-screen py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div class="w-full sm:w-auto mb-4 sm:mb-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Property Listings</h1>
                <p class="mt-2 text-gray-600 text-base sm:text-lg max-w-2xl">Explore our property listings, use the
                    filters to find properties based on your preferred location or other criteria.</p>
            </div>
            <button wire:click="toggleListType"
                class="cursor-pointer p-2 hover:bg-gray-200 rounded-lg transition-colors">
                @if($list_type === 'grid')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                @endif
            </button>
        </div>
        <div class="mb-8 pb-4">
            <div class="flex flex-col sm:flex-row flex-wrap gap-4">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Search properties..."
                        class="w-full pl-10 border-2 pr-4 py-2 rounded border-gray-200 focus:ring-1 text-sm">
                </div>

                <select wire:model.live="filters.type"
                    class="w-full sm:w-48 px-3 py-2 rounded border-gray-200 focus:ring-1 text-sm">
                    <option value="">All Types</option>
                    <option value="house">House</option>
                    <option value="apartment">Apartment</option>
                    <option value="land">Land</option>
                </select>

                <select wire:model.live="filters.location"
                    class="w-full sm:w-48 px-3 py-2 rounded border-gray-200 focus:ring-1 text-sm">
                    <option value="">All Locations</option>
                    @foreach(Location::all() as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>

                <div x-data="{ advanced: false }" class="relative w-full sm:w-auto">
                    <button @click="advanced = !advanced"
                        class="w-full sm:w-auto cursor-pointer px-3 py-2 text-sm text-black hover:text-[#FFF114] flex items-center justify-between sm:justify-start gap-1">
                        <span>More Filters</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-cloak x-show="advanced" @click.away="advanced = false"
                        class="absolute z-10 mt-2 p-6 bg-white rounded-lg shadow-lg border w-full sm:w-[500px]">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <input wire:model.live="filters.price_min" type="number" placeholder="Min Price"
                                class="w-full border-2 px-4 py-2.5 rounded border-gray-200 focus:ring-1 text-sm">
                            <input wire:model.live="filters.price_max" type="number" placeholder="Max Price"
                                class="w-full border-2 px-4 py-2.5 rounded border-gray-200 focus:ring-1 text-sm">
                            <input wire:model.live="filters.bedrooms" type="number" placeholder="Bedrooms"
                                class="w-full border-2 px-4 py-2.5 rounded border-gray-200 focus:ring-1 text-sm">
                            <input wire:model.live="filters.bathrooms" type="number" placeholder="Bathrooms"
                                class="w-full border-2 px-4 py-2.5 rounded border-gray-200 focus:ring-1 text-sm">
                        </div>
                    </div>
                </div>

                <button wire:click="resetFilters"
                    class="w-full sm:w-auto cursor-pointer px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm transition-colors">
                    Clear Filters
                </button>
            </div>
        </div>

        <div
            class="{{ $list_type === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8' : 'space-y-4 sm:space-y-6' }}">
            @foreach($this->properties as $property)
                <div
                    class="bg-white rounded-lg shadow-lg overflow-hidden {{ $list_type === 'list' ? 'flex flex-col sm:flex-row' : '' }}">
                    <div class="{{ $list_type === 'list' ? 'w-full sm:w-1/3' : 'w-full' }} relative">
                        @if($property->images && count($property->images) > 0)
                            <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}"
                                class="w-full h-48 sm:h-64 object-cover">
                        @endif
                        <div class="absolute top-4 right-4">
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full @if($property->status === 'available') bg-green-100 text-green-800 @elseif($property->status === 'sold') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="{{ $list_type === 'list' ? 'w-full sm:w-2/3' : 'w-full' }} p-4 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2 sm:mb-4">{{ $property->title }}</h3>
                        <div class="flex items-center text-gray-600 mb-2 sm:mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $property->location->name ?? 'Location not set' }}
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-4">
                            ₦{{ number_format($property->price) }}</div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-4 text-sm text-gray-600 mb-4 sm:mb-6">
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
                        <div class="flex space-x-4">
                            <a href="/properties/{{ $property->slug }}"
                                class="flex-1 bg-[#FFF114] hover:bg-yellow-300 text-black px-6 py-2 rounded text-center transition duration-300">
                                View Details
                            </a>
                            <a href="/properties/{{ $property->slug }}"
                                class="flex-1 bg-black hover:bg-gray-800 text-white px-6 py-2 rounded text-center transition duration-300">
                                Make Enquiry
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $this->properties->links() }}
        </div>
    </div>
</div>
