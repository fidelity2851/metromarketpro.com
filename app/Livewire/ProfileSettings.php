<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class ProfileSettings extends Component
{
    use WithFileUploads;

    public $username;
    public $fullname;
    public $email;
    public $phone;
    public $image;
    public $biography;




    // Get User Profile Details
    public function getUserProfile()
    {
        $auth_user = User::find(auth()->id());

        $this->fill([
            'username' => $auth_user->username,
            'fullname' => $auth_user->fullname,
            'phone' => $auth_user->phone,
            'email' => $auth_user->email,
            'image' => $auth_user->image,
            'biography' => $auth_user->biography,
        ]);
    }

    // Update User Profile Details
    public function updateUserProfile()
    {
        // Validate User Input
        $this->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'biography' => 'nullable|string|max:255',
        ]);

        // Update DB Record
        $user = User::find(auth()->id())->update([
            'username' => $this->username,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'biography' => $this->biography,
        ]);

        // Submit and Upload Image if Avaiable 
        if (is_file($this->image)) {
            // Validate User Image
            $this->validate([
                'image' => 'image|max:1024',
            ]);

            // Delete Old Image if Exist
            Storage::delete('public/profile/' . Auth()->user()->image);

            $image_name = time() . $this->image->getClientOriginalName();
            User::find(auth()->id())->update([
                'image' => $image_name,
            ]);

            // Upload Image to Local Disk
            $this->image->storeAs('public/profile/', $image_name);

        }

        // Reset Variables
        $this->reset(['username', 'fullname', 'phone', 'image', 'biography']);

        // Dispatch Success Message
        $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

        // Reload User Profile Data
        $this->getUserProfile();

    }

    public function mount()
    {
        $this->getUserProfile();
    }

    public function render()
    {
        return view('livewire.profile-settings', [
            'user' => User::find(auth()->id()),
        ]);



    }
}