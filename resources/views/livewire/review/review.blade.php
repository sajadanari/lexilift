{{--
    Vocabulary Review View Component

    Features:
    - Responsive layout with collapsible sidebar filters
    - Word cards with comprehensive information display
    - Interactive elements (TTS, pagination, filters)
    - Empty state handling

    Layout Structure:
    1. Main container (full width, min height screen)
    2. Header with title and pagination info
    3. Two-column layout (filters sidebar + main content)
    4. Word cards with detailed information sections
--}}

<div class="w-full min-h-screen">
    {{-- Header Section with Title and Word Count --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="container flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Vocabulary Review</h1>
            @if ($totalWords > 0)
                <div
                    class="px-4 py-2 rounded-full shadow-sm border border-[var(--line-clr)] bg-[var(--base-clr)] text-[var(--secondary-text-clr)]">
                    <span class="font-medium">{{ $words->currentPage() }}</span>
                    <span class="mx-2">/</span>
                    <span>{{ $totalWords }}</span>
                </div>
            @endif
        </div>

        {{-- Main Content Grid Layout --}}
        <div class="flex flex-col lg:flex-row gap-6">
            {{--
                Filters Sidebar
                Features:
                - Collapsible on mobile
                - Sticky positioning on desktop
                - Real-time filter updates
                - Multiple filter criteria
            --}}
            <div class="lg:w-1/4 sticky top-4 h-fit" x-data="{ isOpen: true }">
                <div class="container p-0 overflow-hidden" style="padding: 0;">
                    <button @click="isOpen = !isOpen"
                        class="w-full flex items-center justify-between p-4 hover:bg-[var(--hover-clr)]">
                        <div class="flex items-center space-x-3">
                            <span class="flex p-2 rounded-xl bg-[var(--accent-clr)]">
                                <span class="material-symbols-outlined text-white">filter_list</span>
                            </span>
                            <span class="font-semibold text-[var(--text-clr)]">Filters</span>
                        </div>
                        <span class="material-symbols-outlined transition-transform duration-300"
                            :class="{ 'rotate-180': !isOpen }">expand_less</span>
                    </button>

                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" class="p-4 border-t border-gray-100">
                        <x-forms.input-field placeholder="Search for a word" wire:model.live.debounce.300ms="search"
                            icon="search" name="search" class="w-full" />

                        <x-forms.select-field name="part_of_speech" label="Part of Speech" icon="match_word"
                            wire:model.live="part_of_speech" placeholder="Part of speech">
                            @foreach (App\Enums\PartOfSpeech::cases() as $partOfSpeech)
                                <option value="{{ $partOfSpeech->value }}">{{ $partOfSpeech->label() }}</option>
                            @endforeach
                        </x-forms.select-field>

                        <x-forms.select-field name="difficulty_level" label="Difficulty Level"
                            wire:model.live="difficulty_level" placeholder="CEFR Level">
                            @foreach (App\Enums\DifficultyLevel::cases() as $level)
                                <option value="{{ $level->value }}">{{ $level->label() }}</option>
                            @endforeach
                        </x-forms.select-field>

                        <x-forms.select-field name="frequency" label="Frequency" wire:model.live="frequency"
                            placeholder="Frequency">
                            @foreach (App\Enums\FrequencyLevel::cases() as $level)
                                <option value="{{ $level->value }}">{{ $level->label() }}</option>
                            @endforeach
                        </x-forms.select-field>

                        <x-forms.select-field name="word_level" label="Learning Status" wire:model.live="word_level"
                            placeholder="Select learning status">
                            @foreach (App\Enums\WordLevel::cases() as $level)
                                <option value="{{ $level->value }}">
                                    {{ match ($level) {
                                        \App\Enums\WordLevel::WEAK => 'Needs Practice',
                                        \App\Enums\WordLevel::MEDIUM => 'Learning',
                                        \App\Enums\WordLevel::STRONG => 'Well Known',
                                    } }}
                                </option>
                            @endforeach
                        </x-forms.select-field>

                        <x-forms.primary-btn :isOutline="true" icon="refresh" class="w-full mb-2"
                            wire:click="resetFilters" wire:loading.attr="disabled">
                            Reset Filters
                        </x-forms.primary-btn>
                    </div>
                </div>
            </div>

            {{--
                Main Content Area
                Displays either:
                - Empty state message with reset action
                - Word cards with navigation
            --}}
            <div class="lg:w-3/4">
                @if ($totalWords === 0)
                    {{-- Empty State Display --}}
                    <div class="container text-center">
                        <div class="inline-flex p-4 rounded-full bg-[var(--secondary-base-clr)] mb-4">
                            <span class="material-symbols-outlined text-3xl text-[var(--text-clr)]">search_off</span>
                        </div>
                        <h3 class="mb-2">No Words Found</h3>
                        <p class="text-[var(--secondary-text-clr)] mb-6">Try adjusting your filters to find more words.
                        </p>
                        <x-forms.primary-btn wire:click="resetFilters" icon="refresh">
                            Reset Filters
                        </x-forms.primary-btn>
                    </div>
                @else
                    {{--
                        Word Cards Section
                        Features:
                        - Previous/Next navigation
                        - Comprehensive word information
                        - Interactive elements (TTS, expandable sections)
                    --}}
                    <div class="relative">
                        @foreach ($words as $word)
                            {{-- Individual Word Card --}}
                            <div class="container overflow-hidden transition-all duration-300" style="padding: 0;">
                                <div class="flex items-stretch">
                                    @if ($totalWords > 1)
                                        <button wire:click="previousPage"
                                            @if ($words->onFirstPage()) disabled @endif
                                            class="px-4 flex items-center justify-center hover:bg-[var(--hover-clr)] disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                            <span class="material-symbols-outlined">chevron_left</span>
                                        </button>
                                    @endif

                                    <div class="flex-1 p-6">
                                        {{-- Word header --}}
                                        <div class="flex items-start space-x-4 mb-6">
                                            <div class="flex-shrink-0">
                                                <span style="font-size: 40px !important;"
                                                    class="material-icons-round text-white rounded-full p-4 {{ match ($word->part_of_speech) {
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
                                                    } }}">
                                                    {{ match ($word->part_of_speech) {
                                                        \App\Enums\PartOfSpeech::NOUN => 'subject',
                                                        \App\Enums\PartOfSpeech::PRONOUN => 'person_outline',
                                                        \App\Enums\PartOfSpeech::VERB => 'directions_run',
                                                        \App\Enums\PartOfSpeech::ADJECTIVE => 'palette',
                                                        \App\Enums\PartOfSpeech::ADVERB => 'flash_on',
                                                        \App\Enums\PartOfSpeech::PREPOSITION => 'compare_arrows',
                                                        \App\Enums\PartOfSpeech::CONJUNCTION => 'call_merge',
                                                        \App\Enums\PartOfSpeech::INTERJECTION => 'emoji_emotions',
                                                        \App\Enums\PartOfSpeech::ARTICLE => 'article',
                                                        default => 'question_mark',
                                                    } }}
                                                </span>
                                            </div>

                                            <div class="flex-1">
                                                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $word->word }}
                                                </h2>
                                                <div class="flex items-center space-x-4">
                                                    <span class="text-sm font-medium text-[var(--text-clr)]">
                                                        {{ $word->part_of_speech->label() }}
                                                    </span>
                                                    <button wire:click="speakWord('{{ $word->word }}')"
                                                        class="inline-flex items-center justify-center p-2 rounded-full hover:bg-gray-100 transition-colors">
                                                        <span
                                                            class="material-symbols-outlined text-[var(--accent-clr)]">volume_up</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Badges and content --}}
                                        <div class="space-y-6">
                                            <x-word-card.level-badges :word="$word" />
                                            <div class="mt-3">
                                                <x-word-card.learning-status-badge :score="$word->score" />
                                            </div>

                                            <x-word-card.text-section title="Meaning:" :content="$word->meaning"
                                                :center-title="false" :persian="false" />

                                            <x-word-card.text-section title="Example:" :content="$word->example"
                                                :italic="true" />

                                            <div x-data="{ open: false }" class="w-full">
                                                <button @click="open = !open"
                                                    class="text-[var(--accent-clr)] text-sm font-medium flex items-center gap-1 w-full cursor-pointer hover:bg-[var(--hover-clr)] p-2 rounded-lg transition-colors">
                                                    <span x-text="open ? 'Show Less' : 'Show More'"></span>
                                                    <svg class="w-4 h-4 transition-transform"
                                                        :class="{ 'rotate-180': open }" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>

                                                <div x-show="open" x-transition class="mt-3 space-y-2">
                                                    <x-word-card.pronunciation-section :word="$word" />

                                                    @if ($word->usage)
                                                        <x-word-card.text-section title="Usage:" :content="$word->usage" />
                                                    @endif

                                                    @if ($word->synonyms)
                                                        <x-word-card.text-section title="Synonyms:"
                                                            :content="$word->synonyms" />
                                                    @endif

                                                    @if ($word->antonyms)
                                                        <x-word-card.text-section title="Antonyms:"
                                                            :content="$word->antonyms" />
                                                    @endif

                                                    @if ($word->collocations)
                                                        <x-word-card.text-section title="Common Collocations:"
                                                            :content="$word->collocations" />
                                                    @endif

                                                    @if ($word->root || $word->etymology)
                                                        <x-word-card.text-section title="Word Origin:"
                                                            :content="$word->root .
                                                                ($word->etymology ? ' - ' . $word->etymology : '')" />
                                                    @endif

                                                    <x-word-card.grammar-section :word="$word" />

                                                    @if ($word->notes)
                                                        <x-word-card.text-section title="Notes:" :content="$word->notes" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($totalWords > 1)
                                        <button wire:click="nextPage"
                                            @if (!$words->hasMorePages()) disabled @endif
                                            class="px-4 flex items-center justify-center hover:bg-[var(--hover-clr)] disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                            <span class="material-symbols-outlined">chevron_right</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Text-to-Speech Initialization Script --}}
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
