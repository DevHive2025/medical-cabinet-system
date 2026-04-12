<x-guest-layout>

<div class="space-y-5">

    <!-- INFO TEXT -->
    <div class="text-sm text-gray-600 text-center">
        {{ __('Thanks for signing up! Please verify your email by clicking the link we sent you.') }}
    </div>

    <!-- STATUS MESSAGE -->
    @if (session('status') == 'verification-link-sent')
        <div class="text-sm text-green-600 text-center font-medium">
            {{ __('A new verification link has been sent to your email.') }}
        </div>
    @endif

    <!-- ACTIONS CARD -->
    <div class="space-y-4">

        <!-- RESEND FORM -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button
                class="w-full bg-blue-100 text-blue-700 py-3 rounded-lg hover:bg-blue-200 transition shadow-md justify-center">
                Resend Verification Email
            </x-primary-button>
        </form>

        <!-- LOGOUT FORM -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full text-sm text-gray-600 hover:text-gray-900 underline transition">
                Log out
            </button>
        </form>

    </div>

</div>

</x-guest-layout>