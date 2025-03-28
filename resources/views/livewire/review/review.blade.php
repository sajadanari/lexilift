<!-- Main container -->
<div class="w-full">
    <!-- Header section -->
    <div class="flex justify-between items-start mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Vocabulary Review</h1>
    </div>

    <!-- Content wrapper -->
    <div class="flex flex-col md:flex-row justify-center">

        {{-- Search and Filters --}}
        <div class="w-full md:w-1/4 p-2 md:mr-2">

            <div class="flex flex-col border rounded-4xl bg-white border-[var(--line-clr)] hover:shadow-lg transition-shadow duration-300" x-data="{ showFilters: true }">

                {{-- Filters Header --}}
                <div>

                    {{-- Toggle show filters button, hide and show Filters Section --}}
                    <button
                        @click="showFilters = !showFilters"
                        class="w-full flex flex-row justify-between pt-6 px-6 cursor-pointer rounded-t-4xl items-center"
                        :class="{ 'pb-6 rounded-b-4xl': !showFilters }"
                    >

                        <div class="flex flex-row">
                            <div class="flex">
                                <span class="material-symbols-outlined mr-2 text-[var(--accent-clr)]" style="font-size: 32px !important">
                                    filter_alt
                                </span>
                            </div>
                            <h3 class="flex text-lg font-bold text-gray-800 items-center">Filters</h3>
                        </div>

                        <div class="flex items-center">
                            <span class="material-symbols-outlined" :class="{ 'rotate-180': !showFilters }">
                                keyboard_arrow_up
                            </span>
                        </div>

                    </button>

                </div>

                {{-- Filters --}}
                <div x-show="showFilters" x-transition class="grid grid-cols-1 gap-4 mt-4 px-6 pb-6">

                    {{-- Search --}}
                    <x-forms.input-field
                        placeholder="Search for a word"
                        wire:model.live.debounce.300ms="search"
                        icon="search"
                        name="search"
                        class="w-full"
                    />

                    {{-- Part of Speech --}}
                    <x-forms.select-field name="part_of_speech" label="Part of Speech" icon="match_word"
                        wire:model.live="part_of_speech" placeholder="Select the part of speech">
                        @foreach (App\Enums\PartOfSpeech::cases() as $partOfSpeech)
                            <option value="{{ $partOfSpeech->value }}">{{ $partOfSpeech->label() }}</option>
                        @endforeach
                    </x-forms.select-field>

                    {{-- Difficulty Level --}}
                    <x-forms.select-field name="difficulty_level" label="Difficulty Level"
                        wire:model.live="difficulty_level" placeholder="Select CEFR level">
                        @foreach (App\Enums\DifficultyLevel::cases() as $level)
                            <option value="{{ $level->value }}">{{ $level->label() }}</option>
                        @endforeach
                    </x-forms.select-field>

                    {{-- Frequency Level --}}
                    <x-forms.select-field name="frequency" label="Frequency" wire:model.live="frequency"
                        placeholder="How commonly is this word used?">
                        @foreach (App\Enums\FrequencyLevel::cases() as $level)
                            <option value="{{ $level->value }}">{{ $level->label() }}</option>
                        @endforeach
                    </x-forms.select-field>

                    {{-- Learning Status --}}
                    <x-forms.select-field
                        name="word_level"
                        label="Learning Status"
                        wire:model.live="word_level"
                        placeholder="Select learning status"
                    >
                        @foreach (App\Enums\WordLevel::cases() as $level)
                            <option value="{{ $level->value }}">
                                {{ match($level) {
                                    \App\Enums\WordLevel::WEAK => 'Needs Practice',
                                    \App\Enums\WordLevel::MEDIUM => 'Learning',
                                    \App\Enums\WordLevel::STRONG => 'Well Known',
                                } }}
                            </option>
                        @endforeach
                    </x-forms.select-field>

                    {{-- Reset Filters Button --}}
                    <button
                        wire:click="resetFilters"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 text-[var(--accent-clr)] hover:text-white border border-[var(--accent-clr)] rounded-lg hover:bg-[var(--accent-clr)] transition-colors duration-300"
                    >
                        <span class="material-symbols-outlined">refresh</span>
                        Reset Filters
                    </button>

                </div>

            </div>

        </div>

        <!-- Card container with responsive width -->
        <div class="w-full md:w-1/2 lg:w-1/3">
            <!-- Words list container -->
            <div class="flex items-center justify-center w-full">
                @foreach ($words as $word)

                    <!-- Individual word card -->
                    <div class="bg-white rounded-4xl border border-[var(--line-clr)] hover:shadow-lg transition-shadow duration-300 overflow-hidden w-full m-2 flex flex-row justify-between">
                        {{-- Previous Button --}}
                        <div class="flex items-center justify-center">
                            <button
                                class="cursor-pointer h-full px-3"
                                wire:click="previousPage"
                                @if($words->onFirstPage()) disabled @endif
                            >
                                <span class="material-symbols-outlined">
                                    chevron_left
                                </span>
                            </button>
                        </div>

                        <!-- Card content wrapper -->
                        <div class="py-3 w-full">
                            <div class="p-5">
                                <!-- Word header with icon and title -->
                                <div class="flex flex-col md:flex-row mb-3">
                                    <!-- Part of speech icon -->
                                    <div class="flex items-center justify-center">
                                        <span style="font-size: 40px !important;" class="material-icons-round text-white rounded-full p-4 {{
                                            match($word->part_of_speech) {
                                                \App\Enums\PartOfSpeech::NOUN => 'bg-indigo-500',
                                                \App\Enums\PartOfSpeech::PRONOUN => 'bg-teal-500',
                                                \App\Enums\PartOfSpeech::VERB => 'bg-emerald-500',
                                                \App\Enums\PartOfSpeech::ADJECTIVE => 'bg-fuchsia-500',
                                                \App\Enums\PartOfSpeech::ADVERB => 'bg-amber-500',
                                                \App\Enums\PartOfSpeech::PREPOSITION => 'bg-cyan-500',
                                                \App\Enums\PartOfSpeech::CONJUNCTION => 'bg-orange-500',
                                                \App\Enums\PartOfSpeech::INTERJECTION => 'bg-rose-500',
                                                \App\Enums\PartOfSpeech::ARTICLE => 'bg-gray-500',
                                                'default' => 'bg-gray-400',
                                            }
                                        }}">
                                            {{
                                                match($word->part_of_speech) {
                                                    \App\Enums\PartOfSpeech::NOUN => 'subject',
                                                    \App\Enums\PartOfSpeech::PRONOUN => 'person_outline',
                                                    \App\Enums\PartOfSpeech::VERB => 'directions_run',
                                                    \App\Enums\PartOfSpeech::ADJECTIVE => 'palette',
                                                    \App\Enums\PartOfSpeech::ADVERB => 'flash_on',
                                                    \App\Enums\PartOfSpeech::PREPOSITION => 'compare_arrows',
                                                    \App\Enums\PartOfSpeech::CONJUNCTION => 'call_merge',
                                                    \App\Enums\PartOfSpeech::INTERJECTION => 'emoji_emotions',
                                                    \App\Enums\PartOfSpeech::ARTICLE => 'article',
                                                    default => 'question_mark'
                                                }
                                            }}
                                        </span>
                                    </div>

                                    <!-- Word title and part of speech -->
                                    <div class="
                                        flex flex-col mt-3 text-center
                                        md:ml-3 md:justify-center md:text-left md:mt-0
                                    ">
                                        <div class="">
                                            <h2 class="text-2xl font-bold text-gray-800">{{ $word->word }}</h2>
                                        </div>
                                        <div class="">
                                            <span class="text-sm font-medium">{{ $word->part_of_speech->label() }}</span>
                                        </div>
                                    </div> <!-- End word title div -->

                                    <div class="flex items-center justify-center mt-3 md:ml-auto md:mt-0">
                                        <button
                                            type="button"
                                            wire:click="speakWord('{{ $word->word }}')"
                                            class="text-[var(--accent-clr)] hover:text-white border cursor-pointer p-2 rounded-full hover:bg-[var(--accent-clr)] flex"
                                        >
                                            <span class="material-symbols-outlined text-lg">
                                                volume_up
                                            </span>
                                        </button>
                                    </div>

                                </div> <!-- End word header div -->

                                <x-word-card.level-badges :word="$word" />

                                <div class="mt-3">
                                    <x-word-card.learning-status-badge :score="$word->score" />
                                </div>

                                <x-word-card.text-section
                                    title="Meaning:"
                                    :content="$word->meaning"
                                    :center-title="false"
                                    :persian="false"
                                />

                                <x-word-card.text-section
                                    title="Example:"
                                    :content="$word->example"
                                    :italic="true"
                                />

                                <!-- Expandable details section -->
                                <div x-data="{ open: false }">
                                    <!-- Toggle button -->
                                    <button
                                        @click="open = !open"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1"
                                    >
                                        <span x-text="open ? 'Show Less' : 'Show More'"></span>
                                        <svg
                                            class="w-4 h-4 transition-transform"
                                            :class="{'rotate-180': open}"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <!-- Expandable content -->
                                    <div x-show="open" x-transition class="mt-3 space-y-2">
                                        <x-word-card.pronunciation-section :word="$word" />

                                        @if($word->usage)
                                            <x-word-card.text-section
                                                title="Usage:"
                                                :content="$word->usage"
                                            />
                                        @endif

                                        @if($word->synonyms)
                                            <x-word-card.text-section
                                                title="Synonyms:"
                                                :content="$word->synonyms"
                                            />
                                        @endif

                                        @if($word->antonyms)
                                            <x-word-card.text-section
                                                title="Antonyms:"
                                                :content="$word->antonyms"
                                            />
                                        @endif

                                        @if($word->collocations)
                                            <x-word-card.text-section
                                                title="Common Collocations:"
                                                :content="$word->collocations"
                                            />
                                        @endif

                                        @if($word->root || $word->etymology)
                                            <x-word-card.text-section
                                                title="Word Origin:"
                                                :content="$word->root . ($word->etymology ? ' - ' . $word->etymology : '')"
                                            />
                                        @endif

                                        <x-word-card.grammar-section :word="$word" />

                                        @if($word->notes)
                                            <x-word-card.text-section
                                                title="Notes:"
                                                :content="$word->notes"
                                            />
                                        @endif
                                    </div> <!-- End expandable content div -->
                                </div> <!-- End expandable section div -->
                            </div>
                        </div> <!-- End card content wrapper div -->

                        {{-- Next Button --}}
                        <div class="flex items-center justify-center">
                            <button
                                class="cursor-pointer h-full px-3"
                                wire:click="nextPage"
                                @if(!$words->hasMorePages()) disabled @endif
                            >
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </button>
                        </div>

                    </div> <!-- End individual word card div -->

                @endforeach
            </div> <!-- End words list container div -->

        </div> <!-- End card container div -->

    </div> <!-- End content wrapper div -->
</div> <!-- End main container div -->

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('speak-word', (params) => {
            const word = params[0].word;
            const utterance = new SpeechSynthesisUtterance(word);
            utterance.lang = 'en-US';
            speechSynthesis.speak(utterance);
        });
    });
</script>
