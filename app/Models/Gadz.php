<?php

namespace App\Models;

// Model and other classes or used in ApiModel Class

/**
 * App\Models\Gadz
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $buque
 * @property string $fams
 * @property string $famsSearch
 * @property integer $proms
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereBuque($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereFams($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereFamsSearch($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereProms($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gadz whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gadz extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'gadz';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['buque', 'fams', 'famsSearch', 'proms'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at'];

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


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
