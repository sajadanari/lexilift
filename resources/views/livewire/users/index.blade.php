<div class="mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Users</h1>
        <x-forms.primary-btn
            wire:click="showCreatePage"
            icon="add"
        >
            Add New User
        </x-forms.primary-btn>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif


    <livewire:tables.users-table />

</div>
