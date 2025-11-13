<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-background py-12 px-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-soft p-8">
            <h2 class="text-2xl font-semibold text-primary text-center mb-6">
                {{ __('Connexion à votre compte') }}
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Adresse e-mail')" class="text-gray-700 font-medium" />
                    <x-text-input id="email" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-medium" />
                    <x-text-input id="password" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-primary hover:text-blue-700 transition">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>

                <!-- Bouton Connexion -->
                <div>
                    <button type="submit"
                        class="w-full bg-primary text-white font-medium py-2 rounded-lg hover:bg-blue-600 transition shadow-soft">
                        {{ __('Se connecter') }}
                    </button>
                </div>

                <!-- Lien vers inscription -->
                <div class="text-center mt-6 border-t border-gray-200 pt-4">
                    <span class="text-sm text-gray-600">{{ __("Vous n'avez pas de compte ?") }}</span>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-primary hover:text-blue-700 transition">
                        {{ __('Inscrivez-vous') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
