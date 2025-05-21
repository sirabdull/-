<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($properties as $property)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden max-w-xs">
            <div class="relative h-40">
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
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($property->status === 'available') bg-green-100 text-green-800
                                    @elseif($property->status === 'sold') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($property->status) }}
                    </span>
                </div>
            </div>
            <div class="p-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $property->title }}</h3>
                <div class="flex items-center text-gray-500 dark:text-gray-400 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $property->location->name ?? 'Location not set' }}
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span
                        class="text-2xl font-bold text-gray-900 dark:text-white">₦{{ number_format($property->price) }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($property->type) }}</span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    @if($property->bedrooms)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            {{ $property->bedrooms }} Beds
                        </div>
                    @endif
                    @if($property->bathrooms)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            {{ $property->bathrooms }} Baths
                        </div>
                    @endif
                    @if($property->area)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            {{ number_format($property->area) }} sq ft
                        </div>
                    @endif
                </div>
            </div>
            <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-2">
                    <flux:button href="{{ route('properties.edit', $property) }}" size="sm">
                        Edit
                    </flux:button>
                    <flux:button wire:click="delete({{ $property->id }})" size="sm" variant="danger">
                        Delete
                    </flux:button>
                </div>
            </div>
        </div>
    @endforeach
</div>
