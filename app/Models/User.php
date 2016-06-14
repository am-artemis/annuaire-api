<?php

namespace App\Models;

use App\Services\AlgoliaService;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property \Carbon\Carbon $birthday
 * @property integer $year
 * @property integer $campus_id
 * @property string $gender
 * @property string $email
 * @property string $phone
 * @property string $tags
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Campus $campus
 * @property-read \App\Models\Gadz $gadz
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Residence[] $residences
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Degree[] $degrees
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Responsibility[] $responsabilities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $jobs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Social[] $socials
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCampusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereTags($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Responsibility[] $responsibilities
 * @property-read mixed $profile
 * @property-read mixed $profile_photo
 */
class User extends ApiModel implements AuthenticatableContract
{
    use Authenticatable;
//    use AlgoliaEloquentTrait;

    public $indices;

    public $incrementing = false;
    public $timestamps = true;
    protected $table = 'users';
    protected $fillable = ['firstname', 'lastname', 'year', 'gender', 'email', 'phone', 'campus_id', 'birthday', 'tags'];
    protected $hidden = ['id', 'auth_id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at', 'birthday'];


    public function __construct()
    {
        parent::__construct();
        $this->indices = config('algolia.indices');
    }

    public static function reIndex($erase = true)
    {
        AlgoliaService::reIndexUsers($erase);
    }

    protected static function boot()
    {
        parent::boot();

        // Génération automatique d'un ID random (va avec public $incrementing = false;`)
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = str_random(6);
            }
        });

        static::saved(function (User $user) {
            AlgoliaService::pushUser($user);
        });
    }


    /**
     * Return the url to the user's profile photo. Return a default one if none is available
     *
     * @param $value
     *
     * @return string this->src
     */
    public function getProfilePhotoAttribute($value)
    {
        $photo = $this->photos()->where('type', 'profile')->orderBy('created_at', 'desc')->first();

        if ($photo) {
            return $photo->src;
        } else {
            return url('assets/link/to/default/photo.jpg');
        }
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Photo', 'user_id');
    }

    public function campus()
    {
        return $this->belongsTo('App\Models\Campus', 'campus_id');
    }

    public function gadz()
    {
        return $this->hasOne('App\Models\Gadz', 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id');
    }

    public function residences()
    {
        return $this->belongsToMany('App\Models\Residence', 'user_residence', 'user_id', 'residence_id')
            ->withPivot('id', 'room', 'from', 'to')->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course', 'user_course', 'user_id', 'course_id')
            ->withPivot('id', 'from', 'to')->withTimestamps();
    }

    public function degrees()
    {
        return $this->belongsToMany('App\Models\Degree', 'user_degree', 'user_id', 'degree_id')
            ->withPivot('year')->withTimestamps();
    }

    public function responsibilities()
    {
        return $this->hasMany('App\Models\Responsibility', 'user_id');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'user_id');
    }

    public function socials()
    {
        return $this->belongsToMany('App\Models\Social', 'user_social', 'user_id', 'social_id')
            ->withPivot('url')->withTimestamps();
    }
}
