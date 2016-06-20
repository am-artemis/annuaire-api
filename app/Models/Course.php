<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Course
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $campus_id
 * @property string $school
 * @property-read \App\Models\Campus $campus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereCampusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereSchool($value)
 * @mixin \Eloquent
 */
class Course extends ApiModel
{

    public $timestamps = false;
    protected $table = 'courses';
    protected $fillable = ['title', 'description', 'campus_id', 'school'];
    protected $hidden = ['id'];
    protected $dates = [];


    public function campus()
    {
        return $this->belongsTo('App\Models\Campus', 'campus_id');
    }


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_course', 'course_id', 'user_id')
            ->withPivot('id', 'from', 'to')->withTimestamps();
    }
}
