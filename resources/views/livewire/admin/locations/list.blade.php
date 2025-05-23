<?php

use Livewire\Volt\Component;
use Illuminate\Support\Collection;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Pagination\LengthAwarePaginator;
new class extends Component {

    public $selectedLocation = null;

    public $sortField = 'created_at';
    public $sortDirection = 'asc';
    public $search = '';
    public $filters = [
        'type' => '',
        'city' => '',
        'state' => '',
        'country' => '',
        'neighborhood' => '',
    ];

    public function mount()
    {

    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }



    public function delete($id)
    {
        LivewireAlert::title('Delete Location?')
            ->withConfirmButton('Yes, delete it!')
            ->withCancelButton('Cancel')
            ->onConfirm('confirmDelete', ['location_id' => $id])
            ->timer(6000)
            ->show();
    }

    public function confirmDelete($data)
    {
        $location = Location::find($data['location_id']);
        if ($location) {
            $location->delete();
            LivewireAlert::title('Success')->toast()->text('Location deleted successfully.')->position('top-end')->success()->show();
        } else {
            LivewireAlert::title('Error')->text('Location not found.')->position('top-end')->error()->show();
        }
    }

    public function render(): mixed
    {
        $query = Location::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->filters['type'], fn($query) => $query->where('type', $this->filters['type']))
            ->when($this->filters['city'], fn($query) => $query->where('city', $this->filters['city']))
            ->when($this->filters['state'], fn($query) => $query->where('state', $this->filters['state']))
            ->when($this->filters['country'], fn($query) => $query->where('country', $this->filters['country']))
            ->when($this->filters['neighborhood'], fn($query) => $query->where('neighborhood', $this->filters['neighborhood']))
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.locations.list', [
            'locations' => $query->paginate(12),
        ]);
    }

}; ?>

<div>
    <div class="mb-6 bg-white dark:bg-black rounded-lg shadow-sm p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <flux:input wire:model.live="search" size="sm" placeholder="Search..." icon="magnifying-glass" kbd="⌘K" />
            <flux:select size="sm" wire:model.live="filters.type" placeholder="Select type">
                <flux:select.option value="">All Types</flux:select.option>
                <flux:select.option value="city">City</flux:select.option>
                <flux:select.option value="state">State</flux:select.option>
                <flux:select.option value="country">Country</flux:select.option>
            </flux:select>
            <flux:button wire:click="resetFilters" size="sm" variant="danger">
                Reset Filters
            </flux:button>
            <flux:button class="" @click="$wire.dispatch('open-location-modal', { mode: 'create' })" size="sm"
                variant="primary">
                Create Location
            </flux:button>
        </div>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
        @if($locations->isEmpty())
            <div class="flex flex-col items-center justify-center p-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="mt-2 text-gray-500 dark:text-gray-400">No locations found</p>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Properties Count
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($locations as $location)
                        <tr wire:key="location-{{ $location->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $location->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $location->properties_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click="$wire.dispatch('open-location-modal', { mode: 'edit', location: {{ $location->id }} })"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $location->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $locations->links() }}
            </div>
        @endif
    </div>

    <livewire:admin.locations.create-modal :key="'create-location'" />
</div>