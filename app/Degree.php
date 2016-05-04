<?php

namespace App;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

class Degree extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'degrees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'school', 'am'];

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
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_degree', 'degree_id', 'user_id')->withPivot('year')->withTimestamps();
    }
}
