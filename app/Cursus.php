<?php

namespace App;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

class Cursus extends ApiModel {
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'cursus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'campus_id', 'school'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];

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
    public function campus()
    {
        return $this->belongsTo('App\Campus', 'campus_id');
    }

    /**
     * TODO
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_cursus', 'cursus_id', 'user_id')->withPivot('from', 'to')->withTimestamps();
    }
}
