<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Layout;
use App\Models\Template;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class LayoutsController extends AdminController
{
	/**
	 * Display a listing of template.
	 *
	 * @return Factory|View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('settings.layouts.index')->with('items', Layout::all());
	}

	/**
	 * Show the form for creating a new template.
	 *
	 * @return Factory|View
	 */
	public function create()
	{
        $templates = Template::getAllList();
		return $this->view('settings.layouts.create_edit')->with('templates', $templates);
	}

	/**
	 * Store a newly created template in storage.
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function store()
	{
		$attributes = request()->validate(Layout::$rules, Layout::$messages);

        $layout = $this->createEntry(Layout::class, $attributes);

        $layout->templates()->sync(input('templates'));

        return redirect_to_resource();
	}

	/**
	 * Display the specified template.
	 *
	 * @param Layout $layout
	 * @return Factory|View
	 */
	public function show(Layout $layout)
	{
		return $this->view('settings.layouts.show')->with('item', $layout);
	}

	/**
	 * Show the form for editing the specified template.
	 *
	 * @param Layout $layout
     * @return Factory|View
     */
    public function edit(Layout $layout)
	{
        $templates = Template::getAllList();
		return $this->view('settings.layouts.create_edit')->with('templates', $templates)->with('item', $layout);
	}

	/**
	 * Update the specified template in storage.
	 *
	 * @param Layout  $layout
     * @return RedirectResponse|Redirector
     */
    public function update(Layout $layout)
	{
		$attributes = request()->validate(Layout::$rules, Layout::$messages);

        $layout = $this->updateEntry($layout, $attributes);

        $layout->templates()->sync(input('templates'));

        return redirect_to_resource();
	}

	/**
	 * Remove the specified template from storage.
	 *
	 * @param Layout  $layout
	 * @return RedirectResponse|Redirector
	 */
	public function destroy(Layout $layout)
	{
		$this->deleteEntry($layout, request());

        return redirect_to_resource();
	}
}
