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
<div class="mb-4">
    {{-- Optional label section --}}
    @if (isset($label) && $label)
        <div class="mb-2 text-center">
            <label for="{{ $attributes->get('id') ?? $name }}" class="block text-sm font-medium text-gray-700">
                {{ $label }}
            </label>
        </div>
    @endif

    <div class="relative w-full max-w-md">
        {{-- Optional icon section --}}
        @if (isset($icon) && $icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-6 text-gray-400">
                <span class="material-symbols-outlined text-xl">
                    {{ $icon }}
                </span>
            </span>
        @endif

        {{-- Input field --}}
        <input type="{{ $type ?? 'text' }}" {{-- Input type (default: text) --}} name="{{ $name }}" {{-- Input name (used for error handling) --}}
            placeholder="{{ $placeholder ?? '' }}" {{-- Optional placeholder text --}}
            class="focus:outline-none focus:ring-1 focus:border-transparent
                   {{ isset($icon) && $icon ? 'pl-14' : 'pl-6' }} pr-4 py-4 border border-gray-300 rounded-full w-full"
            {{ $attributes }} {{-- Merge any additional attributes --}}>
    </div>

    {{-- Display error message for the given input name if it exists --}}
    @if ($errors->has($name))
        <span class="text-red-500 text-sm">{{ $errors->first($name) }}</span>
    @endif
</div>
