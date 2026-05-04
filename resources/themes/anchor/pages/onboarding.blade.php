<?php
    use function Laravel\Folio\{middleware, name};
    middleware('auth');
    name('onboarding');
?>

<x-layouts.empty>
    <div class="flex flex-col items-center justify-center min-h-screen py-12 bg-zinc-50 dark:bg-zinc-950">
        <div class="w-full max-w-2xl px-6">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mb-6">
                    <x-phosphor-sparkle-duotone class="w-10 h-10" />
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">Welcome to AfterMeet!</h1>
                <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">We're excited to have you here. Let's get you set up in just a few seconds.</p>
            </div>

            <div class="grid gap-6 mt-12 sm:grid-cols-2">
                <div class="relative p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-blue-500 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-colors">
                        <x-phosphor-camera-duotone class="w-6 h-6 text-zinc-600 dark:text-zinc-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Scan Cards</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Instantly capture contact info from business cards with our scanner.</p>
                </div>

                <div class="relative p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-blue-500 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-colors">
                        <x-phosphor-users-three-duotone class="w-6 h-6 text-zinc-600 dark:text-zinc-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Organize Leads</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Categorize your new contacts and never miss a follow-up opportunity.</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                    Get Started
                    <x-phosphor-arrow-right class="w-5 h-5 ml-2" />
                </a>
            </div>
        </div>
    </div>
</x-layouts.empty>
