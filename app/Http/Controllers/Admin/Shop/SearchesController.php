<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\LogProductSearch;
use DataTables;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Traits\DataTableHelpers;

class SearchesController extends AdminController
{
    use DataTableHelpers;

    function __construct()
    {
        $this->sessionKey = 'searches';

        parent::__construct();
    }

    /**
     * Display a listing of classes.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        return $this->showIndex("shop.searches.index")
            ->with('fromDate', $this->dateFrom())
            ->with('toDate', $this->dateTo());
    }

    /**
     * Get all the table rows list
     * @return mixed
     */
    public function getTableRows()
    {
        $start = $this->dateFrom();
        $end = $this->dateTo();

        $items = LogProductSearch::whereBetween('created_at', [$start, $end])
            ->groupBy('slug')
            ->orderBy('total', 'DESC')
            ->selectRaw('slug, COUNT(slug) as total')
            ->limit(25)
            ->get();

        return $items;
    }

    /**
     * Return the data formatted for the table
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData()
    {
        $items = $this->getTableRows();

        return Datatables::of($items)->make(true);
    }
}
