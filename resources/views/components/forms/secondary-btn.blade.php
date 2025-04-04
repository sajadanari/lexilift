{{--
    Component: SecondaryButton
    Description: A customizable secondary button component with a subtle design

    Usage Example:
        <x-secondary-button
            icon="close"
            type="button"
            class="w-full"
        >
            Cancel
        </x-secondary-button>

    Attributes:
        - icon: (optional) Icon name to display inside the button using Material Symbols
        - type: (optional) The button's type attribute (defaults to "button")
        - Any additional attributes will be merged with the button element
--}}

<button
    type="{{ $type ?? 'button' }}"
    {{ $attributes->merge([
        'class' => 'bg-[var(--line-clr)] text-[var(--text-clr)] hover:brightness-110
            font-medium py-3.5 px-7 rounded-full transition-all duration-200 cursor-pointer
            focus:outline-none focus:ring-2 focus:ring-[var(--line-clr)] focus:ring-opacity-50'
    ]) }}
>
    @if(isset($icon) && $icon)
        <span class="material-symbols-outlined mr-2 align-middle transition-colors">
            {{ $icon }}
        </span>
    @endif

    <span class="align-middle">
        {{ $slot }}
    </span>
</button>
