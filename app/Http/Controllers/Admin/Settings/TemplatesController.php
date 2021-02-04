<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Template;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class TemplatesController extends AdminController
{
	/**
	 * Display a listing of template.
	 *
	 * @return Factory|View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('settings.templates.index')->with('items', Template::all());
	}

	/**
	 * Show the form for creating a new template.
	 *
	 * @return Factory|View
	 */
	public function create()
	{
		return $this->view('settings.templates.create_edit');
	}

	/**
	 * Store a newly created template in storage.
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function store()
	{
		$attributes = request()->validate(Template::$rules, Template::$messages);

        $template = $this->createEntry(Template::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified template.
	 *
	 * @param Template $template
	 * @return Factory|View
	 */
	public function show(Template $template)
	{
		return $this->view('settings.templates.show')->with('item', $template);
	}

	/**
	 * Show the form for editing the specified template.
	 *
	 * @param Template $template
     * @return Factory|View
     */
    public function edit(Template $template)
	{
		return $this->view('settings.templates.create_edit')->with('item', $template);
	}

	/**
	 * Update the specified template in storage.
	 *
	 * @param Template  $template
     * @return RedirectResponse|Redirector
     */
    public function update(Template $template)
	{
		$attributes = request()->validate(Template::$rules, Template::$messages);

        $template = $this->updateEntry($template, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified template from storage.
	 *
	 * @param Template  $template
	 * @return RedirectResponse|Redirector
	 */
	public function destroy(Template $template)
	{
		$this->deleteEntry($template, request());

        return redirect_to_resource();
	}
}
