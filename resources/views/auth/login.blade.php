<x-guest-layout>

<!-- SESSION STATUS -->
<x-auth-session-status class="mb-4 text-sm text-blue-600" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

    <!-- EMAIL -->
    <div>
        <x-input-label for="email" value="Email" class="text-gray-700" />

        <x-text-input
            id="email"
            class="block mt-1 w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 bg-white/80"
            type="email"
            name="email"
            :value="old('email')"
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
            autocomplete="current-password"
        />

        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
    </div>

    <!-- REMEMBER -->
    <div class="flex items-center justify-between">

        <label class="inline-flex items-center">
            <input id="remember_me" type="checkbox"
                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                   name="remember">

            <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>

        @if (Route::has('password.request'))
            <a class="text-sm text-blue-600 hover:underline"
               href="{{ route('password.request') }}">
                Forgot password?
            </a>
        @endif

    </div>

    <!-- BUTTON -->
    <div class="pt-2">
        <x-primary-button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition shadow-lg justify-center">
            Log in
        </x-primary-button>
    </div>

</form>

</x-guest-layout>