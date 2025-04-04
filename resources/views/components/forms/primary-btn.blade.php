{{--
    Component: PrimaryButton
    Description:
        A customizable primary button component that utilizes the CSS variable --accent-clr for its main color.
        It optionally includes an icon and merges additional attributes into the button element for added flexibility.
        Supports both filled and outlined styles and can be disabled via a prop.

    Usage Example:
        <x-primary-button
            icon="check_circle"
            type="submit"
            :isOutline="true"
            :isDisable="true"
            id="submit-button"
            class="w-full"
        >
            Submit
        </x-primary-button>

    Props:
        - icon: (optional) The name of a Material Symbol icon to be displayed to the left of the button text.
        - type: (optional) The button's type attribute. Defaults to "button". Use "submit" to submit a form.
        - isOutline: (optional) If true, renders the button with an outlined style using --accent-clr as border/text color.
        - isDisable: (optional) If true, disables the button and applies corresponding visual styles.
        - Any additional attributes (e.g., id, class) are merged into the button element.
--}}

<?php
    // Determine base styles based on outline prop
    if (isset($isOutline) && $isOutline) {
        $classes = 'border border-[var(--accent-clr)] text-[var(--accent-clr)] hover:bg-[var(--accent-clr)] hover:text-[var(--base-clr)]';
    } else {
        $classes = 'bg-[var(--accent-clr)] text-[var(--base-clr)] shadow-sm hover:brightness-110';
    }

    // Apply disabled styles if isDisable is true
    $classes .= isset($isDisable) && $isDisable ? ' cursor-not-allowed opacity-50' : ' cursor-pointer';
?>

<button
    type="{{ $type ?? 'button' }}" {{-- Default to "button" if type not specified --}}
    {{-- Merge passed attributes and apply dynamic classes --}}
    {{ $attributes->merge([
        'class' => $classes . ' font-medium py-3.5 px-7 rounded-full transition-all duration-200
            focus:outline-none focus:ring-2 focus:ring-[var(--accent-clr)] focus:ring-opacity-50'
    ]) }}
    @if(isset($isDisable) && $isDisable) disabled @endif {{-- Set disabled attribute if applicable --}}
>
    {{-- Optional icon section (left of label) --}}
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
