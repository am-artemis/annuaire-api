<?php

namespace App;

// Model and other classes or used in ApiModel Class

class Campus extends ApiModel {
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'campuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'city', 'short', 'prefix', 'address', 'lat', 'lng', 'photo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'pivot', 'created_at', 'updated_at'];

    /**
     * Tell if the model contains timestamps or if it doesn't.
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * List of other dates to convert into Carbon objects.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * TODO
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany('App\User', 'campus_id');
    }

/* Pas d'autre classes pour le moment
    public function cursus()
    {
        return $this->hasMany('App\Cursus', 'campus_id');
    }

    public function users()
    {
        // return $this->hasManyThrough('App\User', 'App\Gadz');
        return $this->belongsToMany('App\User', 'gadz', 'campus_id', 'user_id');
    }

    public function rezams()
    {
        return $this->hasMany('App\Resam', 'campus_id');
    }

*/
}
