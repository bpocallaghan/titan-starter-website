<?php

namespace App\Http\Controllers\Website;

use App\Models\Navigation;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    protected $baseViewPath = 'website.';

    /**
     * Return / Render the view
     *
     * @param       $path
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($path, $data = [])
    {
        return parent::view($path, $data)
            ->with('banners', collect([]));
    }
}
