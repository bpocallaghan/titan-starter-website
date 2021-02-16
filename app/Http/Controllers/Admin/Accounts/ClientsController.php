<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Admin\AdminController;

class ClientsController extends AdminController
{
    /**
     * Display a listing of client.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        save_resource_url();

        $items = User::all();

        return $this->view('accounts.clients.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::getAllLists();

        return $this->view('accounts.clients.create_edit')->with('roles', $roles);
    }

    /**
     * Store a newly created client in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = request()->validate(User::$rulesClient, User::$messages);

        $roles = $attributes['roles'];
        unset($attributes['roles']);
        $attributes['password'] = bcrypt($attributes['password']);

        $client = $this->createEntry(User::class, $attributes);

        $client->roles()->attach($roles);

        event(new Registered($client));

        return redirect_to_resource();
    }

    /**
     * Display the specified client.
     *
     * @param User $client
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $client)
    {
        return $this->view('accounts.clients.show')->with('item', $client);
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param User $client
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $client)
    {
        $roles = Role::getAllLists();

        return $this->view('accounts.clients.create_edit')
            ->with('roles', $roles)
            ->with('item', $client);
    }

    /**
     * Update the specified client in storage.
     *
     * @param User $client
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $client)
    {
        $rules = User::$rulesClient;
        $rules['email'] = [
            'required',
            'string',
            'email',
            'max:191',
            Rule::unique('users')->ignore($client->id)
        ];
        $rules['password'] = ['nullable', 'string', 'min:4', 'confirmed'];

        $attributes = request()->validate($rules, User::$messages);

        $roles = $attributes['roles'];
        unset($attributes['roles']);
        if (strlen($attributes['password']) < 4) {
            unset($attributes['password']);
        }
        else {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        $client = $this->updateEntry($client, $attributes);

        $client->roles()->sync($roles);

        return redirect_to_resource();
    }

    /**
     * Remove the specified client from storage.
     *
     * @param User $client
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $client)
    {
        $this->deleteEntry($client, request());

        return redirect_to_resource();
    }
}
