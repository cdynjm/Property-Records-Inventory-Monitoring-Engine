<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Provincial General Services Office')" :description="__('Inventory Management System')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

   <hr>

    <small class="text-gray-600">Log in with your credentials to proceed</small>

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Username')"
            required
            autofocus
            autocomplete="email"
            placeholder="Username"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>
</div>
