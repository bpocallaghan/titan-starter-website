<?php

namespace App\Http\Controllers\Api;

use Analytics;
use App\Http\Requests;
use App\Models\Activity;
use LaravelAnalytics;

class SharesController extends ApiController
{
    public function index()
    {
        $url = substr(input('url'), strlen(config('app.url')));
        if (input('shareable_type') == 'activity') {
            $item = Activity::find(input('shareable_id'));
            if ($item) {
                $item->increment('social_shares');
            }
        }

        log_activity('Social Share', 'URL was shared: ' . input('url'));

        return json_response();
    }
}