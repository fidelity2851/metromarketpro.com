<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class UpdatePassword extends Component
{

    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    // Update Current Password
    public function updateUserPassword()
    {
        $this->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check Password Match
        $auth_user = User::select('password')->findorFail(auth()->id());

        if (Hash::check($this->old_password, $auth_user->password)) {
            User::findorFail(auth()->id())->update([
                'password' => Hash::make($this->new_password),
            ]);

            // Reset Password Variables
            $this->reset(['old_password', 'new_password', 'new_password_confirmation']);

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

        } else {
            // Dispatch Failed Message
            $this->dispatch('showToast', ['status' => false, 'message' => 'Old password is incorrect.']);

        }

    }

    public function render()
    {
        return view('livewire.profile.update-password');
    }
}