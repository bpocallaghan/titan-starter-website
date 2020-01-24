<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends AuthController
{
    /**
     * Show the application registration form.
     *
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm($token = null)
    {
        return $this->view('register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function register()
    {
        $attributes = request()->validate(User::$rules);

        // create new user
        $user = User::create([
            'firstname'          => $attributes['firstname'],
            'lastname'           => $attributes['lastname'],
            'cellphone'          => $attributes['cellphone'],
            'email'              => $attributes['email'],
            'password'           => Hash::make($attributes['password']),
            'confirmation_token' => 'confirmation_token', // will generate a new unique token
        ]);

        event(new Registered($user));

        Auth::guard()->login($user);

        $this->logLogin(request(), 'registered');

        log_activity('User Registered', $user->fullname . ' registered as a new user.', $user);

        return redirect()->intended('/');
    }

    /**
     * User click on register confirmation link in mail
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmAccount($token)
    {
        $user = User::where('confirmation_token', $token)->first();
        if ($user) {
            if ($user->confirmed_at && strlen($user->confirmed_at) > 6) {
                alert()->info('Account is Active',
                    'Your account is already active, please try to sign in.');
            }
            else {
                // confirm / activate user
                $user->confirmation_token = null;
                $user->confirmed_at = Carbon::now();
                $user->update();

                // notify
                $user->notify(new UserConfirmedAccount());

                alert()->success('Success',
                    '<br/>Congratulations, your account has been activated. Please Sign In below.');

                log_activity('User Confirmed', $user->fullname . ' confirmed their account', $user);
            }
        }
        else {
            alert()->error('Whoops!', 'Sorry, the token does not exist.');

            log_activity('User Confirmed', 'INVALID TOKEN');
        }

        return redirect(route('login'));
    }
}
