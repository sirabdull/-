<?php

use Livewire\Volt\Component;
use Spatie\LivewireFilepond\WithFilePond;
use App\Models\Config;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFilePond;

    public $banner_images = [];
    public $tempImages = [];

    public Config $config;

    public function mount()
    {
        $this->config = Config::first() ?? new Config();
        $this->banner_images = $this->config->banner_images ?? [];
    }

    public function updatedTempImages()
    {
        $paths = [];
        foreach ($this->tempImages as $image) {
            $paths[] = $image->store('banner-images', 'public');
        }

        $this->banner_images = array_merge($this->banner_images ?? [], $paths);

        $this->config->banner_images = $this->banner_images;
        $this->config->save();

        $this->tempImages = [];
    }

    public function removeImage($index)
    {
        $imageToDelete = $this->banner_images[$index];
        Storage::disk('public')->delete($imageToDelete);

        unset($this->banner_images[$index]);
        $this->banner_images = array_values($this->banner_images);

        $this->config->banner_images = $this->banner_images;
        $this->config->save();
    }
}; ?>
<div>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <h2 class="text-lg font-medium text-gray-900">
                Advertisement Posters
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Upload advertisement posters that will be displayed throughout the site to promote products, services,
                or special offers. These images will be used to engage users and highlight promotional content.
            </p>

            <div class="mt-4">
                <x-filepond::upload wire:model="tempImages" multiple="true" credits="false" />
            </div>

            @if(count($banner_images) > 0)
                <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($banner_images as $index => $image)
                        <div class="relative">
                            <img src="{{ Storage::url($image) }}" class="w-full h-32 object-cover rounded-lg">
                            <button wire:click="removeImage({{ $index }})"
                                class="absolute cursor-pointer top-0 right-0 p-1 bg-red-500 text-white rounded-full m-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


</div>
