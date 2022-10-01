<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @mixin \Eloquent
 */
class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'        => 'required|min:3|max:191',
        'slogan'      => 'nullable',
        'description' => 'required|min:3|max:2000',
        'keywords'    => 'nullable',
        'author'      => 'required',

        // contact
        'email'       => 'nullable',
        'cellphone'   => 'nullable',
        'telephone'   => 'nullable',
        'address'     => 'nullable',
        'po_box'      => 'nullable',

        // social media
        'facebook'    => 'nullable',
        'twitter'     => 'nullable',
        'googleplus'  => 'nullable',
        'linkedin'    => 'nullable',
        'youtube'     => 'nullable',
        'instagram'   => 'nullable',

        // google maps
        'zoom_level'  => 'nullable',
        'latitude'    => 'nullable',
        'longitude'   => 'nullable',
    ];

    static public $messages = [];
}
