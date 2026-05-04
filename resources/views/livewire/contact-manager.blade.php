<div x-data="{ open: false }" @close-modal.window="open = false">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold dark:text-zinc-100">Contacts</h2>
        <x-button @click="open = true" class="text-sm">Add New Contact</x-button>
    </div>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" @click="open = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-zinc-900 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:p-6" role="dialog">
                <form wire:submit.prevent="addContact" class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-zinc-900 dark:text-zinc-100">Add New Contact</h3>
                        <p class="mt-1 text-sm text-zinc-500">Fill in the information below to add a new contact.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="first_name">First Name</x-label>
                            <x-input wire:model="first_name" id="first_name" type="text" placeholder="John" />
                            @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label for="last_name">Last Name</x-label>
                            <x-input wire:model="last_name" id="last_name" type="text" placeholder="Doe" />
                        </div>
                    </div>

                    <div>
                        <x-label for="email">Email</x-label>
                        <x-input wire:model="email" id="email" type="email" placeholder="john@example.com" />
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-label for="company_name">Company</x-label>
                        <x-input wire:model="company_name" id="company_name" type="text" placeholder="Company Name" />
                    </div>

                    <div>
                        <x-label for="job_title">Job Title</x-label>
                        <x-input wire:model="job_title" id="job_title" type="text" placeholder="Software Engineer" />
                    </div>

                    <div>
                        <x-label for="event_name">Event</x-label>
                        <x-input wire:model="event_name" id="event_name" type="text" placeholder="Tech Conference 2024" />
                    </div>

                    <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse gap-2">
                        <x-button type="submit" class="w-full sm:w-auto">Save Contact</x-button>
                        <x-button @click="open = false" type="button" class="w-full sm:w-auto bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-700">Cancel</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden border rounded-lg border-zinc-200 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase text-zinc-500">Name</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase text-zinc-500">Company</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase text-zinc-500">Event</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase text-zinc-500">Date</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right uppercase text-zinc-500">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse($contacts as $contact)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center text-zinc-500 font-bold">
                                    {{ substr($contact->first_name, 0, 1) }}{{ substr($contact->last_name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $contact->first_name }} {{ $contact->last_name }}</div>
                                    <div class="text-sm text-zinc-500">{{ $contact->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $contact->company->name ?? 'N/A' }}</div>
                            <div class="text-sm text-zinc-500">{{ $contact->job_title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                            {{ $contact->event_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                            {{ $contact->date_of_creation ? $contact->date_of_creation->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a href="#" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-zinc-500">
                            You haven't added any contacts yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
