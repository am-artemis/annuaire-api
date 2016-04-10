<?php

namespace App;

// Model and other classes or used in ApiModel Class

class Social extends ApiModel {
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'socials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'logo'];

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
    public function users()
    {
        return $this->belongsToMany('User', 'user_social')->withPivot('url')->withTimestamps();
    }
}
