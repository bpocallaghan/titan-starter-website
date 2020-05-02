<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\FeedbackContactUs;


class SummaryController extends AdminController
{
    public function index()
    {
        $items = $this->getData();

        return $this->view('reports.summary', compact('items'));
    }

    private function getData()
    {

        $result = [];

        $result[] = ['', ''];
        $result[] = ['<strong>Feedback Forms</strong>', ''];
        $result[] = ['Contact Us', FeedbackContactUs::count()];


        $result[] = ['', ''];
        $total = FeedbackContactUs::count();
        $result[] = ['Total', $total];

        return $result;
    }
}