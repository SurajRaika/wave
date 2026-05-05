<?php

    use function Laravel\Folio\{middleware, name};
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Filament\Forms\Form;
    use Filament\Schemas\Schema;
    use Filament\Notifications\Notification;
	use Livewire\Volt\Component;
    use Wave\ActivityLog;

	middleware('auth');
    name('settings.email');

	new class extends Component implements HasForms
	{
        use InteractsWithForms;

        public ?array $data = [];

		public function mount(): void
        {
            $this->form->fill(auth()->user()->email_settings ?? []);
        }

       public function form(Schema $schema): Schema
        {
            return $schema
                ->components([
                    \Filament\Forms\Components\Section::make('SMTP Settings')
                        ->description('Configure your outgoing email server.')
                        ->schema([
                            \Filament\Forms\Components\Grid::make(2)
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('smtp_host')
                                        ->label('SMTP Host')
                                        ->placeholder('smtp.example.com'),
                                    \Filament\Forms\Components\TextInput::make('smtp_port')
                                        ->label('SMTP Port')
                                        ->numeric()
                                        ->placeholder('587'),
                                    \Filament\Forms\Components\Select::make('smtp_encryption')
                                        ->label('Encryption')
                                        ->options([
                                            'tls' => 'TLS',
                                            'ssl' => 'SSL',
                                            'none' => 'None',
                                        ]),
                                    \Filament\Forms\Components\TextInput::make('smtp_username')
                                        ->label('Username'),
                                    \Filament\Forms\Components\TextInput::make('smtp_password')
                                        ->label('Password')
                                        ->password()
                                        ->revealable(),
                                    \Filament\Forms\Components\TextInput::make('from_email')
                                        ->label('From Email')
                                        ->email(),
                                    \Filament\Forms\Components\TextInput::make('from_name')
                                        ->label('From Name'),
                                ])
                        ]),

                    \Filament\Forms\Components\Section::make('IMAP Settings')
                        ->description('Configure your incoming email server to sync messages.')
                        ->schema([
                            \Filament\Forms\Components\Grid::make(2)
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('imap_host')
                                        ->label('IMAP Host')
                                        ->placeholder('imap.example.com'),
                                    \Filament\Forms\Components\TextInput::make('imap_port')
                                        ->label('IMAP Port')
                                        ->numeric()
                                        ->placeholder('993'),
                                    \Filament\Forms\Components\TextInput::make('imap_username')
                                        ->label('Username'),
                                    \Filament\Forms\Components\TextInput::make('imap_password')
                                        ->label('Password')
                                        ->password()
                                        ->revealable(),
                                ])
                        ]),

                    \Filament\Forms\Components\Section::make('Google Integration')
                        ->description('Easily connect your Google account to send and receive emails.')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('google_oauth')
                                ->label('')
                                ->content(new \Illuminate\Support\HtmlString('
                                    <div class="flex items-center space-x-4">
                                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.908 3.152-1.928 4.172-1.224 1.224-3.136 2.552-7.144 2.552-6.424 0-11.432-5.208-11.432-11.64s5.008-11.64 11.432-11.64c3.48 0 6.012 1.372 7.872 3.136l2.304-2.304c-2.088-2.004-5.388-3.528-10.176-3.528-8.844 0-16 7.156-16 16s7.156 16 16 16c4.776 0 8.364-1.572 11.136-4.476 2.868-2.868 3.756-6.852 3.756-10.104 0-.972-.084-1.896-.24-2.76h-14.652z"/></svg>
                                            Connect Google Account
                                        </button>
                                        <span class="text-xs text-gray-500">(Google OAuth integration coming soon)</span>
                                    </div>
                                ')),
                        ]),
                ])
                ->statePath('data');
        }

		public function save()
		{
			$state = $this->form->getState();

            $user = auth()->user();
            $user->email_settings = $state;
            $user->save();

            ActivityLog::log('email_settings_updated', 'Email integration settings were updated');

			Notification::make()
                ->title('Email settings saved successfully')
                ->success()
                ->send();
		}
	}
?>

<x-layouts.app>

    <x-app.settings-layout
        title="Email Integration"
        description="Configure your SMTP, IMAP or OAuth settings for email communication.">

		@volt('settings.email')
		<div class="relative w-full">
			<form wire:submit="save" class="w-full">
				<div class="relative flex flex-col mt-5 lg:px-10">
					<div class="w-full">
						{{ $this->form }}
					</div>
					<div class="w-full pt-6 text-right">
						<x-button type="submit">Save Settings</x-button>
					</div>
				</div>
			</form>
		</div>
		@endvolt
    </x-app.settings-layout>

</x-layouts.app>
