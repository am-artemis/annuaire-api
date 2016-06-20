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

    public $timestamps = false;
    protected $table = 'campuses';
    protected $fillable = ['name', 'city', 'short', 'prefix', 'address', 'lat', 'lng', 'photo'];
    protected $hidden = ['id', 'pivot', 'created_at', 'updated_at'];
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
