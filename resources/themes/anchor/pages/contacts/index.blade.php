<?php
    use function Laravel\Folio\{middleware, name};
	middleware('auth');
    name('contacts');
?>

<x-layouts.app>
	<x-app.container x-data class="lg:space-y-6" x-cloak>
        <div class="flex flex-col w-full mt-6">
            <livewire:contact-manager />
        </div>
    </x-app.container>
</x-layouts.app>
