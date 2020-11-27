<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Requests;
use App\Models\Country;
use App\Models\Province;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class ProvincesController extends AdminController
{
    /**
     * Display a listing of province.
     *
     * @return Factory|View
     */
    public function index()
    {
        save_resource_url();

        return $this->view('locations.provinces.index')->with('items', Province::all());
    }

    /**
     * Show the form for creating a new province.
     *
     * @return Factory|View
     */
    public function create()
    {
        $countries = Country::getAllList();

        return $this->view('locations.provinces.create_edit', compact('countries'));
    }

    /**
     * Store a newly created province in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Province::$rules, Province::$messages);

        $this->createEntry(Province::class, $request->all());

        return redirect_to_resource();
    }

    /**
     * Display the specified province.
     *
     * @param Province $province
     * @return Factory|View
     */
    public function show(Province $province)
    {
        return $this->view('locations.provinces.show')->with('item', $province);
    }

    /**
     * Show the form for editing the specified province.
     *
     * @param Province $province
     * @return Factory|View
     */
    public function edit(Province $province)
    {
        $countries = Country::getAllList();

        return $this->view('locations.provinces.create_edit', compact('countries'))
            ->with('item', $province);
    }

    /**
     * Update the specified province in storage.
     *
     * @param Province $province
     * @param Request  $request
     * @return Response
     */
    public function update(Province $province, Request $request)
    {
        $this->validate($request, Province::$rules, Province::$messages);

        $this->updateEntry($province, $request->all());

        return redirect_to_resource();
    }

    /**
     * Remove the specified province from storage.
     *
     * @param Province $province
     * @param Request  $request
     * @return Response
     */
    public function destroy(Province $province, Request $request)
    {
        $this->deleteEntry($province, $request);

        return redirect_to_resource();
    }
}
