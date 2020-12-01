<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Models\Continent;
use Redirect;
use App\Http\Requests;
use App\Models\Country;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class ContinentsController extends AdminController
{
	/**
	 * Display a listing of country.
	 *
	 * @return Factory|View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('locations.continents.index')->with('items', Continent::all());
	}

	/**
	 * Show the form for creating a new country.
	 *
	 * @return Factory|View
	 */
	public function create()
	{
		return $this->view('locations.continents.create_edit');
	}

	/**
	 * Store a newly created country in storage.
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function store()
	{
        $attributes = request()->validate(Continent::$rules, Continent::$messages);

        $continent = $this->createEntry(Continent::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified country.
	 *
	 * @param Continent $continent
	 * @return Factory|View
	 */
	public function show(Continent $continent)
	{
		return $this->view('locations.continents.show')->with('item', $continent);
	}

	/**
	 * Show the form for editing the specified country.
	 *
	 * @param Continent $continent
     * @return Factory|View
     */
    public function edit(Continent $continent)
	{
		return $this->view('locations.continents.create_edit')->with('item', $continent);
	}

	/**
	 * Update the specified country in storage.
	 *
	 * @param Continent  $continent

     * @return RedirectResponse|Redirector
     */
    public function update(Continent $continent)
	{
        $attributes = request()->validate(Continent::$rules, Continent::$messages);

        $continent = $this->updateEntry($continent, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified country from storage.
	 *
	 * @param Continent  $continent
	 * @return RedirectResponse|Redirector
	 */
	public function destroy(Continent $continent)
	{
		$this->deleteEntry($continent, request());

        return redirect_to_resource();
	}
}
