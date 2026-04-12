<x-guest-layout>

<form method="POST" action="{{ route('password.store') }}" class="space-y-5">
    @csrf

    <!-- TOKEN -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- EMAIL -->
    <div>
        <x-input-label for="email" value="Email" class="text-gray-700" />

        <x-text-input
            id="email"
            class="block mt-1 w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 bg-white/80"
            type="email"
            name="email"
            :value="old('email', $request->email)"
            required
            autofocus
            autocomplete="username"
        />

        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
    </div>

    <!-- PASSWORD -->
    <div>
        <x-input-label for="password" value="Password" class="text-gray-700" />

        <x-text-input
            id="password"
            class="block mt-1 w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 bg-white/80"
            type="password"
            name="password"
            required
            autocomplete="new-password"
        />

        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
    </div>

    <!-- CONFIRM PASSWORD -->
    <div>
        <x-input-label for="password_confirmation" value="Confirm Password" class="text-gray-700" />

        <x-text-input
            id="password_confirmation"
            class="block mt-1 w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 bg-white/80"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"
        />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
    </div>

    <!-- BUTTON -->
    <div class="pt-2">
        <x-primary-button
            class="w-full bg-blue-100 text-blue-700 py-3 rounded-lg hover:bg-blue-200 transition shadow-md justify-center">
            Reset Password
        </x-primary-button>
    </div>

</form>

</x-guest-layout>