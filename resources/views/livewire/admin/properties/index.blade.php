<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Property;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    use WithPagination;

    public $list_type = 'table';
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
        'city' => '',
        'state' => '',
    ];

    public function mount()
    {
        //
    }

    public function getPropertiesProperty()
    {
        return Property::query()
            ->when($this->search, fn($query) => $query->where('title', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->filters['type'], fn($query) => $query->where('type', $this->filters['type']))
            ->when($this->filters['status'], fn($query) => $query->where('status', $this->filters['status']))
            ->when($this->filters['price_min'], fn($query) => $query->where('price', '>=', $this->filters['price_min']))
            ->when($this->filters['price_max'], fn($query) => $query->where('price', '<=', $this->filters['price_max']))
            ->when($this->filters['bedrooms'], fn($query) => $query->where('bedrooms', $this->filters['bedrooms']))
            ->when($this->filters['bathrooms'], fn($query) => $query->where('bathrooms', $this->filters['bathrooms']))
            ->when($this->filters['city'], fn($query) => $query->where('city', $this->filters['city']))
            ->when($this->filters['state'], fn($query) => $query->where('state', $this->filters['state']))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);
    }

    public function toggleListType()
    {
        $this->list_type = $this->list_type === 'grid' ? 'table' : 'grid';
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
        LivewireAlert::title('Delete Property?')
            ->withConfirmButton('Yes, delete it!')
            ->withCancelButton('Cancel')
            ->onConfirm('confirmDelete', ['property_id' => $id])
            ->timer(6000)
            ->show();
    }

    public function confirmDelete($data)
    {
        $property = Property::find($data['property_id']);
        if ($property) {
            $property->delete();
            LivewireAlert::title('Success')->toast()->text('Property deleted successfully.')->position('top-end')->success()->show();
        } else {
            LivewireAlert::title('Error')->text('Property not found.')->position('top-end')->error()->show();
        }
    }
}; ?>
<div class="w-full mt-10">
    <div class="mb-6 bg-white dark:bg-black rounded-lg shadow-sm p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Properties</h2>
            <div class="flex items-center space-x-4">
                <flux:button.group>
                    <flux:button wire:click="toggleListType" size="sm" icon="table-cells">
                    </flux:button>
                    <flux:button wire:click="toggleListType" size="sm" icon="squares-2x2">
                    </flux:button>
                </flux:button.group>
                <flux:button href="{{ route('properties.create') }}" size="sm">
                    Add Property
                </flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <flux:input wire:model.live="search" size="sm" placeholder="Search..." icon="magnifying-glass"
                kbd="⌘K" />
            <flux:select size="sm" wire:model.live="filters.type" placeholder="Select type">
                <flux:select.option value="">All Types</flux:select.option>
                <flux:select.option value="house">House</flux:select.option>
                <flux:select.option value="apartment">Apartment</flux:select.option>
                <flux:select.option value="land">Land</flux:select.option>
            </flux:select>
            <flux:select size="sm" wire:model.live="filters.status" placeholder="Select status">
                <flux:select.option value="">All Status</flux:select.option>
                <flux:select.option value="available">Available</flux:select.option>
                <flux:select.option value="sold">Sold</flux:select.option>
                <flux:select.option value="rented">Rented</flux:select.option>
            </flux:select>
            <flux:button wire:click="resetFilters" size="sm" variant="danger">
                Reset Filters
            </flux:button>
        </div>

        <div x-data="{ advanced: false }" class="mb-4">
            <flux:button @click="advanced = !advanced" size="sm" variant="primary">
                Advanced Filters
            </flux:button>
            <div x-show="advanced" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="flex space-x-2">
                    <flux:input wire:model.live="filters.price_min" type="number" placeholder="Min Price"
                        size="sm" />
                    <flux:input wire:model.live="filters.price_max" type="number" placeholder="Max Price"
                        size="sm" />
                </div>
                <flux:input wire:model.live="filters.bedrooms" type="number" placeholder="Bedrooms" size="sm" />
                <flux:input wire:model.live="filters.bathrooms" type="number" placeholder="Bathrooms" size="sm" />
                <flux:input wire:model.live="filters.city" type="text" placeholder="City" size="sm" />
                <flux:input wire:model.live="filters.state" type="text" placeholder="State" size="sm" />
            </div>
        </div>
    </div>

    @if ($list_type === 'grid')
        @include('livewire.admin.properties.list.grid', ['properties' => $this->properties])
    @else
        @include('livewire.admin.properties.list.table', ['properties' => $this->properties])
    @endif

    <div class="mt-4">
        {{ $this->properties->links() }}
    </div>
</div>
