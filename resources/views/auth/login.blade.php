
@section('title', 'Verifika - Iniciar sesión')
<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-2">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100 dark:border-gray-800">
            <h1 class="text-2xl font-bold text-center mb-6 text-corp dark:text-corp tracking-tight">Iniciar sesión</h1>
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div class="px-2 sm:px-4">
                    <x-input-label for="phone" :value="__('Número de teléfono')" class="font-semibold text-corp" />
                    <x-text-input id="phone" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="tel" placeholder="Ej: 71234567" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div class="px-2 sm:px-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="font-semibold text-corp" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex items-center justify-between px-2 sm:px-4">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-corp shadow-sm focus:ring-corp" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Recordarme') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-corp hover:underline font-medium" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>
                <div class="px-2 sm:px-4">
                    <x-primary-button class="w-full py-3 rounded-lg text-base font-bold bg-corp hover:bg-corp-dark transition-colors flex items-center justify-center">
                        {{ __('Ingresar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
