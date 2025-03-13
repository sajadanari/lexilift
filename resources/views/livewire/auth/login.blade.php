@push('styles')
    <style>
        .left-side {
            background-color: var(--accent-clr);
        }
    </style>
@endpush

<div class="flex h-full w-full">

    {{-- If screen was small, just show right side and hide left side --}}
    <div class="display-none md:flex md:w-[60%] left-side flex items-center justify-center text-white">
        
    </div>

    <div class="w-full px-4 md:w-[40%] md:px-4 flex items-top justify-center">

        <div class="flex items-top md:items-center pt-4 md:p-0 justify-center min-h-screen w-full">
            <div class="w-full max-w-md">

                <div class="mb-2">
                    <x-ui.horizontal-logo />
                </div>

                <div class="mb-9">
                    <h2 class="text-2xl font-semibold text-start text-gray-900 mb-1">
                        Hello Again!
                    </h2>
                    <p>
                        Wellcome Back
                    </p>
                </div>

                <form wire:submit.prevent="login">

                    <x-forms.input-field name="email" icon="email" placeholder="example@email.com" id="email" wire:model="email"/>

                    <x-forms.input-field name="password" icon="lock" placeholder="Password" id="password"
                        type="password"
                        wire:model="password" />

                        <x-forms.primary-btn
                        type="submit"
                        id="login-button"
                        class="w-full"
                    >
                        Login
                    </x-forms.primary-btn>

                    <div class="text-center mt-4">
                        Don't have an account?
                        <x-links.main-link
                            href="{{ route('auth.register') }}"
                            class=""
                        >
                            Sign up now!
                        </x-links.main-link>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
