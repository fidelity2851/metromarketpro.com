<?php

namespace App\Livewire\Client;

use App\Enums\RoleTitle;
use App\Models\Management;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class EditClient extends Component
{
    public $user;
    public $roles;
    public $managers;

    public $username;
    public $fullname;
    public $email;
    public $phone;
    public $role;
    public $manager;
    public $biography;
    public $status;
    public $two_fa_secret;


    public function GetClient($user)
    {
        $this->user = User::findOrFail($user);
        $managemant = Management::select('manager_id')->where('client_id', $this->user->id)->where('status', true)->First();

        $this->username = $this->user->username;
        $this->fullname = $this->user->fullname;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->role = $this->user->role_id;
        $this->manager = $managemant?->manager_id;
        $this->biography = $this->user->biography;
        $this->status = $this->user->status ? false : true;
        $this->two_fa_secret = $this->user->google2fa_secret;
    }

    public function GetAllRole()
    {
        $this->roles = Role::where('status', true)->get();
    }

    public function GetAllManagers()
    {
        $this->managers = User::withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::ADMIN)->orWhere('title', RoleTitle::TEAM);
        })->where('status', true)->get();
    }

    public function UpdateClient()
    {

        $valid =  $this->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:255',
            'role' => 'required|numeric|max:255',
            'manager' => 'nullable|numeric|max:255',
            'biography' => 'nullable|string|max:255',
            'status' => 'required|boolean|max:255',
        ]);

        if ($valid) {
            User::where('id', $this->user->id)->update([
                'username' => $this->username,
                'fullname' => $this->fullname,
                'email' => $this->email,
                'phone' => $this->phone,
                'role_id' => $this->role,
                'biography' => $this->biography,
                'status' => $this->status ? false : true,
            ]);

            if ($this->manager != '') {
                Management::updateOrCreate(
                    ['client_id' => $this->user->id, 'status' => true],
                    ['manager_id' => $this->manager,]
                );
            }

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'User Updated Successfully.']);

            // Reload Client Data
            $this->GetClient($this->user->id);
        }
    }

    public function mount($user)
    {
        $this->GetClient($user);
        $this->GetAllRole();
        $this->GetAllManagers();
    }

    public function render()
    {
        return view('livewire.client.edit-client');
    }
}
