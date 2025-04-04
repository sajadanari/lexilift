<div class="mb-6">
    @if (isset($label) && $label)
        <div class="mb-2.5">
            <label for="{{ $attributes->get('id') ?? $name }}"
                class="block text-sm font-semibold mb-1 px-2"
                style="color: var(--text-clr)">
                {{ $label }}
            </label>
        </div>
    @endif

    <div class="relative w-full max-w-md mx-auto">
        @if (isset($icon) && $icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-4"
                style="color: var(--secondary-text-clr)">
                <span class="material-symbols-outlined text-xl transition-colors duration-200">
                    {{ $icon }}
                </span>
            </span>
        @endif

        <select
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'w-full px-6 py-3.5 rounded-full transition-all duration-200 appearance-none',
                'style' => '
                    background-color: var(--base-clr);
                    border: 1px solid var(--line-clr);
                    color: var(--text-clr);
                    padding-right: 3rem;
                    ' . (isset($icon) && $icon ? 'padding-left: 3rem;' : '')
            ]) }}
            x-data
            x-on:focus="$el.style.boxShadow = '0 0 0 2px var(--accent-clr)'"
            x-on:blur="$el.style.boxShadow = 'var(--shadow-sm)'"
        >
            @if (isset($placeholder))
                <option value="" style="color: var(--secondary-text-clr)">{{ $placeholder }}</option>
            @endif
            {{ $slot }}
        </select>

        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none"
            style="color: var(--secondary-text-clr)">
            <span class="material-symbols-outlined text-xl transition-colors duration-200">
                expand_more
            </span>
        </span>
    </div>

    @if ($errors->has($name))
        <div class="mt-2 px-2">
            <span class="text-red-500 text-sm font-medium">
                {{ $errors->first($name) }}
            </span>
        </div>
    @endif
</div>
