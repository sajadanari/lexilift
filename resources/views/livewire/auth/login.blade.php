@push('styles')
    <style>
        .left-side {
            background-color: var(--accent-clr);
        }
    </style>
@endpush

<div class="flex h-full w-full">

    <div class="w-[60%] left-side flex items-center justify-center text-white">
        Left Side
    </div>

    <div class="w-[40%] flex items-center justify-center">

        <div class="flex items-center justify-center min-h-screen w-full">
            <div class="w-full max-w-md">
                <div class="mb-9">
                    <h2 class="text-2xl font-semibold text-start text-gray-900 mb-1">
                        Hello Again!
                    </h2>
                    <p>
                        Wellcome Back
                    </p>
                </div>

                <form wire:submit.prevent="login">

                    <x-form.input-field name="email" icon="email" placeholder="example@email.com" id="email" />

                    <x-form.input-field name="password" icon="lock" placeholder="Password" id="password"
                        type="password" />

                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        ورود
                    </button>
                </form>
            </div>
        </div>


    </div>
</div>
