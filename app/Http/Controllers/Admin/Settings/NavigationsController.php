<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Role;
use App\Models\Navigation;
use App\Http\Controllers\Admin\AdminController;

class NavigationsController extends AdminController
{
    /**
     * Display a listing of navigation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        save_resource_url();

        return $this->view('settings.navigations.index')->with('items', Navigation::all());
    }

    /**
     * Show the form for creating a new navigation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::getAllLists();
        $parents = Navigation::getAllLists();

        return $this->view('settings.navigations.create_edit')
            ->with('roles', $roles)
            ->with('parents', $parents);
    }

    /**
     * Store a newly created navigation in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = request()->validate(Navigation::$rules, Navigation::$messages);

        $inputs = request()->only([
            'icon',
            'name',
            'slug',
            'description',
            'help_index_title',
            'help_index_content',
            'help_create_title',
            'help_create_content',
            'help_edit_title',
            'help_edit_content',
            'parent_id',
            'url_parent_id'
        ]);
        $inputs['is_hidden'] = (bool) request()->has('is_hidden');
        $inputs['url_parent_id'] = ($inputs['url_parent_id'] == 0 ? $inputs['parent_id'] : $inputs['url_parent_id']);

        $row = $this->createEntry(Navigation::class, $inputs);

        if ($row) {
            $row->updateUrl()->save();
            $row->roles()->attach(input('roles'));
        }

        return redirect_to_resource();
    }

    /**
     * Display the specified navigation.
     *
     * @param Navigation $navigation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Navigation $navigation)
    {
        return $this->view('settings.navigations.show')->with('item', $navigation);
    }

    /**
     * Show the form for editing the specified navigation.
     *
     * @param Navigation $navigation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Navigation $navigation)
    {
        $roles = Role::getAllLists();
        $parents = Navigation::getAllLists();

        return $this->view('settings.navigations.create_edit')
            ->with('item', $navigation)
            ->with('roles', $roles)
            ->with('parents', $parents);
    }

    /**
     * Update the specified navigation in storage.
     *
     * @param Navigation $navigation
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Navigation $navigation)
    {
        $attributes = request()->validate(Navigation::$rules, Navigation::$messages);

        $inputs = request()->only([
            'icon',
            'name',
            'slug',
            'description',
            'help_index_title',
            'help_index_content',
            'help_create_title',
            'help_create_content',
            'help_edit_title',
            'help_edit_content',
            'parent_id',
            'url_parent_id'
        ]);
        $inputs['is_hidden'] = (bool) request()->has('is_hidden');

        $navigation = $this->updateEntry($navigation, $inputs);
        $navigation->updateUrl()->save();
        $navigation->roles()->sync(input('roles'));

        return redirect_to_resource();
    }

    /**
     * Remove the specified navigation from storage.
     *
     * @param Navigation $navigation
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Navigation $navigation)
    {
        $this->deleteEntry($navigation, request());

        return redirect_to_resource();
    }
}
