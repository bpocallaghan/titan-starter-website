<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Admin\AdminController;

class AdministratorsController extends AdminController
{
    /**
     * Show all the administrators
     *
     * @return mixed
     */
    public function index()
    {
        save_resource_url();

        $items = User::with('roles')->whereRole(Role::$ADMIN)->get();

        return $this->view('accounts.administrators.index', compact('items'));
    }
}
