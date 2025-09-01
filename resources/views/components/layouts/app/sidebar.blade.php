<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        @if (auth()->user()->role === 'superadmin')
            <a href="{{ route('superadmin.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
                wire:navigate>
                <x-app-logo />
            </a>

            @php
                $superadminNavItems = [
                    [
                        'icon' => 'home',
                        'route' => 'superadmin.dashboard',
                        'label' => __('Dashboard'),
                    ],
                    [
                        'icon' => 'inbox',
                        'route' => 'superadmin.offices',
                        'label' => __('Offices'),
                    ],
                    [
                        'icon' => 'user-group',
                        'route' => 'superadmin.admin',
                        'label' => __('Admin Accounts'),
                    ],
                    [
                        'icon' => 'clipboard-document-list',
                        'route' => 'superadmin.units',
                        'label' => __('Unit'),
                    ],
                ];
            @endphp

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    @foreach ($superadminNavItems as $item)
                        <flux:navlist.item :icon="$item['icon']" class="mb-1" :href="route($item['route'])"
                            :current="request()->routeIs($item['route'])" wire:navigate>
                            {{ $item['label'] }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            </flux:navlist>


            <flux:spacer />
        @endif

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
                wire:navigate>
                <x-app-logo />
            </a>

            @php
                $navItems = [
                    [
                        'icon' => 'home',
                        'route' => 'admin.dashboard',
                        'label' => __('Dashboard'),
                    ],
                    [
                        'icon' => 'clipboard-document-check',
                        'route' => 'admin.are-records',
                        'label' => __('ARE Records'),
                    ],
                    [
                        'icon' => 'clipboard-document',
                        'route' => 'admin.ics-records',
                        'label' => __('ICS Records'),
                    ],
                    [
                        'icon' => 'briefcase',
                        'route' => 'admin.office-records',
                        'label' => __('Office Records'),
                    ],
                    [
                        'icon' => 'identification',
                        'route' => 'admin.issuers',
                        'label' => __('Issuers'),
                    ],
                    [
                        'icon' => 'user-circle',
                        'route' => 'admin.receivers',
                        'label' => __('Receivers'),
                    ],
                ];
            @endphp

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    @foreach ($navItems as $item)
                        <flux:navlist.item :icon="$item['icon']" class="mb-1" :href="route($item['route'])"
                            :current="request()->routeIs($item['route'])" wire:navigate>
                            {{ $item['label'] }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            </flux:navlist>


            <flux:spacer />
        @endif

        @if (auth()->user()->role === 'office')
            <a href="{{ route('office.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
                wire:navigate>
                <x-app-logo />
            </a>

            @php
                $officeNavItems = [
                    [
                        'icon' => 'home',
                        'route' => 'office.dashboard',
                        'label' => __('Dashboard'),
                    ],
                ];
            @endphp

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    @foreach ($officeNavItems as $item)
                        <flux:navlist.item :icon="$item['icon']" class="mb-1" :href="route($item['route'])"
                            :current="request()->routeIs($item['route'])" wire:navigate>
                            {{ $item['label'] }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            </flux:navlist>


            <flux:spacer />
        @endif

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="#" icon="home" />
                <flux:breadcrumbs.item href="#" class="capitalize">{{ auth()->user()->role }}
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ $title }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item as="button" id="log-out" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>

            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
