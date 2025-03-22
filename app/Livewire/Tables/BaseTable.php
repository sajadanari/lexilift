<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

/**
 * Abstract base class for creating reusable data tables with Livewire
 * Supports searching and sorting on both local and related fields
 *
 * Features:
 * - Automatic relation handling for search and sort
 * - Smart join management to prevent duplicates
 * - Configurable column formatting
 * - URL state persistence
 * - Pagination
 *
 * Usage with relations:
 * ```php
 * class UsersTable extends BaseTable
 * {
 *     // Define how related fields map to database columns
 *     protected array $relationMap = [
 *         'role.name' => ['roles', 'name', 'role_id']
 *     ];
 *
 *     protected function baseQuery(): Builder
 *     {
 *         return User::query()->with(['role']);
 *     }
 *
 *     protected function searchableFields(): array
 *     {
 *         return ['name', 'email', 'role.name'];
 *     }
 *
 *     protected function columns(): array
 *     {
 *         return [
 *             'name' => [
 *                 'label' => 'Name',
 *                 'sortable' => true
 *             ],
 *             'role.name' => [
 *                 'label' => 'Role',
 *                 'sortable' => true,
 *                 'formatter' => fn($item) => $item->role?->name
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
     * Map of relation fields to their database structure
     * Format: [field => [table, column, foreign_key]]
     * Example: ['user.name' => ['users', 'name', 'user_id']]
     *
     * This map is used to:
     * 1. Resolve relation fields to actual database columns
     * 2. Configure proper table joins
     * 3. Handle sorting and searching on related fields
     */
    protected array $relationMap = [];

    /**
     * Get relationships that require joining for search/sort operations
     * Automatically extracts relation names from dot notation fields
     * Example: 'user.name' becomes 'user'
     */
    protected function getRelationships(): array
    {
        return array_map(function($field) {
            return explode('.', $field)[0];
        }, array_filter($this->searchableFields(), function($field) {
            return str_contains($field, '.');
        }));
    }

    /**
     * Resolve a field name to its actual database column
     * Handles both local and relation fields
     * Example: 'user.name' becomes 'users.name'
     */
    protected function resolveFieldColumn(string $field): string
    {
        if (isset($this->relationMap[$field])) {
            [$table, $column] = $this->relationMap[$field];
            return "$table.$column";
        }

        if (str_contains($field, '.')) {
            [$relation, $column] = explode('.', $field);
            return "{$relation}s.{$column}";
        }

        return $field;
    }

    /**
     * Add a join clause for a relation if not already present
     * Prevents duplicate joins and handles foreign key mapping
     *
     * @param Builder $query The query builder instance
     * @param string $relation The relation name (e.g., 'user')
     * @param array $config The relation configuration [table, column, foreign_key]
     */
    protected function addJoinForRelation(Builder $query, string $relation, array $config): void
    {
        $table = $config[0] ?? "{$relation}s";
        $foreignKey = $config[2] ?? "{$relation}_id";
        $baseTable = $query->getModel()->getTable();

        // Check if join already exists
        if (!collect($query->getQuery()->joins)->pluck('table')->contains($table)) {
            $query->leftJoin($table, "$baseTable.$foreignKey", '=', "$table.id");
        }
    }

    /**
     * Build the complete query with intelligent relation handling
     * Manages joins automatically based on search and sort requirements
     *
     * Features:
     * - Automatic join management
     * - Smart search across relations
     * - Proper column name resolution
     * - Base table field selection to prevent conflicts
     *
     * @return Builder The modified query builder with all conditions applied
     */
    protected function query(): Builder
    {
        $query = $this->baseQuery();
        $baseTable = $query->getModel()->getTable();
        $addedJoins = [];

        // Helper function to add join
        $addJoin = function($field) use ($query, $baseTable, &$addedJoins) {
            if (!isset($this->relationMap[$field])) return null;

            [$table, $column, $foreignKey] = $this->relationMap[$field];

            if (!in_array($table, $addedJoins)) {
                $query->leftJoin($table, "$baseTable.$foreignKey", '=', "$table.id");
                $addedJoins[] = $table;
            }

            return "$table.$column";
        };

        // Handle search
        if ($this->search) {
            $query->where(function($query) use ($addJoin) {
                $first = true;
                foreach ($this->searchableFields() as $field) {
                    $method = $first ? 'where' : 'orWhere';
                    $first = false;

                    if (str_contains($field, '.')) {
                        if ($columnName = $addJoin($field)) {
                            $query->$method($columnName, 'like', "%{$this->search}%");
                        }
                    } else {
                        $query->$method("$field", 'like', "%{$this->search}%");
                    }
                }
            });
        }

        // Handle sorting
        if ($this->sortField) {
            $columnName = str_contains($this->sortField, '.')
                ? $addJoin($this->sortField)
                : $this->sortField;

            if ($columnName) {
                $query->orderBy($columnName, $this->sortDirection);
            }
        }

        // Always select base table fields to avoid column conflicts
        $query->select("$baseTable.*");

        return $query;
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
     * Each column can have the following properties:
     * - label: The display name for the column header
     * - sortable: Whether the column can be sorted (boolean)
     * - formatter: A callback function to format the cell value
     *   Example: 'formatter' => fn($item) => $item->status?->label()
     * - view: Path to a blade view for custom rendering
     * - params: Additional parameters to pass to the view
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
     *         'name' => [
     *             'label' => 'Name',
     *             'sortable' => true,
     *             'formatter' => fn($item) => ucfirst($item->name)
     *         ],
     *         'status' => [
     *             'label' => 'Status',
     *             'formatter' => fn($item) => $item->status?->label()
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
     * Render a custom column using a formatter or view
     *
     * @param mixed $item Current row item
     * @param string $key Column key
     * @param array $column Column configuration with optional 'formatter' or 'view'
     * @return mixed Rendered column content
     */
    protected function renderCustomColumn($item, $key, $column)
    {
        if (isset($column['formatter']) && is_callable($column['formatter'])) {
            return call_user_func($column['formatter'], $item, $key);
        }

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
