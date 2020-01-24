<?php

namespace App;

use App\Models\Traits\UserHelper;
use App\Models\Traits\UserRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, UserHelper, UserRoles;

    protected $appends = ['fullname'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'gender',
        'cellphone',
        'image',
        'born_at',
        'logged_in_as',
        'security_level',
        'password',
        'session_token',
        'logged_in_at',
        'disabled_at',
    ];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'firstname' => ['required', 'string', 'max:190'],
        'lastname'  => ['required', 'string', 'max:190'],
        //'gender'    => 'required|in:male,female',
        'cellphone' => ['nullable', 'string', 'max:190'],
        'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'  => ['required', 'string', 'min:4', 'confirmed'],
        //'token'     => 'required|exists:user_invites,token',
        //'photo'     => 'required|image|max:6000|mimes:jpg,jpeg,png,bmp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_by',
        'deleted_at',
        'logged_in_at',
        'disabled_at'
    ];

    protected $dates = ['confirmed_at', 'deleted_at', 'logged_in_at', 'activated_at'];

    /**
     * Validation rules for this model
     */
    static public $rulesProfile = [
        'firstname' => 'required',
        'lastname'  => 'required',
        'gender'    => 'required|in:male,female',
        'telephone' => 'nullable|min:9',
        'password'  => 'nullable|min:4|confirmed',
        'photo'     => 'required|image|max:6000|mimes:jpg,jpeg,png,bmp',
    ];
}
