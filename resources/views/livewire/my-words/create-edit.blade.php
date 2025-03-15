<div class="mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $page === 'edit' ? 'Edit Word' : 'Add New Word' }}
        </h1>

        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Basic Information --}}
            <div class="p-6 bg-white rounded-lg shadow-sm space-y-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Basic Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-forms.input-field name="wordData.word" label="Word" icon="spellcheck" wire:model="wordData.word"
                        required />

                    <x-forms.select-field name="wordData.part_of_speech" label="Part of Speech" icon="match_word"
                        wire:model="wordData.part_of_speech" placeholder="Select part of speech">
                        @foreach (App\Enums\PartOfSpeech::cases() as $partOfSpeech)
                            <option value="{{ $partOfSpeech->value }}">{{ $partOfSpeech->label() }}</option>
                        @endforeach
                    </x-forms.select-field>
                </div>

                <x-forms.textarea-field name="wordData.meaning" label="Meaning" wire:model="wordData.meaning"
                    class="persian" required />

                <x-forms.textarea-field name="wordData.example" label="Example Usage" wire:model="wordData.example"
                    placeholder="Enter example sentences..." />
            </div>

            {{-- Additional Details --}}
            <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Additional Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-forms.input-field name="wordData.pronunciation" label="Pronunciation"
                        wire:model="wordData.pronunciation" />

                    <x-forms.input-field name="wordData.difficulty_level" label="Difficulty Level"
                        wire:model="wordData.difficulty_level" placeholder="e.g., A1, B2, C1" />
                </div>

                <x-forms.textarea-field name="wordData.synonyms" label="Synonyms" wire:model="wordData.synonyms" />

                <x-forms.textarea-field name="wordData.antonyms" label="Antonyms" wire:model="wordData.antonyms" />
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end">
                <x-forms.primary-btn type="submit">
                    {{ $page === 'edit' ? 'Update Word' : 'Save Word' }}
                </x-forms.primary-btn>
                <x-forms.secondary-btn wire:click="showIndexPage" class="ml-2">
                    Cancel
                </x-forms.secondary-btn>
            </div>
        </form>
    </div>
</div>
