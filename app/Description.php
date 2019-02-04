<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url'];

    /**
     * Get the url that owns the description.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','url','url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }
}
