<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends AdminController
{
	public function index()
	{
		return $this->view('dashboard');
	}
}
