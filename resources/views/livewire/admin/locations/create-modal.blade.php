<?php

use Livewire\Volt\Component;
use App\Models\Location;
use Spatie\LivewireFilepond\WithFilePond;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    use WithFilePond;

    public $name = '';
    public $type = 'city';
    public $description = '';
    public $latitude = null;
    public $longitude = null;
    public $google_map_link = '';
    public $address = '';
    public $postal_code = '';
    public $country = '';
    public $state = '';
    public $city = '';
    public $street = '';
    public $neighborhood = '';
    public $images = [];
    public $tempImages = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:city,state,country',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'google_map_link' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'neighborhood' => 'nullable|string',
            'tempImages.*' => 'nullable|image|max:2048',
        ];
    }

    public function updatedTempImages()
    {
        try {
            $paths = [];
            foreach ($this->tempImages as $image) {
                $paths[] = $image->store('locations', 'public');
            }
            $this->images = array_merge($this->images ?? [], $paths);
        } catch (\Exception $e) {
            $this->addError('images', 'Failed to upload images: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            Location::create([
                'name' => $this->name,
                'type' => $this->type,
                'description' => $this->description,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'google_map_link' => $this->google_map_link,
                'address' => $this->address,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'state' => $this->state,
                'city' => $this->city,
                'street' => $this->street,
                'neighborhood' => $this->neighborhood,
                'images' => $this->images,
                'slug' => \Str::slug($this->name)
            ]);


            LivewireAlert::title('location created successfully')
                ->position('top-end')
                ->success()
                ->show();
            $this->dispatch('locationCreated');
            $this->reset();
        } catch (\Exception $e) {
            LivewireAlert::title('Error: ' . $e->getMessage())
                ->position('top-end')
                ->error()
                ->show();
        }
    }
}; ?>

<div x-data="{ showModal: false }">
    <flux:modal.trigger name="create-location">
        <flux:button class="cursor-pointer" icon="plus" @click="showModal = true">
            Add New Location
        </flux:button>
    </flux:modal.trigger>

    <flux:modal x-show="showModal" name="create-location" class="md:w-[600px]">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Create New Location</flux:heading>
                <flux:text class="mt-2 mb-2">Add a new location to the property database.</flux:text>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <flux:description>Enter the name of the location (e.g. city, state, or country name)
                    </flux:description>
                    <flux:input wire:model.live="name" label="Location Name" placeholder="e.g. New York City"
                        required />
                </div>
                <div>
                    <flux:description>Select the type of location you are adding</flux:description>
                    <flux:select wire:model.live="type" label="Location Type" required>
                        <option value="city">City</option>
                        <option value="state">State</option>
                        <option value="country">Country</option>
                    </flux:select>
                </div>
            </div>

            <div class="mt-4">
                <flux:description>Provide a brief description of this location</flux:description>
                <flux:textarea wire:model.live="description" label="Description"
                    placeholder="Describe the key features of this location" />
            </div>

            <div class="mt-4">
                <flux:description>Upload images representing this location (optional)</flux:description>
                <x-filepond::upload wire:model.live="tempImages" multiple="true" credits="false" />
                @error('tempImages') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('images') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <flux:description>Geographic coordinate (latitude)</flux:description>
                    <flux:input wire:model.live="latitude" label="Latitude" type="number" step="any"
                        placeholder="e.g. 40.7128" />
                </div>
                <div>
                    <flux:description>Geographic coordinate (longitude)</flux:description>
                    <flux:input wire:model.live="longitude" label="Longitude" type="number" step="any"
                        placeholder="e.g. -74.0060" />
                </div>
            </div>

            <div class="mt-4">
                <flux:description>Link to Google Maps location</flux:description>
                <flux:input wire:model.live="google_map_link" label="Google Map Link"
                    placeholder="https://maps.google.com/..." />
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <flux:description>Full street address</flux:description>
                    <flux:input wire:model.live="address" label="Address" placeholder="e.g. 123 Main Street" />
                </div>
                <div>
                    <flux:description>Location postal/zip code</flux:description>
                    <flux:input wire:model.live="postal_code" label="Postal Code" placeholder="e.g. 10001" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <flux:description>Country name</flux:description>
                    <flux:input wire:model.live="country" label="Country" placeholder="e.g. United States" />
                </div>
                <div>
                    <flux:description>State/province name</flux:description>
                    <flux:input wire:model.live="state" label="State" placeholder="e.g. New York" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <flux:description>City name</flux:description>
                    <flux:input wire:model.live="city" label="City" placeholder="e.g. Manhattan" />
                </div>
                <div>
                    <flux:description>Street name</flux:description>
                    <flux:input wire:model.live="street" label="Street" placeholder="e.g. Broadway" />
                </div>
            </div>

            <div class="mt-4">
                <flux:description>Neighborhood or district name</flux:description>
                <flux:input wire:model.live="neighborhood" label="Neighborhood" placeholder="e.g. Upper East Side" />
            </div>

            <div class="flex justify-end space-x-3 mt-4">
                <flux:button variant="danger" x-on:click="$dispatch('close-modal', 'create-location')">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Create Location
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>