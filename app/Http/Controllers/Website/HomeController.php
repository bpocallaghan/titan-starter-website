<?php

namespace App\Http\Controllers\Website;

class HomeController extends WebsiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index()
	{
		return $this->view('home');
	}
}
