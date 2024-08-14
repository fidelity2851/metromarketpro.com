<?php

namespace App\Livewire\Client;

use App\Enums\RoleTitle;
use App\Mail\NewRegistration;
use App\Models\Referral;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Validation\Rules;

class CreateClientModal extends Component
{

    public $fullname;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $referral;


    // Create New User
    public function CreateNewUser()
    {
        // Validate User Input
        $valid = $this->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'referral' => 'nullable|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($valid) {
            // Create New User
            $user = User::create([
                'referral_code' => bin2hex(random_bytes(5)),
                'role_id' => Role::where('title', RoleTitle::USER->value)->value('id'),
                'username' => $this->username,
                'fullname' => $this->fullname,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Update Referral Table
            if ($this->referral != '') {
                $referral = User::firstWhere('referral_code', $this->referral);

                if ($referral) {
                    Referral::create([
                        'referral_id' => $referral->id,
                        'referee_id' => $user->id,
                    ]);
                }
            }

            // Reset Variables
            $this->reset(['fullname', 'username', 'email', 'referral', 'password', 'password_confirmation']);

            // Send New User Email
            Mail::to($user->email)->send(new NewRegistration($user));

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'User Created Successfully.']);

            // Emit To Current Components
            $this->dispatch('NewClientCreated'); 
        }
    }

    public function render()
    {
        return view('livewire.client.create-client-modal');
    }
}
