<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Location;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    use WithPagination;
    // public Location $locations;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $mode = 'create';
    public $location = null;
    public $showModal = false;
    public $selectedLocation = null;
    public $filters = [
        'type' => '',
        'city' => '',
        'state' => '',
        'country' => '',
        'neighborhood' => '',
    ];

    public function mount()
    {
        $this->query = Location::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->filters['type'], fn($query) => $query->where('type', $this->filters['type']))
            ->when($this->filters['city'], fn($query) => $query->where('city', $this->filters['city']))
            ->when($this->filters['state'], fn($query) => $query->where('state', $this->filters['state']))
            ->when($this->filters['country'], fn($query) => $query->where('country', $this->filters['country']))
            ->when($this->filters['neighborhood'], fn($query) => $query->where('neighborhood', $this->filters['neighborhood']))
            ->orderBy($this->sortField, $this->sortDirection);
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



    public function openModal($mode, $location = null)
    {
        $this->mode = $mode;
        $this->selectedLocation = $location;
        $this->showModal = true;
    }
}; ?>
<div class="w-full mt-10">
    <x-breadcrubs />
    <flux:heading size="xl" level="1">Locations</flux:heading>
    <flux:text class="mb-6 mt-2 text-base">Manage your location listings here</flux:text>
    <flux:separator variant="subtle" />

    <livewire:admin.locations.list :query="$this->query" />

</div>
