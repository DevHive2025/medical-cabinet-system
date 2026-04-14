<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cabinet Médical') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen flex">

    @include('layouts.navigation')

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        <main class="flex-1 overflow-y-auto p-6 md:p-8">

            <div class="max-w-7xl mx-auto w-full">

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ERRORS --}}
                @if($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- PAGE CONTENT --}}
                <div class="bg-white/60 backdrop-blur-xl border border-white rounded-[1.5rem] p-6 lg:p-10 shadow-sm min-h-[calc(100vh-10rem)]">
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>