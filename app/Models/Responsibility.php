<?php

namespace App\Models;

// Model and other classes or used in ApiModel Class

/**
 * App\Models\Responsibility
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $strass
 * @property integer $campus_id
 * @property \Carbon\Carbon $from
 * @property \Carbon\Carbon $to
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Campus $campus
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereStrass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereCampusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Responsibility whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Responsibility extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'responsibilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'strass', 'from', 'to'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'user_id', 'campus_id', 'created_at', 'updated_at'];

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
    protected $dates = ['from', 'to', 'created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    
    public function campus()
    {
        return $this->belongsTo('App\Models\Campus', 'campus_id');
    }
}
