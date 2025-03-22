<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 12],
    ];

    abstract protected function baseQuery(): Builder;

    abstract protected function searchableFields(): array;

    protected function query(): Builder
    {
        return $this->baseQuery()
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    foreach($this->searchableFields() as $field) {
                        $query->orWhere($field, 'like', "%{$this->search}%");
                    }
                });
            });
    }

    abstract protected function columns(): array;

    public function getColumns()
    {
        return $this->columns();
    }

    protected function renderCustomColumn($item, $key, $column)
    {
        if (isset($column['view'])) {
            $params = isset($column['params']) ? $column['params'] : [];
            return view($column['view'], array_merge(['item' => $item, 'key' => $key], $params));
        }
        return $item->{$key};
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.tables.base-table', [
            'items' => $this->query()->paginate($this->perPage),
            'columns' => $this->getColumns()
        ]);
    }
}
