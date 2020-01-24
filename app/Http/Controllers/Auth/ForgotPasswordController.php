<?php

namespace App\Http\Controllers\Auth;

use Password;
use Illuminate\Http\Request;

class ForgotPasswordController extends AuthController
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return $this->view('passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = Password::broker()->sendResetLink($request->only('email'));

        switch ($response) {
            case Password::RESET_LINK_SENT:
                alert()->success('Success!',
                    'Please check your inbox for the email with instructions');

                $this->logLogin($request, 'password-forgot');

                return redirect(route('login'));

            default:
                return redirect()
                    ->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }
}