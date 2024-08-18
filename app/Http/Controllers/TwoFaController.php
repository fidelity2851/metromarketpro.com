<?php

namespace App\Http\Controllers;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFaController extends Controller
{
    public function index()
    {

        $user = User::findOrFail(auth()->id());
        $google2fa = new Google2FA();
        $secret = $user->two_fa_secret ?? $google2fa->generateSecretKey();

        $qr_code = $google2fa->getQRCodeInline(
            env('APP_NAME', 'vesttradesolutions'),
            auth()->user()->email,
            $secret
        );


        return view('2fa', compact('user', 'secret', 'qr_code'));
    }
    public function enable2fa()
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        User::findOrFail(auth()->id())->update([
            'two_fa_secret' => $secret,
            // 'google2fa_secret' => $secret,
        ]);

        return back();
    }
    public function disable2fa()
    {
        User::findOrFail(auth()->id())->update([
            'google2fa_secret' => null,
        ]);

        return back()->with('disabled', '2FA Disabled Successfully');
    }
    public function delete2fa()
    {
        User::findOrFail(auth()->id())->update([
            'two_fa_secret' => null,
            'google2fa_secret' => null,
        ]);

        return back()->with('disabled', '2FA Disabled Successfully');
    }
    public function verify2fa(Request $request)
    {
        $google2fa = new Google2FA();

        // Validate OTP Input
        $request->validate([
            'one_time_password' => ['required', 'string', 'max:255'],
        ]);

        $valid = $google2fa->verifyKey(auth()->user()->google2fa_secret, $request->one_time_password);

        $authenticator = app(Authenticator::class);

        if ($authenticator->isAuthenticated()) {
            //
        }

        return redirect()->route('dashboard')->with('error', 'Code is invalid');
    }

    public function activate2fa(Request $request)
    {
        $google2fa = new Google2FA();

        $request->validate([
            'one_time_password' => ['required', 'string', 'max:255'],
            'secret' => ['required', 'string', 'max:255'],
        ]);

        $valid = $google2fa->verifyKey($request->secret, $request->one_time_password);


        if ($valid) {

            $user = User::findOrFail(auth()->id());

            $user->google2fa_secret = $request->secret;
            $user->save();

            Auth::setUser($user);
            $authenticator = app(Authenticator::class);

            if ($authenticator->isAuthenticated()) {
                //
            }

            // dd($user->google2fa_secret);


            return back()->with('enabled', '2FA Enabled Successfully');
        } else {
            return back()->with('error', 'Code is invalid');
        }
    }
}
