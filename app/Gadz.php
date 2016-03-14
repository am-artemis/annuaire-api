<?php

namespace App;

// Model and other classes or used in ApiModel Class

class Gadz extends ApiModel {
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'gadz';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['buque', 'fams', 'famsSearch', 'proms'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at'];

    /**
     * Tell if the model contains timestamps or if it doesn't.
     *
     * @var array
     */
    public $timestamps = true;

    /**
     * List of other dates to convert into Carbon objects.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * TODO
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
