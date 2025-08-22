<x-layouts.app :title="__('Offices')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <flux:heading level="3">List of Offices</flux:heading>
            <flux:modal.trigger name="create-office">
                <flux:button variant="primary" size="sm" class="text-xs">New Office</flux:button>
            </flux:modal.trigger>
        </div>
        <div class="rounded-md bg-white dark:bg-stone-950 dark:border-stone-800 text-stone-800 shadow-none">
            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 border text-[13px]">#</th>
                    <th class="px-4 py-2 border text-[13px]">Office Name</th>
                    <th class="px-4 py-2 border text-[13px]">Code</th>
                    <th class="px-4 py-2 border text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($offices as $index => $of)
                    <x-table-row>
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $of->officeName }}</td>
                        <td class="px-4 py-2 border">{{ $of->officeCode }}</td>
                        <td class="px-4 py-2 border text-center">
                            <a href="javascript:;" id="edit-office">
                                <iconify-icon icon="lets-icons:edit-duotone" width="24" height="24"></iconify-icon>
                            </a>
                            <flux:modal.trigger name="delete-office">
                            <a href="javascript:;" id="delete-office" data-id="{{ $of->encrypted_id }}">
                                <iconify-icon icon="lets-icons:trash-duotone" width="24" height="24"></iconify-icon>
                            </a>
                            </flux:modal.trigger>
                        </td>
                    </x-table-row>
                @endforeach
                
                @if($offices->isEmpty())
                    <x-table-row>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">No offices found.</td>
                    </x-table-row>
                @endif
            </x-table>

        </div>
    </div>

    <x-modal name="create-office" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">New Office</flux:heading>
            <flux:text class="mt-2">Create new office</flux:text>
        </x-slot>
        <form action="" id="create-office">
            <flux:input label="Office Name" placeholder="Office Name" class="mb-4" name="officeName" required />
            <flux:input label="Office Code" placeholder="Office Code" class="mb-4" name="officeCode" required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" id="save-office-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-office" class="w-96 md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">Delete Office</flux:heading>
            <flux:text class="mt-2">This can't be undone</flux:text>
        </x-slot>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="danger" id="delete-office-btn">Delete</flux:button>
            </div>
    </x-modal>

    @if (Session::get('success'))
        <x-success-toast>
            {{ Session::get('success') }}
        </x-success-toast>
    @endif
    
</x-layouts.app>
