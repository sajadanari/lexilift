{{--
    Component: TextareaField
    Description: A customizable textarea field component with optional label

    Usage Example:
        <x-textarea-field
            name="description"
            label="Description"
            placeholder="Enter description..."
            rows="4"
        />

    Attributes:
        - label: (optional) Text to display above the textarea
        - name: (required) The name attribute for the textarea (used for error handling)
        - rows: (optional) Number of visible rows (default: 3)
        - Any additional attributes will be applied to the textarea element
--}}

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

    <div class="w-full mx-auto">
        <textarea
            name="{{ $name }}"
            rows="{{ $rows ?? 3 }}"
            {{ $attributes->merge([
                'class' => 'w-full px-6 py-4 rounded-2xl transition-all duration-200 resize-y',
                'style' => '
                    background-color: var(--base-clr);
                    border: 1px solid var(--line-clr);
                    color: var(--text-clr);
                    min-height: 120px;
                '
            ]) }}
            x-data
            x-on:focus="$el.style.boxShadow = '0 0 0 2px var(--accent-clr)'"
            x-on:blur="$el.style.boxShadow = 'var(--shadow-sm)'"
        ></textarea>
    </div>

    @if ($errors->has($name))
        <div class="mt-2 px-2">
            <span class="text-red-500 text-sm font-medium">
                {{ $errors->first($name) }}
            </span>
        </div>
    @endif
</div>
