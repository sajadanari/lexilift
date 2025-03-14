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

<div class="mb-4">
    @if (isset($label) && $label)
        <div class="mb-2">
            <label for="{{ $attributes->get('id') ?? $name }}" class="block text-sm font-medium text-gray-700">
                {{ $label }}
            </label>
        </div>
    @endif

    <div class="relative w-full">
        <textarea
            name="{{ $name }}"
            rows="{{ $rows ?? 3 }}"
            class="focus:outline-none focus:ring-1 focus:border-transparent
                   p-4 border border-gray-300 rounded-lg w-full resize-y"
            {{ $attributes }}
        ></textarea>
    </div>

    @if ($errors->has($name))
        <span class="text-red-500 text-sm">{{ $errors->first($name) }}</span>
    @endif
</div>
