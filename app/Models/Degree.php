<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Degree
 *
 * @property integer $id
 * @property string $title
 * @property string $school
 * @property boolean $am
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Degree whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Degree whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Degree whereSchool($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Degree whereAm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Degree whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Degree whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Degree extends ApiModel
{

    public $timestamps = true;
    protected $table = 'degrees';
    protected $fillable = ['title', 'school', 'am'];
    protected $hidden = ['id'];
    protected $dates = ['created_at', 'updated_at'];


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_degree', 'degree_id', 'user_id')->withPivot('year')->withTimestamps();
    }
}
