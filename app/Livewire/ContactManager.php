<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Company;

class ContactManager extends Component
{
    public $contacts = [];
    public $showModal = false;

    // Contact fields
    public $first_name, $last_name, $email, $phone, $job_title, $company_name, $event_name, $notes;

    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'nullable',
        'email' => 'nullable|email',
        'phone' => 'nullable',
        'job_title' => 'nullable',
        'company_name' => 'nullable',
        'event_name' => 'nullable',
        'notes' => 'nullable',
    ];

    public function mount()
    {
        $this->loadContacts();
    }

    public function loadContacts()
    {
        $this->contacts = auth()
            ->user()
            ->contacts()
            ->with('company')
            ->latest()
            ->get();
    }

    public function addContact()
    {
        $this->validate();

        $company_id = null;
        if ($this->company_name) {
            $company = Company::firstOrCreate(['name' => $this->company_name]);
            $company_id = $company->id;
        }

        Contact::create([
            'user_id' => auth()->id(),
            'company_id' => $company_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'job_title' => $this->job_title,
            'event_name' => $this->event_name,
            'date_of_creation' => now(),
            'notes' => $this->notes,
        ]);

        $this->reset(['first_name', 'last_name', 'email', 'phone', 'job_title', 'company_name', 'event_name', 'notes', 'showModal']);
        $this->loadContacts();
        
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.contact-manager');
    }
}
