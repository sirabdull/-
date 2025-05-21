<x-layouts.web>
    <section> <x-hero-section /></section>
    <section>
        <x-posterts />
    </section>

    <div class="flex justify-center">
        <livewire:website.properties.featured />
    </div>


    @include('components.web.cta');

</x-layouts.web>
