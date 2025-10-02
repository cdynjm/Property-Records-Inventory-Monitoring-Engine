<x-layouts.app :title="__('Accounts Code')">
    <div class="flex min-h-screen flex-col">
        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <flux:heading level="3">List of Accounts Code</flux:heading>
                <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto">
                    <div class="flex items-center w-full md:w-80 gap-2">
                        @if (session('year') != now()->year)
                            <a href="javascript:;" class="me-1 text-red-600 flex items-center gap-1" id="clear-year">
                                <iconify-icon icon="mdi:clear" width="18" height="18"></iconify-icon>
                                <span class="text-[11px]">Clear</span>
                            </a>
                        @endif
                        <flux:select id="search-year" size="sm">
                            <option value="">Select Year</option>
                            @for ($year = now()->year; $year >= 2000; $year--)
                                <option value="{{ $year }}"
                                    {{ session('year', now()->year) == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </flux:select>
                        <flux:button variant="primary" type="button" size="sm" id="search-year-records">
                            <iconify-icon icon="lets-icons:search-duotone" width="20" height="20"></iconify-icon>
                        </flux:button>
                    </div>
                    <flux:modal.trigger name="create-account">
                        <flux:button variant="primary" size="sm" class="text-xs">+ New Account</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>

            <x-table>
                <x-slot:head>
                    <th class="px-4 py-2 text-[13px]">#</th>
                    <th class="px-4 py-2 text-[13px] text-start">Description</th>
                    <th class="px-4 py-2 text-[13px] text-center whitespace-nowrap">Year Inventory
                        ({{ session('year') }})</th>
                    <th class="px-4 py-2 text-[13px] text-center whitespace-nowrap">PPE sub-major account group</th>
                    <th class="px-4 py-2 text-[13px] text-center whitespace-nowrap">General Ledger Account</th>
                    <th class="px-4 py-2 text-[13px]">Actions</th>
                </x-slot:head>

                @foreach ($accountsCode as $index => $ac)
                    <x-table-row class="">
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">{{ $index + 1 }}
                        </td>
                        <td class="border-b border-gray-100 px-4 py-2 whitespace-nowrap">
                            <a wire:navigate
                                href="{{ route('admin.accounts-code-property-inventory-records', ['encrypted_id' => $ac->encrypted_id]) }}">
                                {{ $ac->description }}
                            </a>
                        </td>
                        <td
                            class="border-b border-gray-100 text-center px-4 py-2 whitespace-nowrap font-bold text-[17px] text-green-600">
                            {{ $ac->areInformation->count() }}</td>
                        <td class="border-b border-gray-100 text-center px-4 py-2 whitespace-nowrap">
                            {{ $ac->propertyCode }}</td>
                        <td class="border-b border-gray-100 text-center px-4 py-2 whitespace-nowrap">
                            {{ $ac->propertySubCode }}</td>
                        <td class="border-b border-gray-100 px-4 py-2 text-center whitespace-nowrap">
                            <a wire:navigate
                                href="{{ route('admin.accounts-code-property-inventory-records', ['encrypted_id' => $ac->encrypted_id]) }}">
                                <iconify-icon icon="lets-icons:view-duotone" width="24"
                                    height="24"></iconify-icon>
                            </a>
                            <flux:modal.trigger name="edit-account">
                                <a href="javascript:;" id="edit-account" data-id="{{ $ac->encrypted_id }}"
                                    data-property-code="{{ $ac->propertyCode }}"
                                    data-property-sub-code="{{ $ac->propertySubCode }}"
                                    data-description="{{ $ac->description }}">
                                    <iconify-icon icon="lets-icons:edit-duotone" width="24"
                                        height="24"></iconify-icon>
                                </a>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="delete-account">
                                <a href="javascript:;" id="delete-account" data-id="{{ $ac->encrypted_id }}">
                                    <iconify-icon icon="lets-icons:trash-duotone" width="24"
                                        height="24"></iconify-icon>
                                </a>
                            </flux:modal.trigger>
                        </td>
                    </x-table-row>
                @endforeach


                @if ($accountsCode->isEmpty())
                    <x-table-row>
                        <td colspan="5" class="border-b border-gray-100 px-4 py-2 text-center text-gray-500">No
                            accounts
                            found.</td>
                    </x-table-row>
                @endif
            </x-table>

            <div class="mt-8">
                {{ $accountsCode->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
        <x-footer class="mt-auto" />
    </div>

    <x-modal name="create-account" class="w-auto md:m-auto mx-4 ">
        <x-slot name="header">
            <flux:heading size="lg">New Account</flux:heading>
            <flux:text class="mt-2">Create new account code</flux:text>
        </x-slot>
        <form action="" id="create-account">
            <flux:input label="PPE sub-major account group" placeholder="PPE sub-major account group" class="mb-4"
                name="propertyCode" required />
            <flux:input label="General Ledger Account" placeholder="General Ledger Account" class="mb-4"
                name="propertySubCode" required />
            <flux:textarea label="Description" placeholder="Description" class="mb-4" name="description" required />

            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('create-account').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-account-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-account" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:heading size="lg">Edit Account</flux:heading>
            <flux:text class="mt-2">Update account code</flux:text>
        </x-slot>
        <form action="" id="update-account">
            <flux:input label="PPE sub-major account group" placeholder="PPE sub-major account group" class="mb-4"
                id="property-code" name="propertyCode" required />
            <flux:input label="General Ledger Account" placeholder="General Ledger Account" class="mb-4"
                id="property-sub-code" name="propertySubCode" required />
            <flux:textarea label="Description" placeholder="Description" class="mb-4" id="description"
                name="description" required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="button" variant="outline" class="me-3"
                    x-on:click="$flux.modal('edit-account').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="save-account-btn">Save changes</flux:button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-account" class="w-auto md:m-auto mx-4">
        <x-slot name="header">
            <flux:modal.close class="text-gray-500 hover:text-gray-700" />
            <flux:heading size="lg">Delete Account</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this account code?</flux:text>
        </x-slot>
        <div class="flex">
            <flux:spacer />
            <flux:button type="button" variant="outline" class="me-3"
                x-on:click="$flux.modal('delete-account').close()">Cancel</flux:button>
            <flux:button type="submit" variant="danger" id="delete-account-btn">Delete</flux:button>
        </div>
    </x-modal>

    @if (Session::get('success'))
        <x-success-toast>
            {{ Session::get('success') }}
        </x-success-toast>
    @endif

</x-layouts.app>
