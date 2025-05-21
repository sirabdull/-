@php
    $activeTab = request()->query('tab', 'appearance');
    if (!request()->query('tab')) {
        header('Location: ' . request()->url() . '?tab=appearance');
        exit;
    }
@endphp
<x-layouts.app>
    <div>
        <flux:heading size="xl" level="1">Website Configuration</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Manage your website settings</flux:text>
        <flux:separator variant="subtle" />

        <section>
            <flux:header
                class="block! bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
                <flux:navbar scrollable>
                    <flux:navbar.item href="?tab=appearance" :current="request()->query('tab') === 'appearance'">
                        Appearance
                    </flux:navbar.item>
                    <flux:navbar.item href="?tab=contact" :current="request()->query('tab') === 'contact'">Contact Info
                    </flux:navbar.item>
                    <flux:navbar.item href="?tab=social" :current="request()->query('tab') === 'social'">Social Media
                    </flux:navbar.item>
                    <flux:navbar.item href="?tab=seo" :current="request()->query('tab') === 'seo'">SEO Settings
                    </flux:navbar.item>
                </flux:navbar>
            </flux:header>

            <div class="mt-6">
                @if($activeTab === 'appearance')
                    <livewire:admin.configuration.appearance />
                @endif
                @if($activeTab === 'contact')
                    <livewire:admin.configuration.contact />
                @endif
                @if($activeTab === 'social')
                    <livewire:admin.configuration.social />
                @endif
                @if($activeTab === 'seo')
                    <livewire:admin.configuration.seo />
                @endif
            </div>
        </section>
    </div>
</x-layouts.app>