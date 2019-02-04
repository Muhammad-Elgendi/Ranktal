<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url'];

    /**
     * Get the url that owns the Redirect.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','url','url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }
    
}
