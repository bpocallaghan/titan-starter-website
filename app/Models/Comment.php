<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Client
 * @mixin Builder
 */
class Comment extends AdminModel
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $guarded = ['id'];

    protected $casts = ['approved_at' => 'datetime'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'              => 'nullable|min:3|max:191',
        'email'             => 'nullable|min:2|max:50|email',
        'content'           => 'required|min:5|max:5000',
        'is_approved'       => 'nullable|in:0,on',
        'approved_by'       => 'nullable|exists:users,id',
        'approved_at'       => 'nullable|date',
        'commentable_id'    => 'required',
        'commentable_type'  => 'required'
    ];

    /**
     * Get the approvedBy
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    /**
     * Get the createdBy
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
