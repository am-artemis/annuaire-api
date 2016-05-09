<?php

namespace App\Models;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

/**
 * App\Models\Address
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $address
 * @property string $zipcode
 * @property string $city
 * @property string $country
 * @property float $lat
 * @property float $lng
 * @property string $phone
 * @property \Carbon\Carbon $from
 * @property \Carbon\Carbon $to
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereZipcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Address extends ApiModel
{
    /**
     * The table name used for the model.
     *
     * @var array
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'zipcode', 'city', 'country', 'lat', 'lng', 'phone', 'from', 'to', 'type'];

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
    protected $dates = ['created_at', 'updated_at', 'from', 'to'];

    /**
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
