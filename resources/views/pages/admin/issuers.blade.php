<x-layouts.app :title="__('Issuers')">
    <div class="flex min-h-screen flex-col">

        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <flux:heading level="3">List of Issuers</flux:heading>
                <flux:modal.trigger name="create-issuer">
                    <flux:button variant="primary" size="sm" class="text-xs">+ New Issuer</flux:button>
                </flux:modal.trigger>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Name</th>
                    <th class="px-4 py-2 text-[13px] text-start">Position</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($receivedFrom as $index => $rf)
                    <x-table-row class="">
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">{{ $rf->name }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">{{ $rf->position }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                            <flux:modal.trigger name="edit-issuer">
                                <a href="javascript:;" id="edit-issuer" data-id="{{ $rf->encrypted_id }}"
                                    data-name="{{ $rf->name }}" data-position="{{ $rf->position }}">
                                    <iconify-icon icon="lets-icons:edit-duotone" width="24"
                                        height="24"></iconify-icon>
                                </a>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="delete-issuer">
                                <a href="javascript:;" id="delete-issuer" data-id="{{ $rf->encrypted_id }}">
                                    <iconify-icon icon="lets-icons:trash-duotone" width="24"
                                        height="24"></iconify-icon>
                                </a>
                            </flux:modal.trigger>
                        </td>
                    </x-table-row>
                @endforeach

                @if ($receivedFrom->isEmpty())
                    <x-table-row>
                        <td colspan="4" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No
                            personnel
                            found.</td>
                    </x-table-row>
                @endif
            </x-table>
        </div>

        <x-footer class="mt-auto" />
    </div>

    <x-modal name="create-issuer" class="w-auto md:m-auto mx-4 ">
        <x-slot name="header">
            <flux:heading size="lg">New Issuer</flux:heading>
            <flux:text class="mt-2">Create new issuer</flux:text>
        </x-slot>
        <form action="" id="create-issuer">
            <flux:input label="Name" placeholder="Name" class="mb-4" name="name" required />
            <flux:input label="Position" placeholder="Position" class="mb-4" name="position" required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('create-issuer').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-issuer-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-issuer" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">Edit Issuer</flux:heading>
            <flux:text class="mt-2">Update issuer information</flux:text>
        </x-slot>
        <form action="" id="update-issuer">
            <flux:input label="Name" placeholder="Name" class="mb-4" id="issuer-name" name="name" required />
            <flux:input label="Position" placeholder="Position" class="mb-4" id="issuer-position" name="position" required />

            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('edit-issuer').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-issuer-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-issuer" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:modal.close class="text-gray-500 hover:text-gray-700" />
            <flux:heading size="lg">Delete Issuer</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this issuer?</flux:text>
        </x-slot>
        <div class="flex">
            <flux:spacer />
            <flux:button type="button" variant="outline" class="me-3"
                x-on:click="$flux.modal('delete-issuer').close()">Cancel</flux:button>
            <flux:button type="submit" variant="danger" id="delete-issuer-btn">Delete</flux:button>
        </div>
    </x-modal>

    @if (Session::get('success'))
        <x-success-toast>
            {{ Session::get('success') }}
        </x-success-toast>
    @endif
</x-layouts.app>
