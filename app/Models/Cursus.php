<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Cursus
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $campus_id
 * @property string $school
 * @property-read \App\Models\Campus $campus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cursus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cursus whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cursus whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cursus whereCampusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cursus whereSchool($value)
 * @mixin \Eloquent
 */
class Cursus extends ApiModel
{
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


    public function campus()
    {
        return $this->belongsTo('App\Models\Campus', 'campus_id');
    }


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_cursus', 'cursus_id', 'user_id')->withPivot('from', 'to')->withTimestamps();
    }
}
