@php
    use App\Models\Property;
@endphp
<x-layouts.app>
    <x-breadcrubs />
    <flux:heading size="xl" level="1">Properties</flux:heading>
    <flux:text class="mb-6 mt-2 text-base">Manage your property listings here</flux:text>
    <flux:separator variant="subtle" />

    @if(request()->is('admin/properties/create'))
        <livewire:admin.properties.create />
    @elseif(request()->is('admin/properties/view/*'))
        <livewire:admin.properties.view :property="request()->segment(4)" />
    @elseif(request()->is('admin/properties/edit/*'))
        <livewire:admin.properties.create mode="edit" :property="Property::findOrFail(request()->segment(4))" />
    @else
        <livewire:admin.properties.index />
    @endif
</x-layouts.app>