<?php

namespace App\Http\Controllers\Admin\Settings;

use Redirect;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class RolesController extends AdminController
{
    /**
     * Display a listing of role.
     */
    public function index()
    {
        save_resource_url();

        return $this->view('settings.roles.index')->with('items', Role::all());
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return $this->view('settings.roles.create_edit');
    }

    /**
     * Store a newly created role in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, Role::$rules, Role::$messages);

        $this->createEntry(Role::class, $request->all());

        return redirect_to_resource();
    }

    /**
     * Display the specified role.
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Role $role)
    {
        return $this->view('settings.roles.show')->with('item', $role);
    }

    /**
     * Show the form for editing the specified role.
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return $this->view('settings.roles.create_edit')->with('item', $role);
    }

    /**
     * Update the specified role in storage.
     * @param Role    $role
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Role $role, Request $request)
    {
        $this->validate($request, Role::$rules, Role::$messages);

        $this->updateEntry($role, $request->all());

        return redirect_to_resource();
    }

    /**
     * Remove the specified role from storage.
     * @param Role    $role
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Role $role, Request $request)
    {
        $this->deleteEntry($role, $request);

        return redirect_to_resource();
    }
}
