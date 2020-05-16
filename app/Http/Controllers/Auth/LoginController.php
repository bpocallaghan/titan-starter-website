<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends AuthController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    private function username(): string
    {
        return 'email';
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  Request $request
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = input('remember', false);

        if (Auth::attempt($credentials, $remember)) {

            // Authentication passed...
            return $this->sendLoginResponse($request);
        }

        $this->logLogin($request, 'invalid');

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    private function sendLoginResponse(Request $request)
    {
        $user = user();

        // notify message
        if ($user->getAttribute('logged_in_at')) {
            notify()->info('Info',
                'Last time you logged in was ' . $user->logged_in_at->diffForHumans(),
                'far fa-clock spin animated rotateIn animated', 8000);
        }
        else {
            notify()->info('Welcome',
                'Hi ' . $user->fullname . '. Welcome to ' . config('app.name'),
                'far fa-bell shake animated', 8000);
        }

        // log
        $this->logLogin($request, 'success');

        // update logged_in_at
        $user->update(['logged_in_at' => Carbon::now()]);
        log_activity('Login', $user->fullname . ' logged in.');

        $url = '/';

        // if ajax (can be from a login modal)
        if (request()->ajax()) {
            return json_response(['redirect' => config('app.url') . $url]);
        }

        return redirect()->intended();
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @param string  $message
     * @return JsonResponse|RedirectResponse
     */
    private function sendFailedLoginResponse(Request $request, $message = '')
    {
        $errors = [$this->username() => strlen($message) > 2 ? $message : trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()
            ->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
