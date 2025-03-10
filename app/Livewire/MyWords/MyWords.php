<?php

namespace App\Livewire\MyWords;

use Livewire\Component;

class MyWords extends Component
{
    public function render()
    {
        return view('livewire.my-words.my-words')->layout('layouts.front-app');
    }
}