<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Campus
 *
 * @property integer $id
 * @property string $name
 * @property string $city
 * @property string $short
 * @property string $prefix
 * @property string $address
 * @property float $lat
 * @property float $lng
 * @property string $photo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereShort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus wherePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campus wherePhoto($value)
 * @mixin \Eloquent
 */
class Campus extends ApiModel
{
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

  
    public function users()
    {
        return $this->hasMany('App\Models\User', 'campus_id');
    }

/* Pas d'autre classes pour le moment
    public function courses()
    {
        return $this->hasMany('App\Models\Course', 'campus_id');
    }

    public function users()
    {
        // return $this->hasManyThrough('App\Models\User', 'App\Models\Gadz');
        return $this->belongsToMany('App\Models\User', 'gadz', 'campus_id', 'user_id');
    }

    public function rezams()
    {
        return $this->hasMany('App\Models\Residence', 'campus_id');
    }

*/
}
