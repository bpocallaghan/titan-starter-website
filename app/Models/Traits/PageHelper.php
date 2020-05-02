<?php

namespace App\Models\Traits;

use App\Models\Page;

trait PageHelper
{
    /**
     * Get the parent
     *
     * @return \Eloquent
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * Get the parent
     *
     * @return \Eloquent
     */
    public function urlParent()
    {
        return $this->belongsTo(self::class, 'url_parent_id', 'id');
    }

    /**
     * Get All navigation where parent id, and not hidden
     *
     * @param        $id
     * @param string $type
     * @param string $order
     * @param int    $hidden
     * @return mixed
     */
    static public function whereParentIdORM(
        $id, $type = 'list', $order = 'list_order', $hidden = 0
    ) {
        $query = Page::query();
        if ($type != "featured") {
            $query->whereParentId($id);
        }

        switch ($type) {
            case "header":
                $query->where('is_header', 1);
                break;
            case "footer";
                $query->where('is_footer', 1);
                break;
            case "featured":
                $query->where('is_featured', 1);
                break;
            default:
                $query->where('is_header', 0);
                $query->where('is_footer', 0);
        }

        return $query->orderBy($order)->get();

        return $query->where('is_hidden', $hidden)->orderBy($order)->get();
    }

    /**
     * Get the url from db
     * If true given, we generate a new one,
     * This us usefull if parent_id updated, etc
     */
    public function updateUrl()
    {
        // if slug is url
        if (is_slug_url($this->slug)) {
            $this->url = $this->slug;

            return $this;
        }

        $this->url = '';
        $this->generateCompleteUrl($this);
        $this->url = $this->url;

        if (strlen($this->slug) == 1) {
            $this->url = $this->slug;
        }
        else if (strlen($this->slug) > 1) {
            $this->url .= (is_slug_url($this->slug) ? "" : "/") . $this->slug;
        }

        return $this;
    }

    /**
     * Generate the new nav based on parent_id
     *
     * @param $nav
     * @return \Illuminate\Support\Collection|static
     */
    private function generateCompleteUrl($nav)
    {
        $row = self::find($nav->url_parent_id);

        if ($row && strlen($row->slug) > 1) {
            $this->url = "/{$row->slug}" . ("{$this->url}");

            return $this->generateCompleteUrl($row);
        }

        return $row;
    }

    /**
     * Get All his parents and himself
     *
     * @return mixed
     */
    public function getParentsAndYou()
    {
        return $this->getParentsRecursive($this, []);
    }

    /**
     * Recursive find his parents
     *
     * @param $nav
     * @param $parents
     * @return mixed
     */
    private function getParentsRecursive($nav, $parents)
    {
        if ($parent = $nav->parent) {
            $parents = $this->getParentsRecursive($parent, $parents);
        }

        array_push($parents, $nav);

        return $parents;
    }

    /**
     * Get All his parents and himself
     *
     * @return mixed
     */
    public function getUrlParentsAndYou()
    {
        return $this->getUrlParentsRecursive($this, []);
    }

    /**
     * Recursive find his parents
     *
     * @param $nav
     * @param $parents
     * @return mixed
     */
    private function getUrlParentsRecursive($nav, $parents)
    {
        if ($urlParent = $nav->urlParent) {
            $parents = $this->getUrlParentsRecursive($urlParent, $parents);
        }

        array_push($parents, $nav);

        return $parents;
    }

    /**
     * Get All navigation where parent id, and not hidden
     *
     * @param        $id
     * @param string $type
     * @return mixed
     */
    static public function parentIdAndType($id, $type = 'main')
    {
        $builder = self::where('parent_id', $id);
        $builder->where("is_$type", 1);
        $builder->where("is_hidden", 0);

        return $builder->orderBy("list_$type" . '_order')->get();
    }

    /**
     * Get all the navigation to render
     * Hide hidden
     * Order by list order
     * Group by parent_id
     * @param $type
     * @param $order
     * @return mixed
     */
    public static function getNavigation($type = 'is_header', $order = 'header_order')
    {
        $builder = self::where('is_hidden', 0);
        $builder->where($type, 1);

        if (!\Auth::check()) {
            $builder->where('name', '!=', 'My Account');
        }

        $items = $builder->orderBy($order)
            ->select('id', 'icon', 'name', 'title', 'description', 'slug', 'url', 'parent_id',
                'views')
            ->get()
            ->groupBy('parent_id');

        if (count($items)) {
            $items['root'] = collect();
            if (isset($items['']) || isset($items[0])) {
                $items['root'] = isset($items['']) ? $items[''] : $items[0];
                unset($items['']);
                unset($items[0]);
            }
        }

        return $items;
    }

    public static function getFeatured()
    {
        return self::where('is_featured', 1)->orderBy('featured_order')->get();
    }

    /**
     * Get the popular pages
     * @return static
     */
    public static function getPopularPages()
    {
        // exclude pages
        $ids = Page::where('slug', '/')
            ->orWhere('url', '=', '')
            ->orWhere('url', 'LIKE', '/auth%')
            ->orWhere('url', 'LIKE', '/account%')
            ->get()
            ->pluck('id', 'id')
            ->values()
            ->toArray();

        // get the popular pages
        $items = Page::where('is_hidden', 0)
            ->whereNotIn('id', $ids)
            ->orderBy('views', 'DESC')
            ->get()
            ->take(5);

        return $items;
    }
}
