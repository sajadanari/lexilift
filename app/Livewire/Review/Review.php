<?php

namespace App\Livewire\Review;

use Livewire\Component;

class Review extends Component
{
    public function render()
    {
        return view('livewire.review.review')->layout('layouts.front-app');
    }
}
