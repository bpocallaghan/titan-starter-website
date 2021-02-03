<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Navigation;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class NavigationOrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $html = $this->getNavigationHtml();

        return $this->view('settings.navigations.order')->with('itemsHtml', $html);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function updateOrder(Request $request)
    {
        $navigation = json_decode($request->get('list'), true);

        foreach ($navigation as $key => $nav) {
            $row = $this->updateNavigationListOrder($nav['id'], ($key + 1));

            $this->updateIfNavHasChildren($nav);
        }

        return ['result' => 'success'];
    }

    /**
     * Generate the nestable html
     *
     * @param null $parent
     * @param $id
     *
     * @return string
     */
    private function getNavigationHtml($parent = null, $id = 0)
    {
        if (!(isset($parent) && $parent)) {
            $items = Navigation::whereParentIdORM(0, true);
            $collapseClass = '';
            $collapseIdClass = '';
        }
        else {
            $items = Navigation::whereParentIdORM($parent->id, true);
            $collapseClass = ' collapse show';
            $collapseIdClass = ' collapse'.$parent->id.' ';
        }

        $html = '<div class="dd-list list-group '.$collapseClass.$collapseIdClass.'">';
        foreach ($items as $key => $nav) {
            $html .= '<div class="list-group-item mt-2 mb-2 card dd-item nested-'.$key.'" data-id="' . $nav->id . '">';
            $html .= '<button type="button" class="dd-handle btn btn-sm  btn-outline-secondary mr-3" href="#"> <i class="fa fa-list"></i> </button> ' . (strlen($nav->icon) > 1 ? '<i class="fa-fw fa fa-' . $nav->icon . '"></i> ' : '');
            $html .= '<a data-toggle="collapse" href=".collapse' . $nav->id . '" aria-expanded="true" aria-controls="collapse' . $key . '">'.$nav->name . '</a> ' . ($nav->is_hidden == 1 ? '(HIDDEN)' : '') . ' <span style="float:right"> ' . $nav->url . ' </span>';

            $html .= $this->getNavigationHtml($nav, ($key+1));
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
    private function updateIfNavHasChildren($nav)
    {
        if (isset($nav['children']) && count($nav['children']) > 0) {
            $children = $nav['children'];
            foreach ($children as $c => $child) {
                $row = $this->updateNavigationListOrder($child['id'], ($c + 1), $nav['id']);

                $this->updateIfNavHasChildren($child);
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
    private function updateNavigationListOrder($id, $listOrder, $parentId = 0)
    {
        $row = Navigation::find($id);
        $row->list_order = $listOrder;
        $row->parent_id = $parentId;
        //$row->url_parent_id = $parentId; // update the url parent id as well
        $row->updateUrl();
        $row->save();

        return $row;
    }
}
