<?php

namespace App\Livewire\Review;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Review extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $part_of_speech = '';

    #[Url]
    public $difficulty_level = '';

    #[Url]
    public $frequency = '';

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

        return view('livewire.review.review', [
            'words' => $query->simplePaginate(1)
        ])->layout('layouts.front-app');
    }

    public function speakWord($word)
    {
        $this->dispatch('speak-word', ['word' => $word]);
    }
}
