<x-guest-layout>

<form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <!-- NOM + PRENOM -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="nom" value="Nom" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="prenom" value="Prénom" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <!-- DATE NAISSANCE -->
        <div>
            <x-input-label for="date_naissance" value="Date de naissance" />
            <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" :value="old('date_naissance')" required />
            <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
        </div>
        <!-- CIN -->
        <div>
            <x-input-label for="cin" value="CIN" />
            <x-text-input id="cin" class="block mt-1 w-full" type="text" name="cin" :value="old('cin')" required />
            <x-input-error :messages="$errors->get('cin')" class="mt-2" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <!-- EMAIL -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- TELEPHONE -->
        <div>
            <x-input-label for="telephone" value="Téléphone" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <!-- PASSWORD -->
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- CONFIRM -->
        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>

    <div class="flex justify-between items-center">
        <a class="text-sm text-blue-600" href="{{ route('login') }}">
            Already registered?
        </a>
    </div>

    <x-primary-button class="w-full justify-center">
        Register
    </x-primary-button>
</form>
</x-guest-layout>