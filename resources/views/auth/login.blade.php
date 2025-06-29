<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-s8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Latar belakang utama dengan gradient --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">

            {{-- Kotak Form Login --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-slate-800 shadow-xl overflow-hidden sm:rounded-lg">

                {{-- Header Form --}}
                <div class="text-center mb-8">
                     <h1 class="text-3xl font-bold text-white">
                        <i class="fas fa-user-shield mr-2 text-purple-400"></i>
                        Staff Login
                    </h1>
                    <p class="text-slate-400 mt-2">Masuk untuk mengakses panel Anda.</p>
                </div>


                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email" class="block font-medium text-sm text-slate-300 mb-1">Email</label>
                        <input id="email" class="block mt-1 w-full bg-slate-700 border-slate-600 text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block font-medium text-sm text-slate-300 mb-1">Password</label>
                        <input id="password" class="block mt-1 w-full bg-slate-700 border-slate-600 text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded bg-slate-700 border-slate-600 text-purple-600 shadow-sm focus:ring-purple-500" name="remember">
                            <span class="ms-2 text-sm text-slate-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-slate-400 hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit" class="ms-3 inline-flex items-center px-6 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>