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

class CountriesController extends AdminController
{
	/**
	 * Display a listing of country.
	 *
	 * @return Factory|View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('locations.countries.index')->with('items', Country::all());
	}

	/**
	 * Show the form for creating a new country.
	 *
	 * @return Factory|View
	 */
	public function create()
	{
	    $continents = Continent::getAllList();
		return $this->view('locations.countries.create_edit')->with('continents', $continents);
	}

	/**
	 * Store a newly created country in storage.
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function store()
	{
        $attributes = request()->validate( Country::$rules, Country::$messages);

        $country = $this->createEntry(Country::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified country.
	 *
	 * @param Country $country
	 * @return Factory|View
	 */
	public function show(Country $country)
	{
		return $this->view('locations.countries.show')->with('item', $country);
	}

	/**
	 * Show the form for editing the specified country.
	 *
	 * @param Country $country
     * @return Factory|View
     */
    public function edit(Country $country)
	{
        $continents = Continent::getAllList();
		return $this->view('locations.countries.create_edit')->with('continents', $continents)->with('item', $country);
	}

	/**
	 * Update the specified country in storage.
	 *
	 * @param Country  $country
     * @return RedirectResponse|Redirector
     */
    public function update(Country $country)
	{
        $attributes = request()->validate( Country::$rules, Country::$messages);

        $country = $this->updateEntry($country, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified country from storage.
	 *
	 * @param Country  $country
	 * @return RedirectResponse|Redirector
	 */
	public function destroy(Country $country)
	{
		$this->deleteEntry($country, request());

        return redirect_to_resource();
	}
}
