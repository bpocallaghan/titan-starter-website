<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ResetPasswordController extends AuthController
{
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($token = null)
    {
        return $this->view('passwords.reset')
            ->with('token', $token)
            ->with('email', request('email'));
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token'    => 'required',
            'email'    => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        // response
        $response = Password::broker()->reset($credentials, function ($user, $password) {
            $user->password_updated_at = now();
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));

            Auth::guard()->login($user);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                $this->logLogin($request, 'password-reset');

                return redirect(route('home'));
            default:
                return redirect()
                    ->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }
}