<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

abstract class ApiModel extends Model {

    protected $dates = ['created_at', 'updated_at'];

    protected static $columns = [];

    public function scopeClauses($query, Request $request)
    {
        return clauses($query, $request->all());
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function getRules()
    {
        if (isset($this::$rules))
            return $this::$rules;
        else
            return [];
    }

}
