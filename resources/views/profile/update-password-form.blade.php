<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('account.updatePassword') }}
    </x-slot>

    <x-slot name="description">
        {{ __('account.updatePasswordDesc') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-12 sm:col-span-12">
            <x-jet-label for="current_password" value="{{ __('account.currentPassword') }}" />
            <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-12 sm:col-span-12">
            <x-jet-label for="password" value="{{ __('account.newPassword') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-12 sm:col-span-12">
            <x-jet-label for="password_confirmation" value="{{ __('account.confirmPassword') }}" />
            <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('general.saved') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('general.save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
