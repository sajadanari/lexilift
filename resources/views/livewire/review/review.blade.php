<div class="w-full md:w-1/2 lg:w-1/3">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Review</h1>
    </div>

    <div class="flex items-center justify-center w-full">
        @foreach ($words as $word)
            <div class="bg-white rounded-4xl border border-[var(--line-clr)] hover:shadow-lg transition-shadow duration-300 overflow-hidden w-full p-3 m-2">
                {{-- Primary Content --}}
                <div class="p-5">

                    <div class="flex mb-3">
                        <div>
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

                        <div class="ml-3 flex flex-col justify-center">
                            <div class="">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $word->word }}</h2>
                            </div>
                            <div class="">
                                <span class="text-sm font-medium">{{ $word->part_of_speech->label() }}</span>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Meaning:</h3>
                        <p class="text-gray-700">{{ $word->meaning }}</p>
                    </div>

                    <div class="mb-3">
                        <h3 class="text-sm font-medium text-gray-500">Example:</h3>
                        <p class="text-gray-700 italic">"{{ $word->example }}"</p>
                    </div>

                    {{-- Expandable Section --}}
                    <div x-data="{ open: false }">
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

                        <div
                            x-show="open"
                            x-transition
                            class="mt-3 space-y-2"
                        >
                            @if($word->synonyms)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Synonyms:</h3>
                                    <p class="text-gray-700">{{ $word->synonyms }}</p>
                                </div>
                            @endif

                            @if($word->antonyms)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Antonyms:</h3>
                                    <p class="text-gray-700">{{ $word->antonyms }}</p>
                                </div>
                            @endif

                            @if($word->notes)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Notes:</h3>
                                    <p class="text-gray-700">{{ $word->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $words->links() }}
    </div>
</div>
