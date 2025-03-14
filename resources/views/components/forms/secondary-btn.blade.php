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
        'class' => 'bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-300 cursor-pointer'
    ]) }}
>
    @if(isset($icon) && $icon)
        <span class="material-symbols-outlined mr-2 align-middle">
            {{ $icon }}
        </span>
    @endif

    <span class="align-middle">
        {{ $slot }}
    </span>
</button>
