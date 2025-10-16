@php
    use Illuminate\Support\Facades\Route;

    $role = auth()->user()->role;

    $menus = match ($role) {
        'superadmin' => [
            ['label' => 'Dashboard', 'icon' => 'solar:home-2-line-duotone', 'route' => 'superadmin.dashboard'],
             ['label' => 'Offices', 'icon' => 'ph:office-chair-duotone', 'route' => 'superadmin.offices'],
            ['label' => 'Admin Accounts', 'icon' => 'eos-icons:admin-outlined', 'route' => 'superadmin.admin'],
        ],
        'admin' => [
            ['label' => 'Dashboard', 'icon' => 'solar:home-2-line-duotone', 'route' => 'admin.dashboard'],
            ['label' => 'ARE Records', 'icon' => 'solar:document-add-line-duotone', 'route' => 'admin.are-records'],
            ['label' => 'ICS Records', 'icon' => 'solar:document-text-line-duotone', 'route' => 'admin.ics-records'],
            ['label' => 'Accounts Code', 'icon' => 'lets-icons:folder-alt-duotone', 'route' => 'admin.accounts-code'],
        ],
        'office' => [
            ['label' => 'Dashboard', 'icon' => 'solar:home-2-line-duotone', 'route' => 'office.dashboard'],
            ['label' => 'ARE Records', 'icon' => 'solar:document-add-line-duotone', 'route' => 'office.are-records'],
            ['label' => 'ICS Records', 'icon' => 'solar:document-text-line-duotone', 'route' => 'office.ics-records'],
        ],
        default => [],
    };

    $currentRoute = Route::currentRouteName();
@endphp

@if (!empty($menus))
    <nav class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-sm z-50 md:hidden">
        <div class="flex justify-around items-center py-2">
            @foreach ($menus as $menu)
                @php
                    $isActive = str_starts_with($currentRoute, $menu['route']);
                @endphp

                <a
                    wire:navigate
                    href="{{ route($menu['route']) }}"
                    class="flex flex-col items-center {{ $isActive ? 'text-green-500' : 'text-gray-600' }}"
                >
                    <iconify-icon
                        icon="{{ $menu['icon'] }}"
                        width="22"
                        height="22"
                    ></iconify-icon>
                    <span class="text-xs mt-1">{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>
@endif
