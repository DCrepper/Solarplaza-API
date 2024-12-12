<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament::section.heading>
            Import Products from WooCommerce
        </x-filament::section.heading>

        <x-filament::section.description>
            Import products from WooCommerce to your store.
        </x-filament::section.description>

        <x-filament::button.group>
            <x-filament::button wire:click="startImportWoocommerceSwitchedProducts">
                Import Products
            </x-filament::button>
        </x-filament::button.group>

    </x-filament::section>
</x-filament-widgets::widget>
