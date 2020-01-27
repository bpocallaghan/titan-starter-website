<?php

namespace App\Http\Controllers\Admin\LatestActivities;

use Illuminate\Http\Request;
use Bpocallaghan\LogActivity\Models\LogActivity;
use App\Http\Controllers\Admin\AdminController;
use Bpocallaghan\LogActivity\Models\LogModelActivity;

class LatestActivitiesController extends AdminController
{
    public function website()
    {
        $items = LogActivity::getLatest();

        return $this->view('latest_activities.website')->with('items', $items);
    }

    public function admin()
    {
        $items = LogModelActivity::getLatest();

        return $this->view('latest_activities.admin')->with('items', $items);
    }
}
