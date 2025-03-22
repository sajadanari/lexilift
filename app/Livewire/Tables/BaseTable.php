<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

/**
 * Abstract base class for creating reusable data tables with Livewire
 *
 * Example implementation:
 * ```php
 * class UsersTable extends BaseTable
 * {
 *     protected function baseQuery(): Builder
 *     {
 *         return User::query();
 *     }
 *
 *     protected function searchableFields(): array
 *     {
 *         return ['name', 'email'];
 *     }
 *
 *     protected function columns(): array
 *     {
 *         return [
 *             'id' => [
 *                 'label' => '#',
 *                 'sortable' => true
 *             ],
 *             'name' => [
 *                 'label' => 'Name',
 *                 'sortable' => true
 *             ],
 *             'actions' => [
 *                 'label' => 'Actions',
 *                 'view' => 'components.tables.actions'
 *             ]
 *         ];
 *     }
 * }
 * ```
 */
abstract class BaseTable extends Component
{
    use WithPagination;

    /** @var array Event listeners for the table component */
    protected $listeners = ['table-refresh' => '$refresh'];

    /** @var string Search query string */
    public $search = '';

    /** @var int Number of items to display per page */
    public $perPage = 12;

    /** @var string Column to sort by */
    public $sortField = 'id';

    /** @var string Sort direction (asc/desc) */
    public $sortDirection = 'desc';

    /**
     * URL query string parameters configuration
     * Allows table state to be saved in the URL
     */
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 12],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /**
     * Get the base query for the table
     *
     * Example:
     * ```php
     * protected function baseQuery(): Builder
     * {
     *     return Post::query()
     *         ->with(['user', 'category'])
     *         ->where('status', 'published');
     * }
     * ```
     *
     * @return Builder Base Eloquent query builder
     */
    abstract protected function baseQuery(): Builder;

    /**
     * Define which fields should be searchable in the table
     *
     * Example:
     * ```php
     * protected function searchableFields(): array
     * {
     *     return [
     *         'title',
     *         'description',
     *         'user.name',  // Search in related table
     *         'category.name'
     *     ];
     * }
     * ```
     *
     * @return array Array of database column names
     */
    abstract protected function searchableFields(): array;

    /**
     * Build the complete query with search and sorting
     * @return Builder Modified query builder with search and sort applied
     */
    protected function query(): Builder
    {
        return $this->baseQuery()
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    foreach($this->searchableFields() as $field) {
                        $query->orWhere($field, 'like', "%{$this->search}%");
                    }
                });
            })
            ->when($this->sortField, function($query) {
                $query->orderBy($this->sortField, $this->sortDirection);
            });
    }

    /**
     * Handle column sorting
     *
     * Example of how sorting works:
     * ```php
     * // When user clicks on 'name' column:
     * $this->sort('name');
     * // First click: sortField = 'name', sortDirection = 'asc'
     * // Second click: sortField = 'name', sortDirection = 'desc'
     * ```
     *
     * @param string $field Column name to sort by
     */
    public function sort($field)
    {
        // Check if column exists and is sortable
        $columns = $this->getColumns();
        if (!isset($columns[$field]) || !($columns[$field]['sortable'] ?? false)) {
            return;
        }

        // Toggle sort direction if clicking the same column
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Define the table columns and their properties
     *
     * Example:
     * ```php
     * protected function columns(): array
     * {
     *     return [
     *         'id' => [
     *             'label' => '#',
     *             'sortable' => true
     *         ],
     *         'title' => [
     *             'label' => 'Title',
     *             'sortable' => true
     *         ],
     *         'status' => [
     *             'label' => 'Status',
     *             'view' => 'components.status-badge',
     *             'params' => ['color' => 'green']
     *         ],
     *         'actions' => [
     *             'label' => 'Actions',
     *             'view' => 'components.table-actions'
     *         ]
     *     ];
     * }
     * ```
     *
     * @return array Array of column definitions
     */
    abstract protected function columns(): array;

    /**
     * Get the configured columns for the table
     * @return array Column definitions
     */
    public function getColumns()
    {
        return $this->columns();
    }

    /**
     * Render a custom column using a view
     *
     * Custom Column Example:
     * In your view file (e.g., components.status-badge.blade.php):
     * ```blade
     * <span class="badge bg-{{ $color }}">
     *     {{ $item->status }}
     * </span>
     * ```
     *
     * @param mixed $item Current row item
     * @param string $key Column key
     * @param array $column Column configuration
     * @return mixed Rendered column content
     */
    protected function renderCustomColumn($item, $key, $column)
    {
        if (isset($column['view'])) {
            $params = isset($column['params']) ? $column['params'] : [];
            return view($column['view'], array_merge(['item' => $item, 'key' => $key], $params));
        }
        return $item->{$key};
    }

    /**
     * Reset pagination when search query changes
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Render the data table
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.tables.base-table', [
            'items' => $this->query()->paginate($this->perPage),
            'columns' => $this->getColumns()
        ]);
    }
}
