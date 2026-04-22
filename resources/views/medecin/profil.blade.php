<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

    <main class="flex-1 ml-64 p-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mon Profil</h1>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-8 max-w-2xl">

            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-full bg-green-600 flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($medecin->user->nom, 0, 1)) }}{{ strtoupper(substr($medecin->user->prenom, 0, 1)) }}
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-800">Dr. {{ $medecin->user->nom }} {{ $medecin->user->prenom }}</p>
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">{{ $medecin->specialite }}</span>
                </div>
            </div>

            <form action="{{ route('medecin.profil.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $medecin->user->nom) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $medecin->user->prenom) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $medecin->user->email) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input type="password" name="password" placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition">
                    Mettre à jour
                </button>
            </form>
        </div>
</div>
</x-app-layout>
