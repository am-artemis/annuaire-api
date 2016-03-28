<?php

namespace App;

// Extends are done in ApiModel such as Illuminate\Database\Eloquent\Model

class Photo extends ApiModel {
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
     * TODO
     *
     * @return void
     */
    public function src()
    {
        if (preg_match('#$http(s)?://#', $this->src)) {
            return $this->src;
        } else {
            return url($this->src);
        }
    }

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
