<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Models\FAQ;
use App\Models\FAQCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class OrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $items = FAQCategory::with('faqs')->orderBy('name')->get();

        //$items = FAQ::with('category')->orderBy('list_order')->get();

        return $this->view('faqs.order')->with('items', $items);
    }

    /**
     * Update the order
     */
    public function update()
    {
        $items = json_decode(request()->get('list'), true);

        foreach ($items as $key => $item) {
            if(isset($item['id'])) {
                FAQ::findOrFail($item['id'])->update(['list_order' => ($key + 1)]);
            }
        }

        return ['result' => 'success'];
    }
}
