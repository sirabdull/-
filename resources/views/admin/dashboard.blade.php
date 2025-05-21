<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Stats Overview -->
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Properties</p>
                        <h3 class="text-2xl font-bold">{{ \App\Models\Property::count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Available Properties</p>
                        <h3 class="text-2xl font-bold">{{ \App\Models\Property::where('status', 'available')->count() }}
                        </h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 text-green-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Inquiries</p>
                        <h3 class="text-2xl font-bold">{{ \App\Models\Inquiry::count() }}</h3>
                    </div>
                    <div class="rounded-full bg-yellow-100 p-3 text-yellow-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Locations</p>
                        <h3 class="text-2xl font-bold">{{ \App\Models\Location::count() }}</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 text-purple-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Content -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Recent Inquiries -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Recent Inquiries</h2>
                    <a href="/admin/inquiries" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="space-y-4">
                    @if (\App\Models\Inquiry::count() > 0)
                        @foreach (\App\Models\Inquiry::latest()->take(5)->get() as $inquiry)
                            <div class="flex items-center justify-between border-b pb-2">
                                <div>
                                    <p class="font-medium">{{ $inquiry->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $inquiry->property->title }}</p>
                                </div>
                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-800">{{ $inquiry->status }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No inquiries yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Properties -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Recent Properties</h2>
                    <div class="flex items-center space-x-4">
                        <flux:button href="{{ route('properties.create') }}" size="sm">
                            Add Property
                        </flux:button>
                        <a href="/admin/properties" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                </div>
                <div class="space-y-4">
                    @if (\App\Models\Property::count() > 0)
                        @foreach (\App\Models\Property::latest()->take(5)->get() as $property)
                            <div class="flex items-center justify-between border-b pb-2">
                                <div class="flex items-center space-x-3">
                                    @if ($property->images && count($property->images) > 0)
                                        <img src="{{ Storage::url($property->images[0]) }}" alt="{{ $property->title }}"
                                            class="h-10 w-10 rounded-lg object-cover">
                                    @endif
                                    <div>
                                        <p class="font-medium">{{ $property->title }}</p>
                                        <p class="text-sm text-gray-500">₦{{ number_format($property->price) }}</p>
                                    </div>
                                </div>
                                <span
                                    class="rounded-full px-3 py-1 text-xs {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <p class="mt-2 text-gray-500">No properties added yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
