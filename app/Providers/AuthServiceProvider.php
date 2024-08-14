<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Enums\RoleTitle;
use App\Models\Management;
use App\Models\SupportTicket;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Defining my Gates ability
        Gate::define('isManager', function ($user, $user_id) {
            if (Gate::allows('adminOnly')) {
                return true;
            } else {
                $client_ids = Management::where('manager_id', $user->id)->get()->map(function ($manager) {
                    return $manager->client_id;
                });

                return $client_ids->contains($user_id,) ? true : false;
            }
        });
        Gate::define('isTicketOwner', function ($user, $ticket_id) {
            if (Gate::allows('adminOnly')) {
                return true;
            } else {
                $client_ids = Management::where('manager_id', $user->id)->get()->map(function ($manager) {
                    return $manager->client_id;
                });
                $ticket = SupportTicket::with('user')->findorFail($ticket_id);

                return $client_ids->contains($ticket->user->id) || auth()->id() == $ticket->user->id ? true : false;
            }
        });
        Gate::define('adminOnly', function ($user) {
            return ($user->role->title === RoleTitle::ADMIN->value) ? true : false;
        });
        Gate::define('teamOnly', function ($user) {
            return ($user->role->title === RoleTitle::TEAM->value) ? true : false;
        });
        Gate::define('userOnly', function ($user) {
            return ($user->role->title === RoleTitle::USER->value) ? true : false;
        });
    }
}
