
@section('title', 'Verifika - Registrarse')
<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-2">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100 dark:border-gray-800">
            <h1 class="text-2xl font-bold text-center mb-6 text-corp dark:text-corp tracking-tight">Registrarse</h1>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div class="px-2 sm:px-4">
                    <x-input-label for="name" :value="__('Nombre')" class="font-semibold text-corp" />
                    <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="px-2 sm:px-4">
                    <x-input-label for="phone" :value="__('Número de teléfono')" class="font-semibold text-corp" />
                    <x-text-input id="phone" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="Ej: 71234567" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div class="px-2 sm:px-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="font-semibold text-corp" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="px-2 sm:px-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="font-semibold text-corp" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="flex items-center justify-between px-2 sm:px-4">
                    <a class="text-sm text-corp hover:underline font-medium" href="{{ route('login') }}">
                        {{ __('¿Ya tienes cuenta?') }}
                    </a>
                    <x-primary-button class="py-3 px-6 rounded-lg text-base font-bold bg-corp hover:bg-corp-dark transition-colors">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
