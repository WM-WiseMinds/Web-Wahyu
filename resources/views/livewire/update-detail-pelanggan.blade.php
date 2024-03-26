<x-form-section submit="update">
    <x-slot name="title">
        {{ __('Detail Pelanggan') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update Data Pelangganmu Berupa No Whatsapp dan Alamat') }}
    </x-slot>

    <x-slot name="form">
        <!-- No WA -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="no_hp" value="{{ __('No WA') }}" />
            <x-input id="no_hp" type="text" class="mt-1 block w-full" wire:model="no_hp" required
                autocomplete="no_hp" />
            <x-input-error for="no_hp" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="alamat" value="{{ __('Alamat') }}" />
            <x-input id="alamat" type="text" class="mt-1 block w-full" wire:model="alamat" required
                autocomplete="alamat" />
            <x-input-error for="alamat" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>


</x-form-section>
