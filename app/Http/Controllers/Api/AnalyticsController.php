<?php

namespace App\Http\Controllers\Api;

use Analytics;
use App\Models\User;
use App\Http\Requests;
use Spatie\Analytics\Period;
use Spatie\Analytics\OrderBy;
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

        $data = Analytics::get($period, ['sessions'], ['country'], 50, [OrderBy::metric('sessions', true)]);

        $items = [];
        if ($data) {
            foreach ($data as $k => $item) {
                $items[$k] = [];
                $items[$k][0] = $item['country'];
                $items[$k][1] = intval($item['sessions']);
            }
        }

        return json_response($items);
    }
}
