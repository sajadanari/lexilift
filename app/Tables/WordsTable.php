<?php

namespace App\Tables;

use App\Models\Word;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class WordsTable extends DataTableComponent
{
    protected $model = Word::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        
            ->setTableWrapperAttributes([
                'default' => false,
                'default-colors' => false,
                'class' => 'rounded-lg overflow-hidden',
            ])
            ->setTableAttributes([
                'default' => false,
                'default-colors' => false,
                'class' => 'table-auto w-full',
            ])
            ->setTheadAttributes([
                'default' => false,
                'default-colors' => false,
                'class' => 'bg-gray-900',
            ])
            ->setTbodyAttributes([
                'default' => false,
                'default-colors' => false,
                'class' => 'bg-white',
            ])
            ->setThAttributes(function(Column $column) {
                return [
                    'default' => false,
                    'default-colors' => false,
                    'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
                ];
            })
            ->setTdAttributes(function(Column $column) {
                return [
                    'default' => false,
                    'default-colors' => false,
                    'class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900',
                ];
            })
            ->setTrAttributes(function($row, $index) {
                  return [
                    'default' => false,
                    'default-color' => false,
                    'class' => 'hover:bg-gray-100 boder border-b border-gray-200',
                  ];
            })

            ->setSearchFieldAttributes([
                'default' => false,
                'default-color' => false,
                'class' => 'py-4 px-3',
              ])

            ->setSearchIcon('heroicon-m-magnifying-glass')

            ->setSearchIconAttributes([
                'default' => true,
                'default-color' => false,
                'class' => 'h-4 w-4 mx-3',
                'style' => 'color: #000000',
            ])

            ->setColumnSelectDisabled()

            ->setPerPageFieldAttributes([
                'default' => false,
                'default-color' => false,
                'default-styles' => false,
                'class' => 'rounded-md p-4 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300',
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
