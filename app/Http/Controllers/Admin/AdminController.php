<?php

namespace App\Http\Controllers\Admin;

use App\Models\Navigation;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CRUDNotify;

class AdminController extends Controller
{
    use CRUDNotify;

    protected $baseViewPath = 'admin.';

    // name of the resource we are viewing / modify
    protected $resource = '';

    function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->setSelectedNavigation();
            // check role if user have role for navigation
            $this->middleware('role:' . $this->selectedNavigation->id);

            $this->navigation = Navigation::getAllByParentGrouped();

            $this->setPagecrumb();
            $this->setBreadcrumb();

            return $next($request);
        });
    }

    /**
     * Get the html name (check for crud reserve word)
     *
     * @return string
     */
    protected function getTitle(): string
    {
        if (strlen($this->title) <= 5) {
            if ($word = $this->checkIfReservedWordInUrl()) {
                $this->title .= ucfirst($word) . ' ';
            }

            $navigation = array_reverse($this->urlParentNavs);
            foreach ($navigation as $key => $nav) {
                $this->title .= $nav->name . ($key + 1 < count($navigation) ? ' - ' : '');
            }
        }

        return $this->title . ' - Admin | ' . config('app.name');
    }

    /**
     * Return / Render the view
     *
     * @param       $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($view, $data = [])
    {
        return parent::view($view, $data)
            ->with('resource', $this->resource)
            ->with('navigation', $this->navigation)
            ->with('pagecrumbItems', $this->pagecrumbItems)
            ->with('breadcrumbItems', $this->breadcrumbItems)
            ->with('selectedNavigation', $this->selectedNavigation)
            ->with('selectedNavigationParents', $this->urlParentNavs);
    }

    /**
     * Generate the breadcrumbs
     */
    protected function setBreadcrumb(): void
    {
        $url = config('app.url');
        $navItems = $this->urlParentNavs;

        $this->breadcrumbItems = collect();

        // add nav items
        foreach ($navItems as $k => $page) {
            $this->addBreadcrumbLink($page->name, $page->url, $page->icon);
        }

        // reserved word (create, edit, show)
        if ($word = $this->checkIfReservedWordInUrl()) {
            $this->addBreadcrumbLink(ucfirst($word));
        }
    }

    /**
     * Add bread crumb items
     * @param        $name
     * @param string $url
     * @param string $icon
     */
    public function addBreadcrumbLink($name, $url = '', $icon = ''): void
    {
        $this->breadcrumbItems->push((object) ['name' => $name, 'url' => $url, 'icon' => $icon]);
    }

    /**
     * Set page crumbs
     */
    public function setPagecrumb(): void
    {
        $url = config('app.url');
        $navItems = $this->urlParentNavs;

        $this->pagecrumbItems = collect();

        // add nav item
        if ($this->selectedNavigation) {
            $this->addPagecrumbLink($this->selectedNavigation->name, $this->selectedNavigation->url,
                $this->selectedNavigation->icon);
        }

        // reserved word (create, edit, show)
        if ($word = $this->checkIfReservedWordInUrl()) {
            $this->addPagecrumbLink(ucfirst($word));
        }
    }

    /**
     * Add page crumb items
     * @param        $name
     * @param string $url
     * @param string $icon
     */
    public function addPagecrumbLink($name, $url = '', $icon = ''): void
    {
        $this->pagecrumbItems->push((object) ['name' => $name, 'url' => $url, 'icon' => $icon]);
    }

    /**
     * Check if one of the keywords are in the url
     * @param bool $url
     * @return bool|mixed|string
     */
    protected function checkIfReservedWordInUrl($url = false)
    {
        $sections = $this->getCurrentUrlSections();
        if (count($sections) >= 1) {
            $last = (int) $sections[count($sections) - 1];
        }

        $keywords = [
            'show',
            'create',
            'edit',
        ];

        foreach ($sections as $key => $slug) {
            if (in_array($slug, $keywords, true)) {
                return $slug;
            }
        }

        // resource ID
        if ($last >= 1) {
            return 'show';
        }

        return false;
    }

    /**
     * Set the Current Navigation
     * Find the navigations parents and url parents
     */
    protected function setSelectedNavigation()
    {
        $url = $this->getCurrentUrl();
        $sections = $this->getCurrentUrlSections();

        // laravel removes last /
        if ($url === false) {
            // dahboard (substring from the /, laravel removes last /)
            $nav = Navigation::whereSlug('/')->get()->last();
        }
        else {
            // find nav with url - get last (parent can have same url)
            $nav = Navigation::where('url', '=', $url)
                ->orderBy('is_hidden', 'DESC')//->orderBy('url_parent_id')
                ->orderBy('list_order')
                ->get()
                ->last();
        }

        // we assume some params / reserved word is at the end
        if (!$nav && strlen($url) > 2) {
            // keep cutting off from url until we find him in the db
            foreach ($sections as $key => $slug) {
                $url = substr($url, 0, strripos($url, '/'));

                // find nav with url - get last (parent can have same url)
                $nav = Navigation::whereUrl($url)->get()->last();
                if ($nav) {
                    break;
                }
            }
        }

        // development testing
        if (config('app.env') === 'local' && !$nav) {
            //$this->selectedNavigation = (object) [
            //    'name' => 'fallback',
            //    'url'  => '/',
            //    'icon'  => 'warning',
            //    'mode'  => 'index',
            //    'help_index_title'  => null,
            //];
            //
            //return $this->selectedNavigation;
            //$nav = Navigation::find(1);
            dump($url);
            dd('Whoops. Navigation not found - please see if url is in database (navigation_admin)');
            //return false;
        }

        $this->selectedNavigation = $nav;

        // get all navigations -> ON parent_id
        $this->parentNavs = $nav->getParentsAndYou();

        // get all navigations -> ON url_parent_id
        $this->urlParentNavs = $nav->getUrlParentsAndYou();

        // name of resource - used on page to, eg, Add new 'resource', enter name of 'resource'
        $this->resource = Str::singular($nav->name); // TODO: - maybe add a 'resource' field on the table

        $mode = $this->checkIfReservedWordInUrl();

        $this->selectedNavigation->mode = $mode == false ? 'index' : $mode;

        return $this->selectedNavigation;
    }

    /**
     * Get the items, check if we use ajax or send items to view
     * Return the index view
     * @param string $view
     * @return mixed
     */
    protected function showIndex($view = '')
    {
        $items = $this->getTableRows();
        $ajax = count($items) > 150 ? 'true' : 'false';

        return $this->view($view, compact('ajax'))->with('items', $ajax == 'true' ? [] : $items);
    }

    /**
     * Return the data formatted for the table
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData()
    {
        $items = $this->getTableRows();

        return Datatables::of($items)->addColumn('action', function ($row) {
            return action_row($this->selectedNavigation->url, $row->id, $row->name,
                ['edit', 'delete']);
        })->make(true);
    }
}
