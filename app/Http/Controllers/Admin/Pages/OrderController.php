<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class OrderController extends AdminController
{
    private $navigationType = 'list';

    private $defaultParent = 0;

    private $orderProperty = 'header_order';

    private function updateNavType($type = 'list')
    {
        $this->defaultParent = 0;
        $this->navigationType = $type;
        $this->orderProperty = $type . '_order';
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($type = 'list')
    {
        $this->updateNavType($type);

        $itemsHtml = $this->getNavigationHtml($this->defaultParent);

        return $this->view('pages.order', compact('itemsHtml'));
    }

    /**
     * Update the order of navigation
     *
     * @param string  $type
     * @param Request $request
     * @return array
     */
    public function updateOrder(Request $request, $type = 'list')
    {
        $this->updateNavType($type);

        $navigation = json_decode($request->get('list'), true);

        foreach ($navigation as $key => $nav) {

            $idd = $this->defaultParent ? $this->defaultParent->id : 0;
            $row = $this->updateNavigationListOrder($nav['id'], ($key + 1), $idd);

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
            $parentId = 0;
            $collapseClass = '';
            $collapseIdClass = '';
        }
        else {
            $parentId = $parent->id;
            $collapseClass = ' collapse show';
            $collapseIdClass = ' collapse'.$parent->id.' ';
        }
        $items = Page::whereParentIdORM($parentId, $this->navigationType, $this->orderProperty);

        $html = '<div class="dd-list list-group '.$collapseIdClass.$collapseClass.'" >';

        foreach ($items as $key => $nav) {
            $html .= '<div class="list-group-item mt-2 mb-2 card dd-item nested-'.$key.'" data-id="' . $nav->id . '">';
            $html .= '<button type="button" class="dd-handle btn btn-sm  btn-outline-secondary mr-3" href="#"> <i class="fa fa-list"></i> </button>  ' . (strlen($nav->icon) > 1 ? '<i class="fa-fw fa fa-' . $nav->icon . '"></i> ' : '');
            $html .= '<a data-toggle="collapse" href=".collapse' . $nav->id . '" aria-expanded="true" aria-controls="collapse' . $key . '">'.$nav->name . '</a> ' . ($nav->is_hidden == 1 ? '(HIDDEN)' : '') . ' <span class="text-muted float-right"> ' . $nav->url . ' </span>';
            // featured - ignore parent_id (only one level)
            if ($this->orderProperty != "featured_order") {
                $html .= $this->getNavigationHtml($nav, ($key+1));
            }
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
        $row = Page::find($id);
        $row->parent_id = $parentId;

        $row->updateUrl();
        $row[$this->orderProperty] = $listOrder;
        $row->save();

        return $row;
    }
}
