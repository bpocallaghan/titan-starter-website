<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Settings;
use App\Http\Controllers\Admin\AdminController;

class SettingsController extends AdminController
{
	/**
	 * Display a listing of setting.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('settings.settings.index')->with('items', Settings::all());
	}

	/**
	 * Show the form for creating a new setting.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		return $this->view('settings.settings.create_edit');
	}

	/**
	 * Store a newly created setting in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store()
	{
		$attributes = request()->validate(Settings::$rules, Settings::$messages);

        $setting = $this->createEntry(Settings::class, $attributes);

        log_activity('Settings Created', 'A Settings was successfully created', $setting);

        return redirect_to_resource();
	}

	/**
	 * Display the specified setting.
	 *
	 * @param Settings $setting
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Settings $setting)
	{
		return $this->view('settings.settings.show')->with('item', $setting);
	}

	/**
	 * Show the form for editing the specified setting.
	 *
	 * @param Settings $setting
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Settings $setting)
	{
		return $this->view('settings.settings.create_edit')->with('item', $setting);
	}

	/**
	 * Update the specified setting in storage.
	 *
	 * @param Settings  $setting
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Settings $setting)
	{
		$attributes = request()->validate(Settings::$rules, Settings::$messages);

        $setting = $this->updateEntry($setting, $attributes);

        settings(true); // save new settings in session

        log_activity('Settings Updated', 'A Settings was successfully updated', $setting);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified setting from storage.
	 *
	 * @param Settings  $setting
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(Settings $setting)
	{
		$this->deleteEntry($setting, request());

        return redirect_to_resource();
	}
}
