<div class="mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $page === 'edit' ? 'Edit User' : 'Add New User' }}
        </h1>

        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Basic Information --}}
            <div class="p-6 bg-white rounded-lg shadow-sm space-y-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Basic Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-forms.input-field name="userData.user" label="Name" icon="person" wire:model="userData.name"
                        placeholder="Enter the user..." required />

                    <x-forms.input-field name="userData.email" label="Email" icon="email" wire:model="userData.email"
                        placeholder="Enter the email..." required />

                    <x-forms.input-field name="userData.password" label="Password" icon="lock" wire:model="userData.password" type="password"
                        placeholder="Enter the password..." />
                </div>

            </div>

            {{-- Save Button --}}
            <div class="flex justify-end">
                <x-forms.primary-btn type="submit">
                    {{ $page === 'edit' ? 'Update User' : 'Save User' }}
                </x-forms.primary-btn>
                <x-forms.secondary-btn wire:click="showIndexPage" class="ml-2">
                    Cancel
                </x-forms.secondary-btn>
            </div>
        </form>
    </div>
</div>
