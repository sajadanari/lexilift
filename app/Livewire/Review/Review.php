<?php

namespace App\Livewire\Review;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Enums\WordLevel;

/**
 * Vocabulary Review Component
 *
 * Provides an interactive interface for reviewing vocabulary words with:
 * - Advanced filtering capabilities
 * - Pagination with single word view
 * - Text-to-speech functionality
 * - Real-time search and filter updates
 */
class Review extends Component
{
    use WithPagination;

    /** @var string Search query parameter preserved in URL */
    #[Url]
    public $search = '';

    /** @var string Part of speech filter parameter preserved in URL */
    #[Url]
    public $part_of_speech = '';

    /** @var string CEFR level filter parameter preserved in URL */
    #[Url]
    public $difficulty_level = '';

    /** @var string Word frequency filter parameter preserved in URL */
    #[Url]
    public $frequency = '';

    /** @var string Learning status filter parameter preserved in URL */
    #[Url]
    public $word_level = '';

    public function mount()
    {
        // Get word_level from URL and validate it
        $wordLevel = request()->get('word_level');
        if ($wordLevel && in_array($wordLevel, ['WEAK', 'MEDIUM', 'STRONG'])) {
            $this->word_level = $wordLevel;
        }
    }

    /**
     * Renders the review component with filtered words
     *
     * Applies multiple filter criteria:
     * - Text search on word
     * - Part of speech filtering
     * - CEFR level filtering
     * - Frequency level filtering
     * - Learning status (score range) filtering
     */
    public function render()
    {
        $query = auth()->user()->words();

        if ($this->search) {
            $query->where('word', 'like', '%' . $this->search . '%');
        }

        if ($this->part_of_speech) {
            $query->where('part_of_speech', $this->part_of_speech);
        }

        if ($this->difficulty_level) {
            $query->where('difficulty_level', $this->difficulty_level);
        }

        if ($this->frequency) {
            $query->where('frequency', $this->frequency);
        }

        if ($this->word_level) {
            $level = WordLevel::from($this->word_level);
            $range = $level->getRange();
            $query->whereBetween('score', [$range['min'], $range['max']]);
        }

        $totalWords = $query->count();

        return view('livewire.review.review', [
            'words' => $query->simplePaginate(1),
            'totalWords' => $totalWords
        ])->layout('layouts.front-app');
    }

    /**
     * Triggers the text-to-speech functionality for a word
     *
     * @param string $word The word to be spoken
     */
    public function speakWord($word)
    {
        $this->dispatch('speak-word', ['word' => $word]);
    }

    /**
     * Reset pagination when filters are updated
     * These methods ensure the user starts from page 1 after any filter change
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPartOfSpeech()
    {
        $this->resetPage();
    }

    public function updatedDifficultyLevel()
    {
        $this->resetPage();
    }

    public function updatedFrequency()
    {
        $this->resetPage();
    }

    public function updatedWordLevel()
    {
        $this->resetPage();
    }

    /**
     * Resets all filters to their default values
     * Clears all search and filter criteria and resets pagination
     */
    public function resetFilters()
    {
        $this->search = '';
        $this->part_of_speech = '';
        $this->difficulty_level = '';
        $this->frequency = '';
        $this->word_level = '';
        $this->resetPage();
    }
}
