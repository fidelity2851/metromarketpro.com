<?php

namespace App\Livewire;

use App\Enums\RoleTitle;
use App\Models\Management;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;

    public $search;
    public $sort_by;
    public $order_by = 'desc';
    public $per_page = 30;

    public $select_all_checkbox = false;
    public $client_ids = [];


    #[Computed]
    public function clientCount()
    {
        if (Gate::allows('adminOnly')) {
            return User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::USER);
            })->count();
        } else {
            $client_ids = Management::where('manager_id', auth()->id())->get()->map(function ($manager) {
                return $manager->client_id;
            });

            return User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::USER);
            })->whereIn('id', $client_ids)->count();
        }
    }

    #[Computed]
    public function blocked_clientCount()
    {
        if (Gate::allows('adminOnly')) {
            return User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::USER);
            })->where('status', false)->count();
        } else {
            $client_ids = Management::where('manager_id', auth()->id())->get()->map(function ($manager) {
                return $manager->client_id;
            });

            return User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::USER);
            })->whereIn('id', $client_ids)->where('status', false)->count();
        }
    }

    public function ApproveClient($id)
    {
        $client = User::findOrFail($id)->update(['status' => true]);

        if ($client) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'User Approved Successfully.']);
        }
    }

    public function BlockClient($id)
    {
        $client = User::findOrFail($id)->update(['status' => false]);

        if ($client) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'User Blocked Successfully.']);
        }
    }

    public function DeleteClient($id)
    {
        $client = User::firstWhere('id', $id);

        // Delete Old Images if Exist
        Storage::delete('public/profile/' . $client->image);

        // Delete Does Records
        $deleted = User::destroy($id);


        if ($deleted) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Deleted Successfully.']);
        }
    }
    public function ApproveMultipleClient()
    {
        $client = User::whereIn('id', $this->client_ids)->update(['status' => true]);

        if ($client) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Users Approved Successfully.']);
        }
    }
    public function BlockMultipleClient()
    {
        $client = User::whereIn('id', $this->client_ids)->update(['status' => false]);

        if ($client) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Users Blocked Successfully.']);
        }
    }

    #[On('NewClientCreated')]
    public function render()
    {
        if (Gate::allows('adminOnly')) {
            $all_client = User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::USER);
            })->with('manager.team')->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        } else {
            $client_ids = Management::where('manager_id', auth()->id())->get()->map(function ($manager) {
                return $manager->client_id;
            });

            $all_client = User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::USER);
            })->with('manager.team')->whereIn('id', $client_ids)->Search($this->search)->SortBY($this->sort_by)->orderBy('created_at', $this->order_by)->paginate($this->per_page);
        }


        return view('livewire.clients', ['clients' => $all_client]);
    }
}
