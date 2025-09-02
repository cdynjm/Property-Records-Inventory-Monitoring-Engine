<x-layouts.app :title="__('Unit')">
    <div class="flex min-h-screen flex-col">
        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">List of Units</flux:heading>
                <flux:modal.trigger name="create-unit">
                    <flux:button variant="primary" size="sm" class="text-xs">+ New Unit</flux:button>
                </flux:modal.trigger>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Unit Name</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($units as $index => $un)
                    <x-table-row class="">
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">{{ $un->unit }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                            <flux:modal.trigger name="edit-unit">
                                <a href="javascript:;" id="edit-unit" data-id="{{ $un->encrypted_id }}"
                                    data-unit="{{ $un->unit }}">
                                    <iconify-icon icon="lets-icons:edit-duotone" width="24"
                                        height="24"></iconify-icon>
                                </a>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="delete-unit">
                                <a href="javascript:;" id="delete-unit" data-id="{{ $un->encrypted_id }}">
                                    <iconify-icon icon="lets-icons:trash-duotone" width="24"
                                        height="24"></iconify-icon>
                                </a>
                            </flux:modal.trigger>
                        </td>
                    </x-table-row>
                @endforeach

                @if ($units->isEmpty())
                    <x-table-row>
                        <td colspan="4" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No units
                            found.</td>
                    </x-table-row>
                @endif
            </x-table>
        </div>
        <x-footer class="mt-auto" />
    </div>

    <x-modal name="create-unit" class="w-auto md:m-auto mx-4 ">
        <x-slot name="header">
            <flux:heading size="lg">New Unit</flux:heading>
            <flux:text class="mt-2">Create new unit</flux:text>
        </x-slot>
        <form action="" id="create-unit">
            <flux:input label="Unit Name" placeholder="Unit Name" class="mb-4" name="unitName" required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('create-unit').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-unit-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-unit" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">Edit Unit</flux:heading>
            <flux:text class="mt-2">Update unit information</flux:text>
        </x-slot>
        <form action="" id="update-unit">
            <flux:input label="Unit Name" placeholder="Unit Name" class="mb-4" id="unit-name" name="unitName"
                required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('edit-unit').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-unit-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-unit" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:modal.close class="text-gray-500 hover:text-gray-700" />
            <flux:heading size="lg">Delete Unit</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this unit?</flux:text>
        </x-slot>
        <div class="flex">
            <flux:spacer />
            <flux:button type="button" variant="outline" class="me-3"
                x-on:click="$flux.modal('delete-unit').close()">Cancel</flux:button>
            <flux:button type="submit" variant="danger" id="delete-unit-btn">Delete</flux:button>
        </div>
    </x-modal>

    @if (Session::get('success'))
        <x-success-toast>
            {{ Session::get('success') }}
        </x-success-toast>
    @endif

</x-layouts.app>
