<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

abstract class ApiModel extends Model
{
    /**
     * List of fields to convert into Carbon objects.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
}
