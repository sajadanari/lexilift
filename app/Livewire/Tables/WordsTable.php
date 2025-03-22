<?php

namespace App\Livewire\Tables;

use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class WordsTable extends BaseTable
{

    protected function baseQuery(): Builder
    {
        return Word::query();
    }

    protected function searchableFields(): array
    {
        return ['word', 'email'];
    }

    protected function columns(): array
    {
        return [
            'word' => ['label' => 'Word', 'sortable' => true],
            'part_of_speech' => ['label' => 'Part Of Speech', 'sortable' => true],
            'dificulty' => ['label' => 'Dificulty', 'sortable' => true],
            'actions' => [
                'label' => 'Actions',
                'view' => 'livewire.my-words.my-words-actions',
                'params' => [
                    'can_edit' => true
                ],
                'sortable' => false
            ],
            'created_at' => ['label' => 'Created At', 'sortable' => true],
        ];
    }


}
