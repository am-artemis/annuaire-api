<?php

namespace App;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

class Address extends ApiModel {
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
     * TODO
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
