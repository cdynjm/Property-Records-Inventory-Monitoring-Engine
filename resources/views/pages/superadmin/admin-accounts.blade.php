<x-layouts.app :title="__('Admin Accounts')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">List of Admins</flux:heading>
                <flux:modal.trigger name="create-admin">
                    <flux:button variant="primary" size="sm" class="text-xs">New Admin</flux:button>
                </flux:modal.trigger>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Name</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($admins as $index => $ad)
                <x-table-row class="">
                    <td class="border-b border-gray-100 px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border-b border-gray-100 px-4 py-2">{{ $ad->name }}</td>
                    <td class="border-b border-gray-100 px-4 py-2 text-center">
                        <flux:modal.trigger name="edit-admin">
                            <a href="javascript:;" id="edit-admin" data-id="{{ $ad->encrypted_id }}"
                                data-name="{{ $ad->name }}" data-username="{{ $ad->email }}">
                                <iconify-icon icon="lets-icons:edit-duotone" width="24" height="24"></iconify-icon>
                            </a>
                        </flux:modal.trigger>
                        <flux:modal.trigger name="delete-admin">
                            <a href="javascript:;" id="delete-admin" data-id="{{ $ad->encrypted_id }}">
                                <iconify-icon icon="lets-icons:trash-duotone" width="24" height="24"></iconify-icon>
                            </a>
                        </flux:modal.trigger>
                    </td>
                </x-table-row>
                @endforeach

                @if ($admins->isEmpty())
                <x-table-row>
                    <td colspan="4" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No admin
                        accounts
                        found.</td>
                </x-table-row>
                @endif
            </x-table>
        </div>
        <x-footer class="mt-auto" />
    </div>

    <x-modal name="create-admin" class="w-auto md:m-auto mx-4 ">
        <x-slot name="header">
            <flux:heading size="lg">New Admin</flux:heading>
            <flux:text class="mt-2">Create new admin</flux:text>
        </x-slot>
        <form action="" id="create-admin">
            <flux:input label="Name" placeholder="Name" class="mb-4" name="name" required />
            <flux:input label="Username" placeholder="Username" class="mb-4" name="username" required />
            <flux:input label="Password" type="password" placeholder="Password" class="mb-4" name="password" required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('create-admin').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-admin-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-admin" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">Edit Admin</flux:heading>
            <flux:text class="mt-2">Update admin information</flux:text>
        </x-slot>
        <form action="" id="update-admin">
            <flux:input label="Name" placeholder="Name" class="mb-4" id="admin-name" name="name" required />
            <flux:input label="Username" placeholder="Username" class="mb-4" id="username" name="username" required />
            <flux:input label="New Password" type="password" placeholder="Password" class="mb-4" name="password" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('edit-admin').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-admin-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-admin" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:modal.close class="text-gray-500 hover:text-gray-700" />
            <flux:heading size="lg">Delete Admin</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this admin?</flux:text>
        </x-slot>
        <div class="flex">
            <flux:spacer />
            <flux:button type="button" variant="outline" class="me-3" x-on:click="$flux.modal('delete-admin').close()">
                Cancel</flux:button>
            <flux:button type="submit" variant="danger" id="delete-admin-btn">Delete</flux:button>
        </div>
    </x-modal>

    @if (Session::get('success'))
    <x-success-toast>
        {{ Session::get('success') }}
    </x-success-toast>
    @endif

</x-layouts.app>