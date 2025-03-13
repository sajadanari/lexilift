{{-- 
    Component: MainLink
    Description:
        A customizable main link component that displays a styled hyperlink with an optional icon.
        It leverages the site's accent color (--accent-clr) for its text color and applies a hover underline effect.
    
    Usage Example:
        <x-main-link
            href="/register"
            icon="login"
            class="ml-4"
        >
            Sign up here
        </x-main-link>
    
    Attributes:
        - href: (required) The URL the link points to.
        - icon: (optional) Icon name to display before the link text using Material Symbols.
        - Any additional attributes will be merged into the anchor element.
--}}

<a 
    href="{{ $href }}" {{-- The destination URL for the link --}}
    {{ $attributes->merge([
         'class' => 'text-[var(--accent-clr)] hover:underline font-medium inline-flex items-center'
    ]) }}
>
    {{-- Optional icon section --}}
    @if(isset($icon) && $icon)
        <span class="material-symbols-outlined mr-2 align-middle">
            {{ $icon }}
        </span>
    @endif

    {{-- Link label/content --}}
    <span class="align-middle">
        {{ $slot }}
    </span>
</a>
