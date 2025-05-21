<?php

use Livewire\Volt\Component;
use App\Models\Property;
use App\Models\Location;
use Spatie\LivewireFilepond\WithFilePond;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    use WithFilePond;

    public $property;
    public $title, $description, $price, $type = 'house', $location_id, $bedrooms,
           $bathrooms, $area, $images = [], $tempImages = [],
           $status = 'available', $features = [], $selected_location = null,
           $existing_locations, $newFeature = '', $newFeatureValue = '';

    public function mount($id) {
        $this->property = Property::findOrFail($id);
        $this->title = $this->property->title;
        $this->description = $this->property->description;
        $this->price = $this->property->price;
        $this->type = $this->property->type;
        $this->selected_location = $this->property->location_id;
        $this->bedrooms = $this->property->bedrooms;
        $this->bathrooms = $this->property->bathrooms;
        $this->area = $this->property->area;
        $this->images = $this->property->images ?? [];
        $this->status = $this->property->status;
        $this->features = $this->property->features ?? [
            'Air Conditioning' => false,
            'Heating' => false,
            'Swimming Pool' => false,
            'Garden' => false,
            'Garage' => false,
            'Security System' => false,
            'Balcony' => false,
            'Furnished' => false,
            'Pet Friendly' => false,
            'Storage' => false
        ];
        $this->existing_locations = Location::select('id', 'name', 'title')->get();
    }

    public function addFeature() {
        if (!empty($this->newFeature) && !empty($this->newFeatureValue)) {
            $this->features[$this->newFeature] = $this->newFeatureValue;
            $this->newFeature = '';
            $this->newFeatureValue = '';
        }
    }

    public function removeFeature($key) {
        unset($this->features[$key]);
    }

    protected function rules() {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:house,apartment,land',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'tempImages.*' => 'nullable|image|max:2048',
            'status' => 'required|in:available,sold,rented',
            'features' => 'nullable|array',
            'selected_location' => 'required'
        ];
    }

    public function updatedTempImages() {
        try {
            $paths = [];
            foreach ($this->tempImages as $image) {
                $paths[] = $image->store('properties', 'public');
            }
            $this->images = array_merge($this->images ?? [], $paths);
        } catch (\Exception $e) {
            $this->addError('images', 'Failed to upload images: ' . $e->getMessage());
        }
    }

    protected $listeners = ['locationCreated' => '$refresh'];

    public function save() {
        try {
            $validatedData = $this->validate();

            \DB::beginTransaction();

            $selectedFeatures = collect($this->features)
                ->filter(function ($value) {
                    return $value === true || !empty($value);
                })
                ->toArray();

            $this->property->update([
                'title' => $this->title,
                'description' => $this->description,
                'price' => $this->price,
                'type' => $this->type,
                'location_id' => $this->selected_location,
                'bedrooms' => $this->bedrooms,
                'bathrooms' => $this->bathrooms,
                'area' => $this->area,
                'images' => $this->images,
                'status' => $this->status,
                'features' => $selectedFeatures,
                'slug' => \Str::slug($this->title . '-' . uniqid())
            ]);

            \DB::commit();

            LivewireAlert::title('Success')
                ->text('Property updated successfully!')
                ->position('top-end')
                ->success()
                ->show();

        } catch (\Exception $e) {
            \DB::rollBack();
            LivewireAlert::title('Error: ' . $e->getMessage())
                ->position('top-end')
                ->error()
                ->show();
        }
    }
}; ?>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" x-data="{ type: @entangle('type'), status: @entangle('status'), featuresOpen: true }">
    <div class="grid grid-cols-2 gap-8">
        <div class="space-y-6">
            <div>
                <flux:description>Enter a descriptive title for the property.</flux:description>
                <flux:input wire:model="title" label="Title" placeholder="e.g. Modern 3 Bedroom Villa" required tabindex="0" id="title" />
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:description>Enter the property price in numeric format.</flux:description>
                <flux:input wire:model="price" type="number" label="Price" placeholder="e.g. 250000" required tabindex="0" id="price" />
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:description>Provide a detailed description of the property.</flux:description>
                <flux:textarea wire:model="description" label="Description"
                    placeholder="Describe the key features, condition, and unique selling points of the property"
                    required tabindex="0" id="description" />
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <flux:description>Number of bedrooms in the property.</flux:description>
                    <flux:input wire:model="bedrooms" type="number" label="Bedrooms" placeholder="e.g. 3" tabindex="0" id="bedrooms" />
                    @error('bedrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:description>Number of bathrooms in the property.</flux:description>
                    <flux:input wire:model="bathrooms" type="number" label="Bathrooms" placeholder="e.g. 2" tabindex="0" id="bathrooms" />
                    @error('bathrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <flux:description>Total area of the property in square feet/meters.</flux:description>
                <flux:input wire:model="area" type="number" label="Area" placeholder="e.g. 1500" tabindex="0" id="area" />
                @error('area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between pt-2 cursor-pointer hover:bg-gray-100" @click="featuresOpen = !featuresOpen">
                    <h3 class="text-lg font-medium text-gray-900">Property Features</h3>
                    <a type="button" @click="featuresOpen = !featuresOpen" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" :class="{ 'transform rotate-180': featuresOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <div x-show="featuresOpen" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($features as $feature => $value)
                        <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50">
                            <flux:checkbox wire:model="features.{{ $feature }}" label="{{ $feature }}" />
                        </label>
                        @endforeach
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <flux:input wire:model="newFeature" label="Custom Feature" placeholder="e.g. Smart Home" />
                        </div>
                        <div class="flex-1">
                            <flux:input wire:model="newFeatureValue" label="Value" placeholder="e.g. Yes" />
                        </div>
                        <button type="button" wire:click="addFeature" class="mt-7 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <h2 class="text-lg font-medium text-gray-900">
                Property Images
            </h2>

            <p class="text-sm text-gray-600">
                Upload images of the property. These images will be displayed in the property listing to give potential
                buyers a better idea of what the property looks like.
            </p>
            <div class="w-2/3">
                <x-filepond::upload wire:model="tempImages" multiple="true" credits="false" tabindex="0" />
                @error('tempImages') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('images') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
              <div class="flex items-center space-x-4">
                <i class="fas fa-home text-gray-500"></i>
                <div class="w-full">
                    <flux:description>Select the type of property listing.</flux:description>
                    <div class="flex space-x-4 mt-2">
                        <button type="button" class="px-4 py-2 rounded-lg border cursor-pointer flex items-center" :class="{ 'bg-blue-500 text-white': type === 'house' }" wire:click="$set('type', 'house')" tabindex="0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            House
                        </button>
                        <button type="button" class="px-4 py-2 rounded-lg border cursor-pointer flex items-center" :class="{ 'bg-blue-500 text-white': type === 'apartment' }" wire:click="$set('type', 'apartment')" tabindex="0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Apartment
                        </button>
                        <button type="button" class="px-4 py-2 rounded-lg border cursor-pointer flex items-center" :class="{ 'bg-blue-500 text-white': type === 'land' }" wire:click="$set('type', 'land')" tabindex="0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Land
                        </button>
                    </div>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <i class="fas fa-tag text-gray-500"></i>
                <div class="w-full">
                    <flux:description>Current availability status of the property.</flux:description>
                    <div class="flex space-x-4 mt-2">
                        <button type="button" class="px-4 py-2 rounded-lg border cursor-pointer flex items-center" :class="{ 'bg-green-500 text-white': status === 'available' }" wire:click="$set('status', 'available')" tabindex="0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 