@props([
    'label' => null,
    'name' => null,
    'trueLabel' => 'Yes',
    'falseLabel' => 'No',
])

<div class="mb-6" x-data="{ checked: @entangle($attributes->wire('model')) }">
    @if (isset($label) && $label)
        <div class="mb-2.5">
            <label for="{{ $attributes->get('id') ?? $name }}"
                class="block text-sm font-semibold mb-1 px-2"
                style="color: var(--text-clr)">
                {{ $label }}
            </label>
        </div>
    @endif

    <div class="flex items-center gap-3">
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox"
                class="sr-only peer"
                x-model="checked"
                {{ $attributes->whereDoesntStartWith(['trueLabel', 'falseLabel']) }}>
            <div class="w-11 h-6 rounded-full transition-all duration-200 peer-focus:ring-2 peer-focus:ring-[var(--accent-clr)]"
                :class="checked ? 'bg-[var(--accent-clr)]' : 'bg-[var(--line-clr)]'"
                style="box-shadow: var(--shadow-sm)">
                <div class="absolute inset-y-1 start-1 w-4 h-4 rounded-full transition-all duration-200 transform"
                    :class="checked ? 'translate-x-5 bg-[var(--base-clr)]' : 'translate-x-0 bg-[var(--text-clr)]'">
                </div>
            </div>
        </label>
        <span class="text-sm transition-colors duration-200"
            style="color: var(--secondary-text-clr)"
            x-text="checked ? '{{ $trueLabel }}' : '{{ $falseLabel }}'">
        </span>
    </div>

    @error($name)
        <div class="mt-2 px-2">
            <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
        </div>
    @enderror
</div>
