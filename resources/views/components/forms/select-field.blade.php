<div class="mb-4">
    @if (isset($label) && $label)
        <div class="mb-2 text-center">
            <label for="{{ $attributes->get('id') ?? $name }}" class="block text-sm font-medium text-gray-700">
                {{ $label }}
            </label>
        </div>
    @endif

    <div class="relative w-full max-w-md">
        @if (isset($icon) && $icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-6 text-gray-400">
                <span class="material-symbols-outlined text-xl">
                    {{ $icon }}
                </span>
            </span>
        @endif

        <select name="{{ $name }}"
            class="focus:outline-none focus:ring-1 focus:border-transparent
                   {{ isset($icon) && $icon ? 'pl-14' : 'pl-6' }} pr-4 py-4 border border-gray-300 rounded-full w-full
                   appearance-none bg-white"
            {{ $attributes }}>
            @if (isset($placeholder))
                <option value="">{{ $placeholder }}</option>
            @endif
            {{ $slot }}
        </select>

        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
            <span class="material-symbols-outlined text-gray-400">
                expand_more
            </span>
        </span>
    </div>

    @if ($errors->has($name))
        <span class="text-red-500 text-sm">{{ $errors->first($name) }}</span>
    @endif
</div>
