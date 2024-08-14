<?php

namespace App\Livewire;

use App\Enums\RoleTitle;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Team extends Component
{

    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    public $select_all_checkbox = false;
    public $team_ids = [];


    #[Computed]
    public function teamCount()
    {
        return User::withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::TEAM);
        })->count();
    }

    #[Computed]
    public function blocked_teamCount()
    {
        return User::withWhereHas('role', function ($query) {
            $query->where('title', RoleTitle::TEAM);
        })->where('status', false)->count();
    }

    public function ApproveTeam($id)
    {
        $team = User::findOrFail($id)->update(['status' => true]);

        if ($team) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'User Approved Successfully.']);
        }
    }

    public function BlockTeam($id)
    {
        $client = User::findOrFail($id)->update(['status' => false]);

        if ($client) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'User Blocked Successfully.']);
        }
    }

    public function DeleteTeam($id)
    {
        $team = User::firstWhere('id', $id);

        // Delete Old Images if Exist
        Storage::delete('public/profile/' . $team->image);

        // Delete Does Records
        $deleted = User::destroy($id);


        if ($deleted) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }
    public function ApproveMultipleTeam()
    {
        $team = User::whereIn('id', $this->team_ids)->update(['status' => true]);

        if ($team) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Users Approved Successfully.']);
        }
    }
    public function BlockMultipleTeam()
    {
        $team = User::whereIn('id', $this->team_ids)->update(['status' => false]);

        if ($team) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Users Blocked Successfully.']);
        }
    }

    #[On('NewTeamCreated')]
    public function render()
    {
        $all_team = User::withWhereHas('role', function ($query) {
            $query->whereNot('title', RoleTitle::ADMIN)->whereNot('title', RoleTitle::USER);
        })->with('clients')->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);

        return view('livewire.team', ['teams' => $all_team]);
    }
}
