<x-guest-layout>
    <form method="POST" action="{{ route('password.set.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email (lecture seule) -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$email" readonly />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="mt-4">
                @foreach ($errors->all() as $error)
                    <x-input-error :messages="$error" class="mt-2" />
                @endforeach
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Définir mon mot de passe') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>