<?php
    use function Laravel\Folio\{middleware, name};
    middleware('auth');
    name('scanner');
?>

<x-layouts.scanner>
    <div class="absolute inset-0 bg-black flex items-center justify-center">
        {{-- Viewfinder --}}
        <div class="relative w-4/5 aspect-[3.5/2] border-2 border-white/50 rounded-lg shadow-[0_0_0_100vw_rgba(0,0,0,0.6)]">
            {{-- Corners --}}
            <div class="absolute -top-1 -left-1 w-6 h-6 border-t-4 border-l-4 border-blue-500 rounded-tl-sm"></div>
            <div class="absolute -top-1 -right-1 w-6 h-6 border-t-4 border-r-4 border-blue-500 rounded-tr-sm"></div>
            <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-4 border-l-4 border-blue-500 rounded-bl-sm"></div>
            <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-4 border-r-4 border-blue-500 rounded-br-sm"></div>
            
            {{-- Scanning Line Animation --}}
            <div class="absolute inset-x-0 top-0 h-0.5 bg-blue-400/80 shadow-[0_0_15px_rgba(96,165,250,0.8)] animate-scan"></div>
        </div>

        {{-- Instruction Text --}}
        <div class="absolute bottom-10 left-0 right-0 text-center px-10">
            <p class="text-white text-sm font-medium bg-black/40 backdrop-blur-md py-2 px-4 rounded-full inline-block">
                Align business card within the frame
            </p>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .animate-scan {
            animation: scan 3s linear infinite;
            position: absolute;
        }
    </style>
</x-layouts.scanner>
