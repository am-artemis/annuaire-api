<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Resam
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property float $lat
 * @property float $lng
 * @property integer $campus_id
 * @property-read \App\Models\Campus $campus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Resam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Resam whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Resam whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Resam whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Resam whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Resam whereCampusId($value)
 * @mixin \Eloquent
 */
class Resam extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'resams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'lat', 'lng', 'campus_id'];

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
        return $this->belongsToMany('App\Models\User', 'user_resam', 'resam_id', 'user_id')->withPivot('room', 'from', 'to')->withTimestamps();
    }
}
