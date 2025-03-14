<?php

namespace App\Tables;

use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class WordsTable extends DataTableComponent
{
    protected $model = Word::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableWrapperAttributes([
                'class' => 'rounded-lg overflow-hidden',
            ])
            ->setTableAttributes([
                'class' => 'table-auto w-full',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Word', 'word')
                ->sortable()
                ->searchable(),
            Column::make('Part of Speech', 'part_of_speech')
                ->sortable(),
            Column::make('Difficulty', 'difficulty_level')
                ->sortable(),
            
            Column::make('Actions', 'id')
                ->format(function($value, $row, Column $column) {
                    return view('livewire.tables.words-table-actions', ['word' => $row]);
                }),
        ];
    }
}
