<x-layouts.app :title="__('Offices')">
    <div class="flex min-h-screen flex-col">
        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">List of Offices</flux:heading>
                <flux:modal.trigger name="create-office">
                    <flux:button variant="primary" size="sm" class="text-xs">+ New Office</flux:button>
                </flux:modal.trigger>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Office Name</th>
                    <th class="px-4 py-2 text-[13px] text-start">Code</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($offices as $index => $of)
                    <x-table-row class="">
                        <td class="  px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="  px-4 py-2 whitespace-nowrap">{{ $of->officeName }}</td>
                        <td class="  px-4 py-2 whitespace-nowrap">{{ $of->officeCode }}</td>
                        <td class="  px-4 py-2 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <div class="flex flex-col items-center">
                                    <flux:modal.trigger name="edit-office">
                                        <a href="javascript:;" id="edit-office" data-id="{{ $of->encrypted_id }}"
                                            data-name="{{ $of->officeName }}" data-code="{{ $of->officeCode }}"
                                            data-username="{{ $of->user->email }}">
                                            <small class="text-gray-500">Edit</small>
                                        </a>
                                    </flux:modal.trigger>
                                </div>
                                <div class="flex flex-col items-center text-red-500">
                                    <flux:modal.trigger name="delete-office">
                                        <a href="javascript:;" id="delete-office" data-id="{{ $of->encrypted_id }}"
                                            class="mt-1">
                                            <iconify-icon icon="lets-icons:trash-duotone" width="24" height="24"
                                                class="text-red-500"></iconify-icon>
                                        </a>
                                    </flux:modal.trigger>
                                </div>
                            </div>
                        </td>
                    </x-table-row>
                @endforeach

                @if ($offices->isEmpty())
                    <x-table-row>
                        <td colspan="4" class="  px-4 py-2 text-center text-gray-500">No
                            offices
                            found.</td>
                    </x-table-row>
                @endif
            </x-table>
        </div>

        <x-footer class="mt-auto" />
    </div>

    <x-modal name="create-office" class="w-auto md:m-auto mx-4 ">
        <x-slot name="header">
            <flux:heading size="lg">New Office</flux:heading>
            <flux:text class="mt-2">Create new office</flux:text>
        </x-slot>
        <form action="" id="create-office">
            <flux:input label="Office Name" placeholder="Office Name" class="mb-4" name="officeName" required />
            <flux:input label="Office Code" placeholder="Office Code" class="mb-4" name="officeCode" required />
            <flux:input label="Username" placeholder="Username" class="mb-4" name="username" required />
            <flux:input label="Password" type="password" placeholder="Password" class="mb-4" name="password" viewable
                required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('create-office').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-office-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-office" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">Edit Office</flux:heading>
            <flux:text class="mt-2">Update office information</flux:text>
        </x-slot>
        <form action="" id="update-office">
            <flux:input label="Office Name" placeholder="Office Name" class="mb-4" id="office-name" name="officeName"
                required />
            <flux:input label="Office Code" placeholder="Office Code" class="mb-4" id="office-code" name="officeCode"
                required />
            <flux:input label="Username" placeholder="Username" class="mb-4" id="username" name="username"
                required />
            <flux:input label="New Password" type="password" placeholder="Password" class="mb-4" name="password"
                viewable />

            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('edit-office').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-office-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-office" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:modal.close class="text-gray-500 hover:text-gray-700" />
            <flux:heading size="lg">Delete Office</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this office?</flux:text>
        </x-slot>
        <div class="flex">
            <flux:spacer />
            <flux:button type="button" variant="outline" class="me-3"
                x-on:click="$flux.modal('delete-office').close()">Cancel</flux:button>
            <flux:button type="submit" variant="danger" id="delete-office-btn">Delete</flux:button>
        </div>
    </x-modal>

    @if (Session::get('success'))
        <x-success-toast>
            {{ Session::get('success') }}
        </x-success-toast>
    @endif

</x-layouts.app>
