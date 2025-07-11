<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h1 class="text-3xl font-bold text-green-custom text-center mb-2">LOGIN</h1>
    <p class="text-center text-gray-700 mb-6">Entre com seus dados institucionais</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="numIdentidade" :value="__('CPF')" />
            <x-text-input id="numIdentidade" class="block mt-1 w-full" type="text" name="numIdentidade" :value="old('numIdentidade')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('numIdentidade')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me/comentado pois nao esta no layout
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div> --}}

        <div>
            <div class="flex justify-end mt-1">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <x-primary-button class="w-full bg-green-custom hover:bg-green-800 text-white font-bold py-2 rounded-md text-center justify-center mt-4">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>