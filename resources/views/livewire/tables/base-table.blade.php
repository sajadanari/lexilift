<div>
    <div class="flex justify-between items-center mb-4">
        <x-forms.input-field wire:model.live="search" type="text" placeholder="Search..." name="search" icon="search" />

        <x-forms.select-field name="perPage" wire:model.live="perPage">
            <option value="12">12</option>
            <option value="24">24</option>
            <option value="36">36</option>
        </x-forms.select-field>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @foreach($columns as $key => $column)
                        <th scope="col" class="px-6 py-3">
                            {{ $column['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        @foreach($columns as $key => $column)
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

    <div class="p-2">
        {{ $items->links() }}
    </div>
</div>
