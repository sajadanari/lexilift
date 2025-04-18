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
    <div class="flex flex-col w-full sm:flex-row justify-between items-center gap-4 mb-6">
        <x-forms.input-field wire:model.live="search" type="text" placeholder="Search..." name="search" icon="search"
            class="w-full transition-all duration-300 focus:w-full sm:focus:w-72" />

        <x-forms.select-field name="perPage" wire:model.live="perPage" class="transition-all duration-200 w-full md:w-32">
            <option value="12">12 items</option>
            <option value="24">24 items</option>
            <option value="36">36 items</option>
        </x-forms.select-field>
    </div>

    {{-- Table Container --}}
    <div class="overflow-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[var(--secondary-base-clr)] rounded-xl">
                    @foreach ($columns as $key => $column)
                        <th class="group px-6 py-4 text-left font-medium {{ $column['sortable'] ?? false ? 'cursor-pointer transition-colors hover:bg-[var(--hover-clr)]' : '' }} @if ($loop->first) rounded-l-xl @endif @if ($loop->last) rounded-r-xl @endif"
                            @if ($column['sortable'] ?? false) wire:click="sort('{{ $key }}')" @endif>
                            <div class="flex items-center gap-2 text-[var(--text-clr)]">
                                <span>{{ $column['label'] }}</span>
                                @if ($column['sortable'] ?? false)
                                    <span
                                        class="material-symbols-outlined text-sm opacity-60 group-hover:opacity-100 transition-opacity {{ $sortField === $key ? 'opacity-100' : '' }}">
                                        {{ $sortField === $key && $sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}
                                    </span>
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-[var(--line-clr)]">
                @foreach ($items as $item)
                    <tr class="transition-colors hover:bg-[var(--hover-clr)]">
                        @foreach ($columns as $key => $column)
                            <td class="px-6 py-4 @if ($loop->first) font-medium @endif">
                                @if (isset($column['formatter']) || isset($column['view']))
                                    <div class="text-[var(--secondary-text-clr)]">
                                        {!! $this->renderCustomColumn($item, $key, $column) !!}
                                    </div>
                                @else
                                    <span class="text-[var(--secondary-text-clr)]">{{ $item->{$key} }}</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- No Results Message --}}
    @if ($items->isEmpty())
        <div
            class="flex justify-center items-center h-32 rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 mt-3">
            <div class="text-center">
                <span class="material-symbols-outlined text-3xl text-gray-400 dark:text-gray-500 mb-2">search_off</span>
                <p class="text-gray-500 dark:text-gray-400">No results found</p>
            </div>
        </div>
    @endif

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $items->links('components.pagination') }}
    </div>
</div>
