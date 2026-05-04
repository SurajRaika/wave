<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
<head>
    @include('theme::partials.head', ['seo' => ($seo ?? null) ])
    <script>
        if (typeof(Storage) !== "undefined") {
            if(localStorage.getItem('theme') && localStorage.getItem('theme') == 'dark'){
                document.documentElement.classList.add('dark');
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 overflow-hidden">
    <div class="flex flex-col h-full">
        {{-- Scanner Header --}}
        <header class="flex items-center justify-between px-4 py-3 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100">
                <x-phosphor-arrow-left class="w-6 h-6" />
            </a>
            <h1 class="text-lg font-bold">Business Card Scanner</h1>
            <div class="w-10"></div> {{-- Spacer for centering title --}}
        </header>

        {{-- Main Content --}}
        <main class="flex-1 relative overflow-hidden">
            {{ $slot }}
        </main>

        {{-- Scanner Footer/Controls --}}
        <footer class="px-6 py-8 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
            <div class="flex justify-around items-center max-w-md mx-auto">
                <button class="flex flex-col items-center space-y-1 text-zinc-500 hover:text-blue-600">
                    <x-phosphor-image class="w-7 h-7" />
                    <span class="text-xs">Gallery</span>
                </button>
                <div class="relative">
                    <button class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-blue-600/20 active:scale-95 transition-transform">
                        <x-phosphor-camera class="w-8 h-8" />
                    </button>
                </div>
                <button class="flex flex-col items-center space-y-1 text-zinc-500 hover:text-blue-600">
                    <x-phosphor-lightning class="w-7 h-7" />
                    <span class="text-xs">Flash</span>
                </button>
            </div>
        </footer>
    </div>
</body>
</html>
