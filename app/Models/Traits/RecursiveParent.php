<?php

namespace App\Models\Traits;

trait RecursiveParent
{
    /**
     * Get the top level parents
     * If the parent_id is null or parent_id = 0
     * @return mixed
     */
    public static function parents()
    {
        return self::whereRaw('(parent_id is NULL OR parent_id = 0)')
            ->orderBy('title')
            ->get();
    }

    /**
     * Get the parents as list (for html selects)
     * @return mixed
     */
    public static function parentsList()
    {
        return self::parents()->pluck('title', 'id')->toArray();
    }

    /**
     * Get all the top level parents and their children
     * @return mixed
     */
    public static function parentsWithChildren()
    {
        return self::whereRaw('(parent_id is NULL OR parent_id = 0)')
            ->with('children')
            ->orderBy('title')
            ->get();
    }

    /**
     * Get the parent
     * @return \Eloquent
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * Get the models
     * @return \Eloquent
     */
    public function children()
    {
        return $this->belongsTo(self::class, 'id', 'parent_id');
    }

    /**
     * Get the children attribute
     * @return \Eloquent
     */
    public function getChildrenAttribute()
    {
        return $this->children()->get();
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
}
