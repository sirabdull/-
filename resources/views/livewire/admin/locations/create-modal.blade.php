<?php

use Livewire\Volt\Component;
use App\Models\Location;
use Spatie\LivewireFilepond\WithFilePond;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;

new class extends Component {
    use WithFilePond;

    public $showModal = false;
    public $mode = 'create';
    public Location $location;
    public $form = [
        'name' => '',
        'type' => 'city',
        'description' => '',
        'latitude' => null,
        'longitude' => null,
        'google_map_link' => '',
        'address' => '',
        'postal_code' => '',
        'country' => '',
        'state' => '',
        'city' => '',
        'street' => '',
        'neighborhood' => '',
        // tempImages is used to temporarily store files during upload process
        'tempImages' => [],
        // images stores the final paths of successfully uploaded images
        'images' => [],
    ];

    protected function rules()
    {
        return [
            'form.name' => 'required|string|max:255',
            'form.type' => 'required|in:city,state,country',
            'form.description' => 'nullable|string',
            'form.latitude' => 'nullable|numeric',
            'form.longitude' => 'nullable|numeric',
            'form.google_map_link' => 'nullable|string',
            'form.address' => 'nullable|string',
            'form.postal_code' => 'nullable|string',
            'form.country' => 'nullable|string',
            'form.state' => 'nullable|string',
            'form.city' => 'nullable|string',
            'form.street' => 'nullable|string',
            'form.neighborhood' => 'nullable|string',
            // Validate that temporary images are actual image files and not too big
            'form.tempImages.*' => 'nullable|image|max:2048',
            // Validate that final images array exists
            'form.images' => 'nullable|array',
        ];
    }

    // This function runs whenever new images are uploaded through the file input
    public function updatedFormTempImages()
    {
        try {
            // Make sure tempImages is always an array
            if (!is_array($this->form['tempImages'])) {
                $this->form['tempImages'] = [$this->form['tempImages']];
            }

            // Store each uploaded image and save their paths
            $paths = [];
            foreach ($this->form['tempImages'] as $image) {
                if ($image) {
                    // Save image in 'public/locations' folder and get its path
                    $path = $image->store('locations', 'public');
                    $paths[] = $path;
                }
            }

            // Add new image paths to existing images array
            $this->form['images'] = array_merge($this->form['images'] ?? [], $paths);
            // Clear temporary images after they're processed
            $this->form['tempImages'] = [];
        } catch (\Exception $e) {
            $this->showNotification('error', 'Error: ' . $e->getMessage());
        }
    }

    // Function to remove an image at specific index
    public function removeImage($index)
    {
        if (isset($this->form['images'][$index])) {
            $imagePath = $this->form['images'][$index];
            // Delete actual file from storage
            if (\Storage::disk('public')->exists($imagePath)) {
                \Storage::disk('public')->delete($imagePath);
            }
            // Remove path from images array
            unset($this->form['images'][$index]);
            // Re-index array to prevent gaps
            $this->form['images'] = array_values($this->form['images']);
        }
    }

    public function save()
    {
        $validated = $this->validate()['form'];
        $validated['slug'] = \Str::slug($validated['name']);

        // Clean up images array before saving
        $validated['images'] = array_values($validated['images'] ?? []);
        // Remove temporary images data as it's not needed in database
        unset($validated['tempImages']);

        try {
            if ($this->mode === 'edit') {
                // When editing, check which images were removed
                $oldImages = $this->location->images ?? [];
                $newImages = $validated['images'];
                // Find images that exist in old but not in new
                $removedImages = array_diff($oldImages, $newImages);

                // Delete removed images from storage
                foreach ($removedImages as $image) {
                    if (\Storage::disk('public')->exists($image)) {
                        \Storage::disk('public')->delete($image);
                    }
                }

                $this->location->update($validated);
            } else {
                $this->location = Location::create($validated);
            }

            $this->dispatch('locationCreated');
            $this->showNotification('success', $this->mode === 'edit' ? 'Location updated!' : 'Location created!');

            if ($this->mode === 'create') {
                $this->reset('form');
            }
        } catch (\Exception $e) {
            $this->showNotification('error', 'Error: ' . $e->getMessage());
        }
    }


    #[On('open-location-modal')]
    public function openModal($mode, Location $location = null)
    {
        $this->mode = $mode;
        $this->showModal = true;

        if ($mode === 'edit' && $location) {
            $this->location = $location;
            $this->form = $location->toArray();
            $this->form['images'] = $location->images ?? [];
            $this->form['tempImages'] = [];
        } else {
            $this->location = new Location();
            $this->form['images'] = [];
            $this->form['tempImages'] = [];
        }
    }

    private function showNotification($type, $message)
    {
        LivewireAlert::title($message)
                    ->position('top-end')
            ->$type()
                ->show();
    }

    public function hideModal()
    {
        $this->showModal = false;
        $this->reset();
    }
}; ?>
<div>
    <div x-cloak wire:show="showModal" class="fixed inset-0 bg-gray-500/75 transition-opacity z-50 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div
            class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0 overflow-y-auto">
            <div class="fixed inset-0 transition-opacity bg-transparent bg-opacity-75" aria-hidden="true"
                wire:click="hideModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div
                class="overflow-y-auto relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-[600px] sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button"
                        class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none"
                        wire:click="hideModal">
                        <span class="sr-only">Close</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ $mode === 'edit' ? 'Edit Location' : 'Create New Location' }}
                        </flux:heading>
                        <flux:text class="mt-2 mb-2">
                            {{ $mode === 'edit' ? 'Update location details' : 'Add a new location to the property database.' }}
                        </flux:text>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <flux:description>Enter the name of the location</flux:description>
                            <flux:input wire:model.live="form.name" label="Location Name"
                                placeholder="e.g. New York City" required />
                        </div>
                        <div>
                            <flux:description>Select the type of location</flux:description>
                            <flux:select wire:model.live="form.type" label="Location Type" required>
                                <option value="city">City</option>
                                <option value="state">State</option>
                                <option value="country">Country</option>
                            </flux:select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <flux:description>Location description</flux:description>
                        <flux:textarea wire:model.live="form.description" label="Description"
                            placeholder="Describe the location" />
                    </div>

                    <div class="mt-4">
                        <flux:description>Location images</flux:description>
                        <x-filepond::upload wire:model.live="form.tempImages" multiple="true" credits="false" />
                        @error('form.tempImages') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @error('form.images') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <div class="grid grid-cols-4 gap-4 mt-4">
                            @foreach ($form['images'] as $index => $image)
                                <div class="relative">
                                    <img src="{{ Storage::url($image) }}" class="w-full h-32 object-cover rounded-lg">
                                    <button wire:click="removeImage({{ $index }})"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <flux:description>Latitude</flux:description>
                            <flux:input wire:model.live="form.latitude" label="Latitude" type="number" step="any" />
                        </div>
                        <div>
                            <flux:description>Longitude</flux:description>
                            <flux:input wire:model.live="form.longitude" label="Longitude" type="number" step="any" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <flux:description>Google Maps Link</flux:description>
                        <flux:input wire:model.live="form.google_map_link" label="Google Map Link" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <flux:description>Address</flux:description>
                            <flux:input wire:model.live="form.address" label="Address" />
                        </div>
                        <div>
                            <flux:description>Postal Code</flux:description>
                            <flux:input wire:model.live="form.postal_code" label="Postal Code" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <flux:description>Country</flux:description>
                            <flux:input wire:model.live="form.country" label="Country" />
                        </div>
                        <div>
                            <flux:description>State</flux:description>
                            <flux:input wire:model.live="form.state" label="State" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <flux:description>City</flux:description>
                            <flux:input wire:model.live="form.city" label="City" />
                        </div>
                        <div>
                            <flux:description>Street</flux:description>
                            <flux:input wire:model.live="form.street" label="Street" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <flux:description>Neighborhood</flux:description>
                        <flux:input wire:model.live="form.neighborhood" label="Neighborhood" />
                    </div>

                    <div class="flex justify-end space-x-3 mt-4">
                        <flux:button variant="danger" wire:click="hideModal">Cancel</flux:button>
                        <flux:button type="submit" variant="primary">
                            {{ $mode === 'edit' ? 'Update Location' : 'Create Location' }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>