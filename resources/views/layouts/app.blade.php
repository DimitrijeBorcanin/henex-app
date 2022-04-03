<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <script src="https://kit.fontawesome.com/fa2b9bf0b8.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">

        {{-- Success message --}}
        <div class="fixed top-20 w-full flex justify-center"
            x-data="{ shown: false, timeout: null, message: null }"
            @flashsuccess.window="(e) => { clearTimeout(timeout); shown = true; message = e.detail.message; timeout = setTimeout(() => { shown = false; message = null }, 2000); }"
            x-show="shown"
            x-transition
            style="display:none;">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-1/4" role="alert">
                <span class="block sm:inline" x-text="message"></span>
            </div>
        </div>

        {{-- Error message --}}
        <div class="fixed top-20 w-full flex justify-center"
            x-data="{ shown: false, timeout: null, message: null }"
            @flasherror.window="(e) => { location.reload(); clearTimeout(timeout); shown = true; message = e.detail.message; timeout = setTimeout(() => { shown = false; message = null }, 2000); }"
            x-show="shown"
            x-transition
            style="display:none;">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-1/4" role="alert">
                <span class="block sm:inline" x-text="message"></span>
            </div>
        </div>

        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="px-4 md:px-0">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script src="{{ asset('js/stateChecker.js') }}"></script>
    </body>
</html>
