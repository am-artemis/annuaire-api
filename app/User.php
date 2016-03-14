<?php

namespace App;

// Model and other classes or used in ApiModel Class

class User extends ApiModel {
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'year', 'gender', 'mail', 'phone', 'campus_id', 'birthday'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id','auth_id', 'campus_id', 'created_at', 'updated_at'];

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
    protected $dates = ['birthday'];

    /**
     * TODO
     *
     * @return void
     */
    public function campus()
    {
        return $this->belongsTo('App\Campus', 'campus_id');
    }

/* Pas d'autre classes pour le moment
    public function gadz()
    {
        return $this->hasOne('App\Gadz', 'user_id');
    }

    public function campus()
    {
        return $this->belongsTo('App\Campus', 'campus_id');
    }

    public function cursus()
    {
        return $this->belongsToMany('App\Cursus', 'user_cursus', 'user_id', 'cursus_id')->withPivot('from', 'to')->withTimestamps();
    }

    public function degrees()
    {
        return $this->belongsToMany('App\Degree', 'user_degree', 'user_id', 'degree_id')->withTimestamps();
    }

    public function jobs()
    {
        return $this->hasMany('App\Job', 'user_id');
    }

    public function resams()
    {
        return $this->belongsToMany('App\Resam', 'user_resam', 'user_id', 'resam_id')->withPivot('room', 'from', 'to')->withTimestamps();
    }

    public function addresses()
    {
        return $this->hasMany('App\Address', 'user_id');
    }

    public function socials()
    {
        return $this->belongsToMany('App\Social', 'user_social', 'user_id', 'social_id')->withPivot('url')->withTimestamps();
    }

    public function bouls()
    {
        return $this->hasMany('App\Bouls', 'user_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo', 'user_id');
    }

    public function tags()
    {
        return $this->hasOne('App\Tags', 'user_id');
    }
*/
}