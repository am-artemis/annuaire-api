<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Photo
 *
 * @property integer $id
 * @property string $user_id
 * @property string $src
 * @property string $type
 * @property string $title
 * @property string $cloudinary_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereSrc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereCloudinaryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Photo extends ApiModel
{

    const PROFILE_DEFAULT = 'link/to/default';
    public $timestamps = true;
    protected $table = 'photos';
    protected $fillable = ['src', 'type', 'title'];
    protected $hidden = ['id', 'user_id', 'cloudinary_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function getSrcAttribute($value)
    {
        return url($value);
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
