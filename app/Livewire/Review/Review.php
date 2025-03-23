<?php

namespace App\Livewire\Review;

use Livewire\Component;
use Livewire\WithPagination;

class Review extends Component
{
    use WithPagination;

    public function render()
    {
        $words = auth()->user()->words()->simplePaginate(1);

        return view('livewire.review.review', [
            'words' => $words
        ])->layout('layouts.front-app');
    }

    public function speakWord($word)
    {
        $this->dispatch('speak-word', ['word' => $word]);
    }
}
