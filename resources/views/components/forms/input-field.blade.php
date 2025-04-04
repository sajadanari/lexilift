{{--
    Component: InputField
    Description: A customizable input field component with optional label, icon, and placeholder.
    Usage Example:
        <x-input-field
            name="email"
            label="Email"
            icon="mail"
            placeholder="email@example.com"
            id="email-input"
        />
    Attributes:
        - label: (optional) Text to display above the input field.
        - icon: (optional) Icon name to display inside the input field using Material Symbols.
        - placeholder: (optional) Placeholder text for the input field.
        - name: (required) The name attribute for the input field (used for error handling).
        - type: (optional) The input type, defaults to "text".
        - Any additional attributes will be applied to the input element.
--}}
<div class="mb-6">
    {{-- Optional label section --}}
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
        {{-- Optional icon section --}}
        @if (isset($icon) && $icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-4"
                style="color: var(--secondary-text-clr)">
                <span class="material-symbols-outlined text-xl transition-colors duration-200">
                    {{ $icon }}
                </span>
            </span>
        @endif

        {{-- Input field --}}
        <input
            type="{{ $type ?? 'text' }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder ?? '' }}"
            {{ $attributes->merge([
                'class' => 'w-full px-6 py-3.5 rounded-full transition-all duration-200',
                'style' => '
                    background-color: var(--base-clr);
                    border: 1px solid var(--line-clr);
                    color: var(--text-clr);
                    ' . (isset($icon) && $icon ? 'padding-left: 3rem;' : '')
            ]) }}
            x-data
            x-on:focus="$el.style.boxShadow = '0 0 0 2px var(--accent-clr)'"
            x-on:blur="$el.style.boxShadow = 'var(--shadow-sm)'"
        >
    </div>

    {{-- Error message --}}
    @if ($errors->has($name))
        <div class="mt-2 px-2">
            <span class="text-red-500 text-sm font-medium">
                {{ $errors->first($name) }}
            </span>
        </div>
    @endif
</div>
