{{--
    Component: PrimaryButton
    Description:
        A customizable primary button component that utilizes the CSS variable --accent-clr for its main color.
        It optionally includes an icon and merges additional attributes into the button element for added flexibility.

    Usage Example:
        <x-primary-button
            icon="check_circle"
            type="submit"
            :isOutline="true"
            id="submit-button"
            class="w-full"
        >
            Submit
        </x-primary-button>

    Attributes:
        - icon: (optional) Icon name to display inside the button using Material Symbols.
        - type: (optional) The button's type attribute, which defaults to "button".
                Use "submit" if the button should submit a form.
        - Any additional attributes passed will be merged with the default classes on the button element.
--}}

<?php
    if (isset($isOutline) && $isOutline) {
        $classes = 'border border-[var(--accent-clr)] text-[var(--accent-clr)] hover:bg-[var(--accent-clr)] hover:text-[var(--base-clr)]';
    } else {
        $classes = 'bg-[var(--accent-clr)] text-[var(--base-clr)] shadow-sm hover:brightness-110';
    }
?>

<button
    type="{{ $type ?? 'button' }}" {{-- Button type (defaults to "button" if not specified) --}}
    {{-- Merge additional attributes and apply default styling classes using --accent-clr --}}
    {{ $attributes->merge([
        'class' => $classes . ' font-medium py-3.5 px-7 rounded-full transition-all duration-200 cursor-pointer
            focus:outline-none focus:ring-2 focus:ring-[var(--accent-clr)] focus:ring-opacity-50'
    ]) }}
>
    {{-- Optional icon section --}}
    @if(isset($icon) && $icon)
        <span class="material-symbols-outlined mr-2 align-middle">
            {{ $icon }}
        </span>
    @endif

    {{-- Button label/content --}}
    <span class="align-middle">
        {{ $slot }}
    </span>
</button>
