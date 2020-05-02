<?php

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait DataTableHelpers
{
    private $sessionKey = 'datatables';

    /**
     * Get the date from
     * @return mixed
     */
    private function dateFrom()
    {
        $date = Carbon::now()->subWeek(1)->startOfWeek();
        if (input('date_from')) {
            $date = Carbon::createFromFormat('Y-m-d', input('date_from'));
        }

        $dateFrom = session("{$this->sessionKey}.date_from", $date);
        $dateFrom = $dateFrom->startOfDay();

        session()->put("{$this->sessionKey}.date_from", $dateFrom);

        return $dateFrom;
    }

    /**
     * Get the date to
     * @return mixed
     */
    private function dateTo()
    {
        $date = Carbon::now()->addWeek(1)->endOfWeek();
        if (input('date_to')) {
            $date = Carbon::createFromFormat('Y-m-d', input('date_to'));
        }

        $dateTo = session("{$this->sessionKey}.date_to", $date);
        $dateTo = $dateTo->endOfDay();

        session()->put("{$this->sessionKey}.date_to", $dateTo);

        return $dateTo;
    }

    /**
     * Update the dates and set in session
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDates(Request $request)
    {
        if (input('date_from')) {
            $date = Carbon::createFromFormat('Y-m-d', input('date_from'));
            session()->put("{$this->sessionKey}.date_from", $date);
        }

        if (input('date_to')) {
            $date = Carbon::createFromFormat('Y-m-d', input('date_to'));
            session()->put("{$this->sessionKey}.date_to", $date);
        }

        return json_response('success');
    }

    /**
     * Remove the dates in session
     * Show the original entries
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resetDates(Request $request)
    {
        session()->forget("{$this->sessionKey}.date_from");
        session()->forget("{$this->sessionKey}.date_to");

        return redirect_to_resource();
    }
}