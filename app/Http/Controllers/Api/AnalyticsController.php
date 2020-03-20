<?php

namespace App\Http\Controllers\Api;

use Analytics;
use App\User;
use App\Http\Requests;
use Spatie\Analytics\Period;
use App\Http\Controllers\Traits\GoogleAnalyticsHelper;

class AnalyticsController extends ApiController
{
    use GoogleAnalyticsHelper;

    /**
     * Get the sessions grouped by country
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVisitorsLocations()
    {
        $start = input('start', date('Y-m-d', strtotime('-29 days')));
        $end = input('end', date('Y-m-d'));

        if (is_string($start)) {
            $start = \DateTime::createFromFormat('Y-m-d', $start);
        }

        if (is_string($end)) {
            $end = \DateTime::createFromFormat('Y-m-d', $end);
        }

        $period = Period::create($start, $end);

        $data = Analytics::performQuery($period, 'ga:sessions', [
            'dimensions'  => 'ga:country',
            'sort'        => '-ga:sessions',
            'max-results' => 50
        ]);

        $items = [];
        if ($data->rows) {
            $items = $data->rows;
        }

        foreach ($items as $k => $item) {
            $items[$k][1] = intval($items[$k][1]);
        }

        return json_response($items);
    }
}