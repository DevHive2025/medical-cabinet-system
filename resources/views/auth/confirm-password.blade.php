<x-guest-layout>

<div class="space-y-4">

    <!-- INFO TEXT -->
    <div class="text-sm text-gray-600 text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <!-- FORM -->
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- PASSWORD -->
        <div>
            <x-input-label for="password" value="Password" class="text-gray-700" />

            <x-text-input
                id="password"
                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 bg-white/80"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- BUTTON -->
        <div class="pt-2">
            <x-primary-button
                class="w-full bg-blue-100 text-blue-700 py-3 rounded-lg hover:bg-blue-200 transition shadow-md justify-center">
                Confirm
            </x-primary-button>
        </div>

    </form>

</div>

</x-guest-layout>