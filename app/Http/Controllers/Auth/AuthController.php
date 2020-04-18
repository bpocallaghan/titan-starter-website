<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Models\LogLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $baseViewPath = 'auth.';

    /**
     * @param Request $request
     * @param string  $status
     */
    protected function logLogin(Request $request, $status = '')
    {
        LogLogin::create([
            'username'     => $request->get('email'),
            'status'       => $status,
            'role'         => 'website',
            'client_ip'    => $request->getClientIp(),
            'client_agent' => $request->userAgent(),
        ]);
    }
}
