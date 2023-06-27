<?php

namespace App\Models;

use App\Models\Traits\ModifyBy;
use Illuminate\Database\Eloquent\Model;
use Bpocallaghan\LogActivity\Models\Traits\LogModelActivities;

class AdminModel extends Model
{
    use ModifyBy, LogModelActivities;

    /**
     * Validation custom messages for this model
     */
    static public $messages = [];
}
