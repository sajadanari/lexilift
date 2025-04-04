<div class="mx-auto px-4 py-8">
    <div class="container flex flex-col md:flex-row md:justify-between items-center space-y-6 md:space-y-0">
        <h1 class="">My Words</h1>
        <x-forms.primary-btn
            wire:click="showCreatePage"
            icon="add"
            class="w-full md:w-auto"
        >
            Add New Word
        </x-forms.primary-btn>
    </div>

    <div class="container">
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('message') }}
            </div>
        @endif

        {{-- Words Table --}}
        <livewire:tables.user-words-table />
    </div>

</div>
