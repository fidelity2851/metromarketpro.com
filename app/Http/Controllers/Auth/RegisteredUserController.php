<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleTitle;
use App\Http\Controllers\Controller;
use App\Mail\NewRegistration;
use App\Models\Management;
use App\Models\Referral;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use PragmaRX\Google2FAQRCode\Google2FA;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        if (RateLimiter::tooManyAttempts('register-check', 5)) {
            abort(429);
        }

        // Hit the rate limiter for this attempt
        RateLimiter::hit('register-check');

        // Validate User Input
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral' => ['nullable', 'string', 'max:255'],
        ]);

        // Create New User
        $user = User::create([
            'referral_code' => bin2hex(random_bytes(5)),
            'role_id' => Role::where('title', RoleTitle::USER->value)->value('id'),
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Insert into Referral Table
        if ($request->referral != '') {
            $referral = User::firstWhere('referral_code', $request->referral);

            if ($referral) {
                Referral::create([
                    'referral_id' => $referral->id,
                    'referee_id' => $user->id,
                ]);
            }
        }

        // Insert into Management Table
        if ($request->referral != '') {
            $manager = User::withWhereHas('role', function ($query) {
                $query->where('title', RoleTitle::TEAM);
            })->firstWhere('referral_code', $request->referral);

            if ($manager) {
                Management::create([
                    'manager_id' => $referral->id,
                    'client_id' => $user->id,
                ]);
            }
        }

        // New User Registered Event
        event(new Registered($user));

        // Log User In
        Auth::login($user);

        // Redirect
        return redirect(RouteServiceProvider::HOME);
    }
}
