<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

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
 * @property string $mail
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereMail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereTags($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Responsibility[] $responsibilities
 */
class User extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'year', 'gender', 'mail', 'phone', 'campus_id', 'birthday', 'tags'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id','auth_id', 'created_at', 'updated_at'];

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
    protected $dates = ['created_at', 'updated_at', 'birthday'];


    /**
     * Return the url shape of the profile picture if exists
     * @return string
     * TODO TARMAK : Refaire la fonction avec un getter (attention Foo::getProfilePicSrcAttribute => $foo->profile_pic_src)
     * TODO TARMAK "assets/link/to/default/photo.jpg" ??
     */
    public function profilePicSrc()
    {
        $photo = $this->photos()->where('type', 'profile')->orderBy('created_at', 'desc')->first();

        if ($photo) {
            return $photo->src;
        } else {
            return url('assets/link/to/default/photo.jpg');
        }
    }

    public function campus()
    {
        return $this->belongsTo('App\Models\Campus', 'campus_id');
    }


    public function gadz()
    {
        return $this->hasOne('App\Models\Gadz', 'user_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Photo', 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id');
    }

    public function residences()
    {
        return $this->belongsToMany('App\Models\Residence', 'user_residence', 'user_id', 'residence_id')
            ->withPivot('room', 'from', 'to')->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course', 'user_course', 'user_id', 'course_id')->withPivot('from', 'to')->withTimestamps();
    }

    public function degrees()
    {
        return $this->belongsToMany('App\Models\Degree', 'user_degree', 'user_id', 'degree_id')->withPivot('year')->withTimestamps();
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
        return $this->belongsToMany('App\Models\Social', 'user_social', 'user_id', 'social_id')->withPivot('url')->withTimestamps();
    }
}
