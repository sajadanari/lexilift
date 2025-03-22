<?php

namespace App\Livewire\Tables;

use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;

/**
 * Words table implementation with relation handling
 * Supports searching and sorting on both word fields and related user data
 */
class AdminWordsTable extends BaseTable
{
    /**
     * Configure relation field mapping
     * Maps 'user.name' to users table with proper foreign key
     */
    protected array $relationMap = [
        'user.name' => ['users', 'name', 'user_id']
    ];

    protected function baseQuery(): Builder
    {
        return Word::query()->with(['user']);
    }

    protected function searchableFields(): array
    {
        return ['word','part_of_speech', 'difficulty_level', 'user.name'];
    }

    protected function columns(): array
    {
        return [
            'word' => ['label' => 'Word', 'sortable' => true],
            'part_of_speech' => [
                'label' => 'Part Of Speech',
                'sortable' => true,
                'formatter' => fn($item) => $item->part_of_speech?->label()
            ],
            'difficulty_level' => [
                'label' => 'Difficulty',
                'sortable' => true,
                'formatter' => fn($item) => $item->difficulty_level?->label()
            ],
            'user.name' => [
                'label' => 'User',
                'sortable' => true,
                'formatter' => fn($item) => $item->user->name
            ],
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
