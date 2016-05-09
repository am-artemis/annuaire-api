<?php

namespace App\Models;

// Model and other classes or used in ApiModel Class

/**
 * App\Models\Social
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Social whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Social whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Social whereLogo($value)
 * @mixin \Eloquent
 */
class Social extends ApiModel
{
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
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_social')->withPivot('url')->withTimestamps();
    }
}
