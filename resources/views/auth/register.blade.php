<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-background py-12 px-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-soft p-8">
            <h2 class="text-2xl font-semibold text-primary text-center mb-6">
                {{ __("Créer un compte") }}
            </h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Nom -->
                <div>
                    <x-input-label for="name" :value="__('Nom complet')" class="text-gray-700 font-medium" />
                    <x-text-input id="name"
                        class="block mt-2 w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Adresse Email -->
                <div>
                    <x-input-label for="email" :value="__('Adresse e-mail')" class="text-gray-700 font-medium" />
                    <x-text-input id="email"
                        class="block mt-2 w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
                    <x-text-input id="password"
                        class="block mt-2 w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-700 font-medium" />
                    <x-text-input id="password_confirmation"
                        class="block mt-2 w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Bouton et lien vers Connexion -->
                <div class="flex flex-col items-center justify-center mt-6 space-y-3">
                    <button type="submit"
                        class="w-full bg-primary text-white font-medium py-2 rounded-lg hover:bg-blue-600 transition shadow-soft">
                        {{ __("S'inscrire") }}
                    </button>

                    <p class="text-sm text-gray-600">
                        {{ __('Déjà inscrit ?') }}
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:text-blue-700 transition">
                            {{ __('Se connecter') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
