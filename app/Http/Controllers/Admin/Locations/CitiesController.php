<?php

namespace App\Http\Controllers\Admin\Locations;

use Redirect;
use App\Models\City;
use App\Http\Requests;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class CitiesController extends AdminController
{
    /**
     * Display a listing of city.
     *
     * @return Factory|View
     */
    public function index()
    {
        save_resource_url();

        return $this->view('locations.cities.index')->with('items', City::all());
    }

    /**
     * Show the form for creating a new city.
     *
     * @return Factory|View
     */
    public function create()
    {
        $provinces = Province::getAllLists();

        return $this->view('locations.cities.create_edit', compact('provinces'));
    }

    /**
     * Store a newly created city in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store()
    {
        $attributes = request()->validate(City::$rules, City::$messages);

        $city = $this->createEntry(City::class, $attributes);

        return redirect_to_resource();
    }

    /**
     * Display the specified city.
     *
     * @param City $city
     * @return Factory|View
     */
    public function show(City $city)
    {
        return $this->view('locations.cities.show')->with('item', $city);
    }

    /**
     * Show the form for editing the specified city.
     *
     * @param City $city
     * @return Factory|View
     */
    public function edit(City $city)
    {
        $provinces = Province::getAllLists();

        return $this->view('locations.cities.create_edit', compact('provinces'))->with('item', $city);
    }

    /**
     * Update the specified city in storage.
     *
     * @param City    $city
     * @return RedirectResponse|Redirector
     */
    public function update(City $city)
    {

        $attributes = request()->validate(City::$rules, City::$messages);

        $city = $this->updateEntry($city, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified city from storage.
     *
     * @param City    $city
     * @return RedirectResponse|Redirector
     */
    public function destroy(City $city)
    {
        $this->deleteEntry($city, request());

        return redirect_to_resource();
    }
}
