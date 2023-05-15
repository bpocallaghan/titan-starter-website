<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;

class AnalyticsController extends AdminController
{
    public function summary()
    {
        return $this->view('analytics.summary');
    }

    public function devices()
    {
        return $this->view('analytics.devices');
    }

    public function visitsReferrals()
    {
        return $this->view('analytics.visits_referrals');
    }

    public function engagement()
    {
        return $this->view('analytics.engagement');
    }

    public function demographics()
    {
        return $this->view('analytics.demographics');
    }
}