<?php

namespace App\Models\Traits;

use App\Models\Section;
use App\Models\Content;
use App\Models\Layout;

trait Sectionable
{
    /**
     * Get the first section
     * @return mixed
     */
    public function getSectionContentAttribute()
    {
        return $this->sections()->first();
    }

    /**
     * Get the different layouts available
     * @return mixed
     */
    public function getLayoutsAttribute()
    {

        $layout = Layout::getAllLists($this->template_id);

        return $layout;
    }

    // /**
    //  * Get the different layouts available
    //  * @return mixed
    //  */
    // public function getLayoutsAttribute()
    // {
    //     return [
    //         'col-12'    => '1 Column',
    //         'col-md-6'  => '2 Columns',
    //         'col-md-4'  => '3 Columns',
    //         'col-md-3'  => '4 Columns',
    //         'contact'   => 'Include Contact Form',
    //         'article'      => 'Include Articles',
    //         'faq'       => 'Include FAQ\'s',
    //         'products'  => 'Include Products'
    //     ];
    // }

    /**
     * Get the first document
     * @return mixed
     */
    public function getOtherContentAttribute()
    {
        return Content::getAllList();
    }

    /**
     * Get all of the sections.
     */
    public function sections()
    {
        return $this->morphMany(Section::class, 'sectionable');
    }
}
