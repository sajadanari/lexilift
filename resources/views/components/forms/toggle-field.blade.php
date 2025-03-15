@props([
    'label' => null,
    'name' => null,
    'trueLabel' => 'Yes',
    'falseLabel' => 'No',
])

<div class="mb-4" x-data="{ checked: @entangle($attributes->wire('model')) }">
    @if (isset($label) && $label)
        <label for="{{ $attributes->get('id') ?? $name }}" class="block text-sm font-medium text-gray-700 mb-6">
            {{ $label }}
        </label>
    @endif

    <div class="flex items-center gap-3">
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer" x-model="checked"
                {{ $attributes->whereDoesntStartWith(['trueLabel', 'falseLabel']) }}>
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                        peer-checked:after:translate-x-full peer-checked:after:border-white
                        after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                        after:bg-white after:border-gray-300 after:border after:rounded-full
                        after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
            </div>
        </label>
        <span class="text-sm text-gray-600" x-text="checked ? '{{ $trueLabel }}' : '{{ $falseLabel }}'"></span>
    </div>

    @error($name)
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>
