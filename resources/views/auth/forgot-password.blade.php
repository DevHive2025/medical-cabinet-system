<x-guest-layout>

<div class="space-y-5">

    <!-- TEXT -->
    <div class="text-sm text-gray-600 text-center">
        {{ __('Forgot your password? No problem. Enter your email and we will send you a reset link.') }}
    </div>

    <!-- SESSION STATUS -->
    <x-auth-session-status class="text-sm text-blue-600 text-center" :status="session('status')" />

    <!-- FORM -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- BUTTON -->
        <div class="pt-2">
            
            <x-primary-button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition shadow-lg justify-center">
                Email Reset Link
            </x-primary-button>
        </div>

    </form>

</div>

</x-guest-layout>