<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Navigation
 * @mixin \Eloquent
 */
class Navigation extends AdminModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'navigations';

    protected $guarded = ['id'];

    // prefix path
    protected $prefixPath = '/admin';

    /**
     * Validation rules for this model
     *
     * @var array
     */
    static public $rules = [
        'icon'        => 'required|min:1',
        'name'        => 'required|min:2|max:191',
        'description' => 'required|min:3|max:191',
        'roles'       => 'required|array',
    ];

    /**
     * Remove the ending '/'
     * @return string
     */
    public function getUrlAttribute()
    {
        return rtrim($this->attributes['url'], '/');
    }

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
     * @param      $id
     * @param bool $hidden (if we need to include hidden)
     * @return mixed
     */
    static public function whereParentIdORM($id, $hidden = false)
    {
        $builder = self::whereParentId($id);
        if (!$hidden) {
            $builder->where('is_hidden', 0);
        }

        return $builder->orderBy('list_order')->get();
    }

    /**
     * Get the url from db
     * If true given, we generate a new one,
     * This us usefull if parent_id updated, etc
     *
     * @return \Eloquent
     */
    public function updateUrl()
    {
        $this->url = '';
        $this->generateCompleteUrl($this);
        $this->url = $this->prefixPath . $this->url;

        if (strlen($this->slug) > 1) {
            $this->url .= "/{$this->slug}";
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

        if ($row) {
            if (strlen($row->slug) > 1) {
                $this->url = "/{$row->slug}" . ("{$this->url}");
            }

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
     * Get all the navigation to render
     * Hide hidden
     * Order by list order
     * Group by parent_id
     * @return mixed
     */
    public static function getAllByParentGrouped()
    {
        $roles = false;
        if (method_exists(user(), 'roles') && method_exists(user(), 'getRolesList')) {
            $roles = true;
        }

        $builder = self::where('is_hidden', 0);

        // if roles are defined on user
        if ($roles) {
            $roles = user()->getRolesList();
            $builder->whereHas('roles', function ($query) use ($roles) {
                return $query->whereIn('roles.id', $roles);
            });
        }

        $items = $builder->orderBy('list_order')
            ->select('id', 'name', 'slug', 'url', 'icon', 'parent_id')
            ->get()
            ->groupBy('parent_id');

        if (count($items)) {
            $items['root'] = collect();
            if (isset($items[''])) {
                $items['root'] = $items[''];
                unset($items['']);
            }
            if (isset($items[0])) {
                $items['root'] = $items[0];
                unset($items[0]);
            }
        }

        return $items;
    }

    /**
     * Get the roles
     * @return \Eloquent
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'navigation_role')->withTimestamps();
    }

    public function getRolesStringAttribute()
    {
        return implode(', ', $this->roles()->get()->pluck('name', 'id')->toArray());
    }

    /**
     * Get a the name + url concatenated
     *
     * @return string
     */
    public function getNameUrlAttribute()
    {
        $name = $this->attributes['name'] . ' ( ' . $this->attributes['url'] . ' )';
        if ($this->parent) {
            $name .= " - {$this->parent->name}";
        }

        return $name;
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllLists()
    {
        return self::with('parent')->orderBy('name')->get()->pluck('name_url', 'id')->toArray();
    }
}
