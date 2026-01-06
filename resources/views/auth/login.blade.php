
@section('title', 'Verifika - Iniciar sesión')
<x-guest-layout>
    <div class="text-center mb-4">
        <span class="logo-circle position-relative logo-pulse" style="display:inline-block;width:54px;height:54px;background:#fff;border-radius:50%;box-shadow:0 2px 8px rgba(38,186,165,.10);overflow:hidden;vertical-align:middle;margin-bottom:1rem;">
            <img src="/images/logo.png" alt="Logo ITE" style="width:44px;height:44px;object-fit:contain;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        </span>
        <h1 style="color:rgb(55,95,122);font-weight:900;">Iniciar sesión</h1>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" style="background:rgba(38,186,165,.08);border-radius:18px;padding:2rem;box-shadow:0 8px 24px rgba(38,186,165,.10);">
        @csrf
        <div>
            <x-input-label for="phone" :value="__('Número de teléfono')" style="color:rgb(55,95,122);font-weight:700;" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="tel" placeholder="Ej: 71234567" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    <!-- Eliminado: no mostrar usuario emulado -->
        </div>
        <!-- Script eliminado: ya no se muestra ni se emula el usuario como correo -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" style="color:rgb(55,95,122);font-weight:700;" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-corp shadow-sm focus:ring-corp" name="remember">
                <span class="ms-2 text-sm" style="color:rgb(55,95,122);">{{ __('Recordarme') }}</span>
            </label>
        </div>
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm" style="color:rgb(38,186,165);font-weight:700;" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
            <x-primary-button class="ms-3" style="background:rgb(38,186,165);color:#fff;font-weight:700;border-radius:14px;padding:.8rem 1.1rem;">
                {{ __('Ingresar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
