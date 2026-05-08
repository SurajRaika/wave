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

            <div class="grid gap-6 mt-12 sm:grid-cols-1 max-w-md mx-auto">
                <div class="relative p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:border-blue-500 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-colors">
                        <x-phosphor-users-three-duotone class="w-6 h-6 text-zinc-600 dark:text-zinc-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Organize Leads</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Categorize your new contacts and never miss a follow-up opportunity.</p>
                </div>
            </div>

            <div class="mt-12 text-center flex flex-col items-center gap-6">
                {{-- Block 1: Installable State --}}
                <div id="pwa-install-block" class="hide flex flex-col items-center gap-4">
                    <button id="install-pwa" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-600 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors shadow-lg shadow-blue-600/10">
                        <x-phosphor-download-simple class="w-5 h-5 mr-2" />
                        Install App for Offline Use
                    </button>
                    <p class="text-sm text-zinc-500">Install the app for a better experience</p>
                </div>

                {{-- Block 2: Success State (Shown after appinstalled) --}}
                <div id="pwa-success-block" class="hide flex flex-col items-center gap-4 p-6 bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800 rounded-2xl">
                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center">
                        <x-phosphor-check-circle-fill class="w-8 h-8" />
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">App is Installed!</h3>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">You can now find AfterMeet on your home screen or app drawer.</p>
                    </div>
                    <button id="pwa-ok-close" class="inline-flex items-center justify-center px-10 py-3 text-base font-medium text-white bg-green-600 rounded-full hover:bg-green-700 transition-colors shadow-lg shadow-green-600/20">
                        OK
                    </button>
                </div>

                {{-- Block 3: Fallback / Not Installed State --}}
                <div id="pwa-fallback-block" class="flex flex-col items-center gap-4">
                    <a href="{{ route('app.dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                        Go to App Page
                        <x-phosphor-arrow-right class="w-5 h-5 ml-2" />
                    </a>
                    <p id="fallback-text" class="text-sm text-zinc-500">Continue in browser if you don't want to install</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hide { display: none !important; }
    </style>

    <script>
        (function () {
            "use strict";

            let promptEvent = null;
            const installBlock = document.getElementById("pwa-install-block");
            const successBlock = document.getElementById("pwa-success-block");
            const fallbackBlock = document.getElementById("pwa-fallback-block");
            
            const installBtn = document.getElementById("install-pwa");
            const okCloseBtn = document.getElementById("pwa-ok-close");

            // Detect if already running in standalone mode
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

            if (isStandalone) {
                // If already in the app, just go to dashboard
                window.location.href = "{{ route('app.dashboard') }}";
                return;
            }

            // Function to show the success state
            const showSuccess = () => {
                installBlock.classList.add("hide");
                fallbackBlock.classList.add("hide");
                successBlock.classList.remove("hide");
            };

            // Before Install Prompt
            window.addEventListener("beforeinstallprompt", (e) => {
                e.preventDefault();
                promptEvent = e;
                console.log("Install prompt captured");
                
                // Show the install block if we aren't already in success mode
                if (successBlock.classList.contains("hide")) {
                    installBlock.classList.remove("hide");
                }
            });

            // Install Button Click
            installBtn.addEventListener("click", () => {
                if (promptEvent) {
                    promptEvent.prompt();
                    promptEvent.userChoice.then((choice) => {
                        console.log("User choice:", choice.outcome);
                        if (choice.outcome === 'accepted') {
                            // The appinstalled event will fire shortly
                        }
                        promptEvent = null;
                        installBlock.classList.add("hide");
                    });
                }
            });

            // App Installed Event
            window.addEventListener("appinstalled", () => {
                console.log("App successfully installed");
                showSuccess();
            });

            // OK / Close Button
            okCloseBtn.addEventListener("click", () => {
                // Attempt to close the window
                window.close();
                // Fallback: If window.close() is blocked (usual in browsers), redirect to app
                setTimeout(() => {
                    window.location.href = "{{ route('app.dashboard') }}";
                }, 500);
            });

            // Check if already installed via Related Apps API (Chrome/Edge)
            if ('getInstalledRelatedApps' in navigator) {
                navigator.getInstalledRelatedApps().then(relatedApps => {
                    if (relatedApps.length > 0) {
                        console.log("App already installed according to getInstalledRelatedApps");
                        // We could show success here, but maybe it's better to just let them "Go to App"
                        // unless they just installed it now.
                    }
                });
            }

        })();
    </script>
</x-layouts.empty>
