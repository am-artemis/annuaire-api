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

    public $timestamps = false;
    protected $table = 'socials';
    protected $fillable = ['name', 'logo'];
    protected $hidden = ['id'];
    protected $dates = [];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_social')->withPivot('url')->withTimestamps();
    }
}
