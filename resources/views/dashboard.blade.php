<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-primary">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-soft p-8">
            <h3 class="text-lg font-medium mb-4 text-gray-700">
                Bienvenue 👋 {{ Auth::user()->name }}
            </h3>

            <p class="text-gray-600 mb-6">
                Vous êtes connecté avec succès à votre compte.
            </p>

            <div class="flex gap-4">
                <a href="{{ route('profile.edit') }}"
                   class="inline-block bg-primary text-white font-medium px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Voir mon profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-block bg-secondary text-white font-medium px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
