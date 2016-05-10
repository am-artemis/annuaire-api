<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Photo
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $src
 * @property string $type
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereSrc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Photo extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['src', 'type', 'title'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'user_id'];

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


    /**
     * Return an url shape of src, whatever the stored one.
     * @param $value
     * @return string this->src
     */
    public function getSrcAttribute($value)
    {
        if (preg_match('#$http(s)?://#', $value)) {
            return $value;
        } else {
            return url($value);
        }
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
