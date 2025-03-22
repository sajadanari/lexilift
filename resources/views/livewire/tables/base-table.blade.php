{{--
    Base table template for displaying data in a sortable, searchable, and paginated table

    Example Usage in a Livewire Component:
    ```php
    class UsersTable extends BaseTable
    {
        protected function baseQuery(): Builder
        {
            return User::query();
        }

        protected function searchableFields(): array
        {
            return ['name', 'email'];
        }

        protected function columns(): array
        {
            return [
                'id' => ['label' => '#', 'sortable' => true],
                'name' => ['label' => 'Name', 'sortable' => true],
                'email' => ['label' => 'Email', 'sortable' => true],
                'status' => [
                    'label' => 'Status',
                    'view' => 'components.status-badge'
                ],
                'actions' => [
                    'label' => 'Actions',
                    'view' => 'components.table-actions'
                ]
            ];
        }
    }
    ```

    Then in your blade view:
    ```blade
    <livewire:users-table />
    ```
--}}

<div>
    {{-- Search and Per Page Controls --}}
    <div class="flex justify-between items-center mb-4">
        {{-- Search Input Field --}}
        <x-forms.input-field wire:model.live="search" type="text" placeholder="Search..." name="search" icon="search" />

        {{-- Items Per Page Selector --}}
        <x-forms.select-field name="perPage" wire:model.live="perPage">
            <option value="12">12</option>
            <option value="24">24</option>
            <option value="36">36</option>
        </x-forms.select-field>
    </div>

    {{-- Table Container --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            {{-- Table Header --}}
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @foreach($columns as $key => $column)
                        {{-- Column Headers with Sort Functionality --}}
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider {{ ($column['sortable'] ?? false) ? 'cursor-pointer' : '' }}"
                            @if($column['sortable'] ?? false) wire:click="sort('{{ $key }}')" @endif>
                            <div class="flex items-center space-x-1">
                                <span>{{ $column['label'] }}</span>
                                {{-- Sort Direction Indicator --}}
                                @if(($column['sortable'] ?? false) && $sortField === $key)
                                    <span class="material-symbols-outlined text-sm">
                                        {{ $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                    </span>
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            {{-- Table Body --}}
            <tbody>
                @foreach ($items as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        @foreach($columns as $key => $column)
                            {{-- Table Cells - First column has special styling --}}
                            <td class="px-6 py-4 @if($loop->first) font-medium text-gray-900 whitespace-nowrap dark:text-white @endif">
                                @if(isset($column['view']))
                                    {!! $this->renderCustomColumn($item, $key, $column) !!}
                                @else
                                    {{ $item->{$key} }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- No Results Message --}}
    @if($items->isEmpty())
        <div class="flex justify-center items-center h-24">
            <span class="text-gray-500 dark:text-gray-400">No results found</span>
        </div>
    @endif

    {{-- Pagination Links --}}
    <div class="p-2">
        {{ $items->links() }}
    </div>
</div>
