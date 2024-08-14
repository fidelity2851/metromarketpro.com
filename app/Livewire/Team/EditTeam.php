<?php

namespace App\Livewire\Team;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class EditTeam extends Component
{

    public $team;
    public $roles;

    public $username;
    public $fullname;
    public $email;
    public $phone;
    public $role;
    public $biography;
    public $status;


    public function GetTeam($team)
    {
        $this->team = User::findOrFail($team);

        $this->username = $this->team->username;
        $this->fullname = $this->team->fullname;
        $this->email = $this->team->email;
        $this->phone = $this->team->phone;
        $this->role = $this->team->role_id;
        $this->biography = $this->team->biography;
        $this->status = $this->team->status ? false : true;
    }
    public function GetAllRole()
    {
        $this->roles = Role::where('status', true)->get();
    }

    public function UpdateTeam()
    {

        $valid =  $this->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->team->id,
            'phone' => 'nullable|string|max:255',
            'role' => 'required|integer|max:255',
            'biography' => 'nullable|string|max:255',
            'status' => 'required|boolean|max:255',
        ]);

        if ($valid) {
            User::where('id', $this->team->id)->update([
                'username' => $this->username,
                'fullname' => $this->fullname,
                'email' => $this->email,
                'phone' => $this->phone,
                'role_id' => $this->role,
                'biography' => $this->biography,
                'status' => $this->status ? false : true,
            ]);

            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Team Updated Successfully.']);

            // Reload Client Data
            $this->GetTeam($this->team->id);
        }
    }

    public function mount($team)
    {
        $this->GetTeam($team);
        $this->GetAllRole();
    }

    public function render()
    {
        return view('livewire.team.edit-team');
    }
}
