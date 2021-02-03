<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

class CategoriesOrderController extends AdminController
{
    private $defaultParent = 0;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $itemsHtml = $this->getListOrderHtml($this->defaultParent);

        return $this->view('shop.categories.order', compact('itemsHtml'));
    }

    /**
     * Update the order of navigation
     *
     * @param Request $request
     * @return array
     */
    public function updateListOrder(Request $request)
    {
        $navigation = json_decode($request->get('list'), true);

        foreach ($navigation as $key => $nav) {

            $idd = $this->defaultParent ? $this->defaultParent->id : 0;
            $row = $this->updateResourceOrder($nav['id'], ($key + 1), $idd);

            $this->updateIfHasChildren($nav);
        }

        return ['result' => 'success'];
    }

    /**
     * Generate the nestable html
     *
     * @param null $parent
     *
     * @return string
     */
    private function getListOrderHtml($parent = null, $id = 0)
    {

        if (!(isset($parent) && $parent)) {
            $items = ProductCategory::orderBy('list_order')->get();
            $collapseClass = '';
            $collapseIdClass = '';
        }
        else {
            $items = ProductCategory::where('parent_id', $parent->id)->orderBy('list_order')->get();
            $collapseClass = ' collapse show';
            $collapseIdClass = ' collapse'.$parent->id.' ';
        }

        $html = '<div class="dd-list list-group '.$collapseClass.$collapseIdClass.'">';
        foreach ($items as $key => $nav) {
            $html .= '<div class="list-group-item mt-2 mb-2 card dd-item nested-'.$key.'" data-id="' . $nav->id . '">';
            $html .= '<button type="button" class="dd-handle btn btn-sm  btn-outline-secondary mr-3" href="#"> <i class="fa fa-list"></i> </button> ' . (strlen($nav->icon) > 1 ? '<i class="fa-fw fa fa-' . $nav->icon . '"></i> ' : '');
            $html .= '<a data-toggle="collapse" href=".collapse' . $nav->id . '" aria-expanded="true" aria-controls="collapse' . $key . '">'.$nav->name . '</a> ' . ($nav->is_hidden == 1 ? '(HIDDEN)' : '') . ' <span style="float:right"> ' . $nav->url . ' </span>';

            $html .= $this->getListOrderHtml($nav, ($key+1));
            $html .= '<div class="dd-list list-group collapse' . $nav->id.$collapseClass.'"></div>';

            $html .= '</div>';
        }

        $html .= '</div>';

        return (count($items) >= 1 ? $html : '');
    }

    /**
     * Loop through children and update list order (recursive)
     *
     * @param $nav
     */
    private function updateIfHasChildren($nav)
    {
        if (isset($nav['children']) && count($nav['children']) > 0) {
            $children = $nav['children'];
            foreach ($children as $c => $child) {
                $row = $this->updateResourceOrder($child['id'], ($c + 1), $nav['id']);

                $this->updateIfHasChildren($child);
            }
        }
    }

    /**
     * Update Navigation Item, with new list order and parent id (list and parent can change)
     *
     * @param     $id
     * @param     $listOrder
     * @param int $parentId
     *
     * @return mixed
     */
    private function updateResourceOrder($id, $listOrder, $parentId = 0)
    {
        $row = ProductCategory::find($id);
        $row->parent_id = $parentId;
        $row->updateUrl();
        $row['list_order'] = $listOrder;
        $row->save();

        return $row;
    }
}
