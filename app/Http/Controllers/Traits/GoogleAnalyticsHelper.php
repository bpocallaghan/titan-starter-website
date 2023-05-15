<?php

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Facades\Analytics;

/**
 * https://github.com/spatie/laravel-analytics
 * http://www.colorhexa.com
 *
 * Class Analytics
 * @package Titan\Controllers\Traits
 */
trait GoogleAnalyticsHelper
{
    protected $datasets = [
        [
            'label'                => "",
            'fillColor'            => "rgba(60, 141, 188, 0.1)",
            'strokeColor'          => "rgba(60, 141, 188, 1)",
            'pointColor'           => "#3b8bba",
            'pointStrokeColor'     => "rgba(60,141,188,1)",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgba(220, 220, 220, 1)",
            'data'                 => [],
        ],
        [
            'label'                => "",
            'fillColor'            => "rgba(0, 141, 76, 0.1)",
            'strokeColor'          => "rgba(0, 141, 76, 1)",
            'pointColor'           => "rgba(0, 141, 76, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgba(220, 220, 220, 1)",
            'data'                 => [],
        ],
        [
            'label'                => "",
            'fillColor'            => "rgba(60, 141, 188, 0.1)",
            'strokeColor'          => "rgba(60, 141, 188, 1)",
            'pointColor'           => "#3b8bba",
            'pointStrokeColor'     => "rgba(60,141,188,1)",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgba(220, 220, 220, 1)",
            'data'                 => [],
        ],
        [ // SILVER - GREY
            'label'                => "",
            'fillColor'            => "rgba(192, 192, 192, 0.1)",
            'strokeColor'          => "rgba(192, 192, 192, 1)",
            'pointColor'           => "rgba(192, 192, 192, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
        [ // GOLD - YELLOW
            'label'                => "",
            'fillColor'            => "rgba(255, 200, 0, 0.1)",
            'strokeColor'          => "rgba(255, 200, 0, 1)",
            'pointColor'           => "rgba(255, 200, 0, 1)",
            'pointStrokeColor'     => "#fff",
            'pointHighlightFill'   => "#fff",
            'pointHighlightStroke' => "rgb(100, 100, 100)",
            'data'                 => [],
        ],
    ];

    protected $colorsPlaceholders = [
        'rgba(22, 160, 133, 1)',
        'rgba(52, 152, 219, 1)',
        'rgba(142, 68, 173, 1)',
        'rgba(243, 156, 18, 1)',
        'rgba(231, 76, 60, 1)',
        'rgba(192, 57, 43, 1)',
        'rgba(230, 126, 34, 1)',
        'rgba(241, 196, 15, 1)',
        'rgba(46, 204, 113, 1)',
        'rgba(127, 140, 141, 1)',
        'rgba(189, 195, 199, 1)',
        'rgba(149, 165, 166, 1)',
        'rgba(52, 73, 94, 1)',
        'rgba(44, 62, 80, 1)',
        'rgba(155, 89, 182, 1)',
        'rgba(41, 128, 185, 1)',
        'rgba(26, 188, 156, 1)',
        'rgba(39, 174, 96, 1)',
    ];

    /**
     * Get this months Visitors
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getVisitors()
    {
        return $this->monthlyComparison('activeUsers');
    }

    /**
     * Get this months Unique Visitors
     * @return int|string
     */
    public function getUniqueVisitors()
    {
        return $this->monthlyComparison('newUsers');
    }

    /**
     * Get this months Visitors
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getBounceRate()
    {
        return $this->monthlyComparison('bounceRate');
    }

    /**
     * Get this months average engament rate
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getAvgEngagementRate()
    {
        return json_response($this->monthlySummary('engagementRate'));
    }

    /**
     * Get this months visitors engament and views
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getVisitorsAndEngagementTime(){

        $period = $this->analyticsDuration();
        $data = Analytics::get($period, ['userEngagementDuration','activeUsers'], ['date'], 31 , [OrderBy::dimension('date', true)]);


        $totalViews = ['labels' => []];
        $userEngagementDuration = [];

        foreach ($data as $k => $item) {
            array_push($totalViews['labels'], $item['date']->format('d M'));

            $averageEngagementDuration = $item['userEngagementDuration'] / $item['activeUsers'];

            // (float)number_format(($item['userEngagementDuration'] / 60), 2,',','.')
            array_push($userEngagementDuration, (float) number_format(($averageEngagementDuration / 60), 2,'.',''));
        }

        $totalViews['datasets'][] = $this->getDataSet('Engagement Duration', $userEngagementDuration, 0);

        return json_encode($totalViews);

    }

    /**
     * Get the top keywords for duration
     * @return \Spatie\Analytics\Collection
     */
    public function getSessionGroup()
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], ['sessionDefaultChannelGroup'], 30, [OrderBy::metric('sessions', true)]);

        // dd($data);
        $items = [];
        // if not null
        if (!is_null($data)) {
            foreach ($data as $row) {
                $items[] = ['sessionDefaultChannelGroup' => $row['sessionDefaultChannelGroup'], 'sessions' => $row['sessions']];
            }
        }

        return $items;
    }

    /**
     * Get the top referrers for duration
     * @return \Spatie\Analytics\Collection
     */
    public function getReferrers()
    {
        $period = $this->analyticsDuration();

        $items = Analytics::fetchTopReferrers($period, 30);

        return $items;
    }

    /**
     * Get the active users currently viewing the website
     * @return int
     */
    public function getActiveVisitors()
    {

        $period = Period::create(Carbon::now()->startOfDay(), Carbon::now());

        // $total = Analytics::getAnalyticsService()
        //     ->data_realtime->get('ga:'.config('app.analytics_view_id'), 'rt:activeVisitors')
        //     ->totalsForAllResults['rt:activeVisitors'];
        $data = Analytics::get($period, ['totalUsers']);

        if($data->count() > 0){
            foreach($data as $key => $value){
                foreach($value as $key => $value){
                    $total = $value;
                }
                // $total = $value[0]['activeUsers'];
            }
            // $total = $data[]
        }else {
            $total = 0;
        }
        // dd($data);

        return json_response($total);
    }

    /**
     * Get the visitors and page views for duration
     * Format result for CartJS
     * @return string
     */
    public function getVisitorsAndPageViews()
    {
        $period = $this->analyticsDuration();
        // $data = Analytics::fetchTotalVisitorsAndPageViews($period);
        $data = Analytics::fetchTotalVisitorsAndPageViews($period);

        // dd($data);
        $totalViews = ['labels' => []];
        $visitors = [];
        $pageviews = [];
        foreach ($data as $k => $item) {
            array_push($totalViews['labels'], $item['date']->format('d M'));

            array_push($visitors, $item['activeUsers']);
            array_push($pageviews, $item['screenPageViews']);
        }

        $totalViews['datasets'][] = $this->getDataSet('Page Views', $pageviews, 0);
        $totalViews['datasets'][] = $this->getDataSet('Visitors', $visitors, 1);

        return json_encode($totalViews);

    }

    /**
     * Get the most visited pages for duration
     * @return \Spatie\Analytics\Collection
     */
    public function getVisitedPages()
    {
        $period = $this->analyticsDuration();
        $items = Analytics::fetchMostVisitedPages($period);

        return $items;
    }

    /**
     * Get the top browsers for duration
     * Format results for pie chart
     * @return \Spatie\Analytics\Collection
     */
    public function getBrowsers()
    {
        $period = $this->analyticsDuration();
        $data = Analytics::fetchTopBrowsers($period)->toArray();

        $keys = [];
        $values = [];
        shuffle($data); // shuffle results / randomimize chart color sections
        foreach ($data as $k => $item) {
            $keys[] = $item['browser'];
            $values[] = $item['screenPageViews'];

        }

        $items = $this->getPieDataSet($keys, $values, count($values));

        return $items;
    }

    /**
     * Get the gender comparisons
     * @return array
     */
    public function getUsersGender()
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], ['userGender']);

        $keys = [];
        $values = [];

        foreach ($data as $k => $item) {
            $keys[] = $item['userGender'];
            $values[] = $item['sessions'];
        }

        $items = $this->getPieDataSet($keys, $values, count($values));

        return $items;
    }

    /**
     * Get the users' age comparisons
     * @return array
     */
    public function getUsersAge()
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], ['userAgeBracket']);

        $labels = [];
        $datasets = [];
        $rows = $data;

        if ($rows->count() == 0) {
            return ['labels' => [], 'datasets' => []];
        }
        foreach ($rows as $k => $item) {
            $labels[] = ucfirst($item['userAgeBracket']);
            $datasets[] = $item['sessions'];
        }

        $datasets = [$this->getDataSet('Ages', $datasets, 0)];

        return ['labels' => $labels, 'datasets' => $datasets];
    }

    /**
     * Get the users' age comparisons
     * @return array
     */
    public function getResolutions()
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], ['screenResolution']);

        $labels = [];
        $datasets = [];
        $rows = $data;
        if (is_null($rows)) {
            return ['labels' => [], 'datasets' => []];
        }
        foreach ($rows as $k => $item) {
            $labels[] = ucfirst($item['screenResolution']);
            $datasets[] = $item['sessions'];
        }

        $datasets = [$this->getDataSet('Resolution', $datasets, 0)];

        return ['labels' => $labels, 'datasets' => $datasets];
    }

    /**
     * Get the event count and name
     * @return array
     */
    public function getEventCountName()
    {
        return $this->getEvents('eventName');
    }

    /**
     * Get this months Visitors
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getEventCount()
    {
        return json_response($this->monthlySummary('eventCount'));
    }

    /**
     * Get this months Visitors
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getEngagedSessionUsers()
    {
        return $this->monthlyComparison(['engagedSessions', 'activeUsers']);
    }

    /**
     * Get this months Visitors
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getEngagementTimeUser()
    {
        return $this->monthlyComparison(['userEngagementDuration', 'activeUsers'], 60);
    }

    /**
     * Get all the devices by sessions
     * @return mixed
     */
    public function getDevices()
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], ['mobileDeviceModel'], 30, [OrderBy::metric('sessions', true)]);

        $items = [];
        if ($data) {
            foreach ($data as $k => $item) {
                $items[$k] = [];
                $items[$k][0] = $item['mobileDeviceModel'];
                $items[$k][1] = intval($item['sessions']);
            }

            return $items;
        }

        return [];
    }

    /**
     * Get the desktop vs mobile vs tablet
     */
    public function getDeviceCategory()
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], ['deviceCategory']);

        $keys = [];
        $values = [];

        foreach ($data as $k => $item) {
            $keys[] = $item['deviceCategory'];
            $values[] = $item['sessions'];

        }

        $items = $this->getPieDataSet($keys, $values, count($values));

        return $items;

    }

    /**
     * Get the the users interests
     * @param $dimensions
     * @return \Spatie\Analytics\Collection
     */
    public function getInterests($dimensions)
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['sessions'], [$dimensions], 30, [OrderBy::metric('sessions', true)]);

        if (is_null($data)) {
            return [];
        }

        return $data;
    }

    /**
     * Get the the users events
     * @param $dimensions
     * @return \Spatie\Analytics\Collection
     */
    public function getEvents($dimensions)
    {
        $period = $this->analyticsDuration();

        $data = Analytics::get($period, ['eventCount'], [$dimensions], 30, [OrderBy::metric('eventCount', true)]);

        if (is_null($data)) {
            return [];
        }

        return $data;
    }

    /**
     * Helper to get the months analytics
     * @param string $metrics
     * @param string $month
     * @return \Illuminate\Http\JsonResponse|int
     */
    private function monthlySummary($metrics = 'activeUsers', $month = 'month', $divider = null)
    {
        if ($month == '-month_1') {
            $end = Carbon::now()->subMonth()->endOfMonth();
            $start = Carbon::now()->subMonth()->startOfMonth();
        }
        else {
            $end = Carbon::now();
            $start = Carbon::now()->startOfMonth();
        }

        if(is_array($metrics)){
            $period = Period::create($start, $end);

            $data = Analytics::get($period, $metrics);

            if ($data && count($data) >= 1 && count($data[0]) >= 1) {
                if($divider != null){
                    return ($data[0][$metrics[0]] / $data[0][$metrics[1]]) / $divider;
                }else {
                    return $data[0][$metrics[0]] / $data[0][$metrics[1]];
                }
            }
        }else {
            $period = Period::create($start, $end);

            $data = Analytics::get($period, [$metrics]);

            if ($data && count($data) >= 1 && count($data[0]) >= 1) {
                return $data[0][$metrics];
            }
        }

        $period = Period::create($start, $end);

        $data = Analytics::get($period, [$metrics]);

        if ($data && count($data) >= 1 && count($data[0]) >= 1) {
            return $data[0][$metrics];
        }

        return 0;
    }

    /**
     * Get this and last month of the metrics for a comparison
     * @param string $metrics
     * @return \Illuminate\Http\JsonResponse
     */
    private function monthlyComparison($metrics = 'activeUsers', $divider = null)
    {
        $thisMonth = $this->monthlySummary($metrics, 'month', $divider);
        $lastMonth = $this->monthlySummary($metrics, '-month_1', $divider);

        $backgrounds = [];

        for ($i = 0; $i < 2; $i++) {

            if(!array_key_exists($i,$this->colorsPlaceholders)){

                $tmp = $this->colorsPlaceholders;
                $this->colorsPlaceholders = array_merge($this->colorsPlaceholders, $tmp);
            }

            $backgrounds [] = $this->colorsPlaceholders[$i];
        }

        $dataset = [
            'datasets' => [[
                'data' => [(float)$thisMonth, (float)$lastMonth],
                'borderWidth'          => 2,
                'backgroundColor'      => $backgrounds,
                'borderColor'          => ['#fff'],
            ]],
            'labels' => [ 'Current', 'Previous']
        ];

        return json_response($dataset);
    }

    /**
     * Get the duration for the analytics
     * @return Period
     */
    private function analyticsDuration()
    {
        $start = input('start', date('Y-m-d', strtotime('-29 days')));
        $end = input('end', date('Y-m-d'));

        if (is_string($start)) {
            $start = \DateTime::createFromFormat('Y-m-d', $start);
        }

        if (is_string($end)) {
            $end = \DateTime::createFromFormat('Y-m-d', $end);
        }

        return Period::create($start, $end);
    }

    /**
     * Get the line dataset opbject
     * @param     $label
     * @param     $data
     * @param int $index
     * @return mixed
     */
    private function getDataSet($label, $data, $index = 0)
    {
        $set = $this->datasets[$index];
        $set['label'] = $label;
        $set['data'] = $data;

        $backgrounds = [];
        $borderColor = [];

        if($index == 0){
            for ($i = 0; $i < count($data); $i++) {

                if(!array_key_exists($i,$this->colorsPlaceholders)){

                    $tmp = $this->colorsPlaceholders;
                    $this->colorsPlaceholders = array_merge($this->colorsPlaceholders, $tmp);
                }

                $colors [] = $this->colorsPlaceholders[$i];
                $backgrounds [] = str_replace(", 1)", ", 0.2)",
                    $this->colorsPlaceholders[$i]);

                    $borderColor [] = $this->colorsPlaceholders[$i];
            }
        }else {
            if(!array_key_exists($index,$this->colorsPlaceholders)){

                $tmp = $this->colorsPlaceholders;
                $this->colorsPlaceholders = array_merge($this->colorsPlaceholders, $tmp);
            }

            $colors [] = $this->colorsPlaceholders[$index];
            $backgrounds [] = str_replace(", 1)", ", 0.2)",
                $this->colorsPlaceholders[$index]);
            $borderColor [] = $this->colorsPlaceholders[$index];
        }


        $set['backgroundColor'] = $backgrounds;
        $set['borderColor'] = $borderColor;
        $set['pointBorderColor'] = '#fff';
        $set['pointBackgroundColor'] = $borderColor[0];
        $set['borderWidth'] = 1.5;

        return $set;
    }

    /**
     * Get the pie chart data
     * @param     $label
     * @param     $data
     * @param int $count
     * @return mixed
     */
    private function getPieDataSet($label, $data, $count = -1)
    {
        if ($count < 0) {
            $index = rand(0, count($this->pieData) - 1);
        }

        $set['label'] = $label;
        $set['value'] = $data;

        $backgrounds = [];
        $borders = [];

        for ($i = 0; $i < $count; $i++) {

            if(!array_key_exists($i,$this->colorsPlaceholders)){

                $tmp = $this->colorsPlaceholders;
                $this->colorsPlaceholders = array_merge($this->colorsPlaceholders, $tmp);
            }

            $backgrounds [] = $this->colorsPlaceholders[$i];
        }

        $dataset = [
            'datasets' => [[
                'data' => $data,
                'borderWidth'          => 2,
                'backgroundColor'      => $backgrounds,
                'borderColor'          => ['#fff'],
            ]],
            'labels' =>  $label
        ];

        return $dataset;
    }
}