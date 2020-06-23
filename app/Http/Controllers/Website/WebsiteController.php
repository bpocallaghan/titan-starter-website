<?php

namespace App\Http\Controllers\Website;

use App\Models\Page;
use App\Models\Banner;
use App\Models\Navigation;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    protected $baseViewPath = 'website.';

    protected $pageTitle = "";

    protected $showPageBanner = true;

    protected $page = false;

    protected $parentPages = [];

    protected $urlParentPages = [];

    protected $navigation = [];

    protected $footerNavigation = [];

    protected $popularPages = [];

    protected $activePageTiers = [];

    protected $breadcrumbItems = [];

    function __construct()
    {
        $this->findCurrentPage();
        $this->setPageBreadcrumb();

        $this->middleware(function ($request, $next) {
            $this->navigation = Page::getNavigation();
            $this->footerNavigation = Page::getNavigation('is_footer', 'footer_order');
            $this->popularPages = Page::getPopularPages();
            $this->activePageTiers = $this->findActivePageTiers();

            return $next($request);
        });
    }

    /**
     * Return / Render the view
     *
     * @param       $path
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($path, $data = [])
    {
        $banners = $this->getBanners();

        return parent::view($path, $data)
            ->with('settings', settings())
            ->with('banners', $banners)
            ->with('showPageBanner', $this->showPageBanner)
            ->with('image', $this->image)
            ->with('title', $this->getTitle())
            ->with('description', $this->getDescription())
            ->with('pageTitle', $this->getPageTitle())
            ->with('page', $this->page)
            ->with('activeParents', $this->urlParentPages)
            ->with('navigation', $this->navigation)
            ->with('footerNavigation', $this->footerNavigation)
            ->with('popularPages', $this->popularPages)
            ->with('activePageTiers', $this->activePageTiers)
            ->with('breadcrumbItems', $this->breadcrumbItems);
    }

    protected function getBanners()
    {
        $items = $this->page->banners;

        // if no banners linked to page - get default
        if ($items->count() <= 0) {
            $items = Banner::isActiveDates()
                ->where('is_website', 1)
                ->orderBy('list_order')
                ->get();
        }

        return $items;
    }

    /**
     * Get the HTML Title
     * @return string
     */
    protected function getPageTitle(): string
    {
        return (strlen($this->pageTitle) < 2 ? $this->page['title'] : $this->pageTitle);
    }

    /**
     * Get the HTML Title
     * @return string
     */
    protected function getTitle(): string
    {
        $navigation = array_reverse($this->urlParentPages);
        $this->title = strlen($this->title) > 5 ? $this->title : '';

        foreach ($navigation as $key => $nav) {
            if (strpos($this->title, $nav['title']) === false) {
                $this->title .= (strlen($this->title) > 5 ? ' - ' : '') . $nav['title'];
            }
        }

        return trim($this->title . (strlen($this->title) < 2 ? '' : ' | ') . config('app.name'));
    }

    /**
     * Get the HTML Description
     * @return string
     */
    protected function getDescription(): string
    {
        // this just allows the controller to overide the description
        if (strlen($this->description) <= 5) {
            $this->description = $this->page['description'];
        }

        return trim($this->description . (strlen($this->description) < 2 ? '' : ' | ') . config('app.description'));
    }

    /**
     * Get the slug from the url (url inside website)
     *
     * @param string $prefix
     * @return string
     */
    protected function getCurrentUrl($prefix = '/'): string
    {
        //$url = substr(request()->url(), strlen(config('app.url')));
        // prefix (request can be http://xx and app.url is https)
        $url = request()->path();
        $url = $prefix . ltrim($url, $prefix);

        return $url;
    }

    /**
     * Explode the url into slug pieces
     *
     * @return array
     */
    protected function getCurrentUrlSections(): array
    {
        return explode('/', $this->getCurrentUrl());
    }

    /**
     * Get the selected navigation
     * @return mixed
     */
    protected function findCurrentPage()
    {
        $url = $this->getCurrentUrl();
        $sections = $this->getCurrentUrlSections();

        // laravel removes last / get home / dashboard
        if ($url === false) {
            $page = Page::where('slug', '/')->get()->first();
        } else {
            // find nav with url - get last (parent can have same url)
            $page = Page::where('url', $url)
                ->orderBy('is_hidden', 'DESC')
                ->orderBy('url_parent_id')
                ->orderBy('header_order')
                ->get()
                ->last();
        }

        // we assume some params / reserved word is at the end
        if (!$page && strlen($url) > 2) {
            // keep cutting off from url until we find him in the db
            foreach ($sections as $key => $slug) {
                $url = substr($url, 0, strripos($url, '/'));

                // find nav with url - get last (parent can have same url)
                $page = Page::whereUrl($url)->get()->last();
                if ($page) {
                    break;
                }
            }
        }

        // when nothing - fall back to home
        if (!$page) {
            $page = Page::find(1);
            if (config('app.env') == 'local' && !$page) {
                dd('Whoops. Page not found - please see if url is in the pages table');
            }
        }

        // set the selected navigation
        $this->page = $page;

        // get all navigations -> ON parent_id
        $this->parentPages = $page->getParentsAndYou();

        // get all navigations -> ON url_parent_id
        $this->urlParentPages = $page->getUrlParentsAndYou();

        $this->page->increment('views');

        return $this->page;
    }

    /**
     * Get the active page tiers and the parent
     * @return object
     */
    private function findActivePageTiers()
    {
        // if selected page has a parent
        // find all pages with same parent id
        // if more than 1 - valid
        // if less than 1 - return 'about us'

        $name = 'About Us';
        $items = collect();
        if ($this->page->parent_id > 0) {
            $rows = Page::where('parent_id', $this->page->parent_id)
                ->orderBy('header_order')
                ->get();

            if ($items->count() > 1) {
                $items = $rows;
                $name = $this->page->parent->name;
            }
        }

        return (object) [
            'name'  => $name,
            'items' => $items,
        ];
    }

    /**
     * Init and Generate the website's breadcrumb nav bar
     */
    private function setPageBreadcrumb()
    {
        $this->breadcrumbItems = collect();
        $this->addBreadcrumbLink('Home', '/', 'home');

        $prevTitle = 'Home';
        foreach ($this->parentPages as $k => $page) {

            if ($page->title != $prevTitle) {
                $url = (is_slug_url($page->slug) ? $page->slug : url($page->url));
                $this->addBreadcrumbLink($page->title, $url);
            }

            $prevTitle = $page->title;
        }
    }

    /**
     * Add a link to the breadcrumb
     * @param        $title
     * @param        $url
     * @param string $class
     */
    public function addBreadcrumbLink($title, $url, $class = '')
    {
        $this->breadcrumbItems->push((object) ['name' => $title, 'url' => $url, 'class' => $class]);
    }
}
