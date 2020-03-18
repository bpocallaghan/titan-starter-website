<?php

namespace App\Http\Controllers\Api;

use Analytics;
use App\User;
use App\Http\Requests;
use App\Models\Activity;
use App\Models\Business;
use App\Models\Credit;
use Spatie\Analytics\Period;
use App\Http\Controllers\Admin\Traits\GoogleAnalyticsHelper;

class AnalyticsController extends ApiController
{
    use GoogleAnalyticsHelper;

    public function getWebsiteStats()
    {
        $businessesGrouped = Business::with('user')
            ->with('subscription')
            ->whereHas('user', function ($query) {
                return $query->whereNull('disabled_at');
            })
            ->get()
            ->groupBy('subscription_statusss');

        // get the total per subscription
        $businessByStatus = (object) [
            'forever_free'  => 0,
            'active'        => 0,
            'inactive_free' => 0,
            'active_free'   => 0,
            'free'          => 0,
            'expired_trial' => 0,
            'active_trial'  => 0,
            'expired'       => 0,
        ];
        // group by subscription
        foreach ($businessByStatus as $k => $item) {
            if (isset($businessesGrouped[$k])) {
                $businessByStatus->{$k} = $businessesGrouped[$k]->count();
            }
        }

        //$businesses = (isset($businessesGrouped['active']) ? $businessesGrouped['active']->count() : "0");
        //$businesses .= (isset($businessesGrouped['expired']) ? " / <span class='text-red'>" . $businessesGrouped['expired']->count()  . "</span>": " / 0");
        //$businesses .= (isset($businessesGrouped['active_trial']) ? " | <span class='text-orange'>" . $businessesGrouped['active_trial']->count() . "</span>" : " | 0");
        //$businesses .= (isset($businessesGrouped['expired_trial']) ? " / <span class='text-red'>" . $businessesGrouped['expired_trial']->count()  . "</span>": " / 0");

        $users = User::whereNull('disabled_at')->get();
        $usersActivated = $users->filter(function ($item) {
            return !is_null($item->registered_at);
        })->count();

        $usersPerc = round(($usersActivated / $users->count() * 100), 2);

        $activities = Activity::dateDuration('now-7days')->isOpen()->isActive()->get();
        $totalActivities = $activities->count();
        if ($totalActivities > 0) {
            $attendingFuture = round($activities->sum('current_attending') / $activities->sum('max_attending') * 100,
                2);
        }
        else {
            $attendingFuture = 0;
        }

        $activities = Activity::dateDuration('previous-7days')->isOpen()->get();
        if (count($activities) > 0) {
            $attendingPast = round($activities->sum('current_attending') / $activities->sum('max_attending') * 100,
                2);
        }
        else {
            $attendingPast = 0;
        }

        return json_response((object) [
            'businesses'     => $businessByStatus,
            'users'          => $users->count(),
            'usersActivated' => $usersActivated,
            'usersPerc'      => $usersPerc,
            'activities'     => $totalActivities,
            'attendance'     => [
                'future' => [
                    'value'     => $attendingFuture,
                    'color'     => "#00c0ef",
                    'highlight' => "#00a7d0",
                    'label'     => "Next 7"
                ],
                'past'   => [
                    'value'     => $attendingPast,
                    'color'     => "#00a65a",
                    'highlight' => "#008d4c",
                    'label'     => "Prev 7"
                ]
            ]
        ]);
    }

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

    /**
     * Get the total free credits credit this month and prev month
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMonthlyFreeCredits()
    {
        $rows = Credit::where('type', Credit::$CREDIT)
            ->selectRaw('COUNT(id) AS total, MONTHNAME(created_at) AS month, MONTH(created_at) AS month_index, YEAR(created_at) AS year')
            ->groupBy(\DB::raw('month_index, month, year'))
            ->orderBy('year', 'desc')
            ->orderBy('month_index', 'desc')
            ->take(3)
            ->get();

        $items = [];
        foreach ($rows as $k => $row) {
            $items [] = ['value' => "{$row->total} - $row->month"];
        }

        return json_response($items);
    }
}