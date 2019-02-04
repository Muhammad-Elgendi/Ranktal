<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url', 'type'];

    /**
     * Get the url that owns the Robots.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','url','url');
    }
    
    // set created_at only
    public function setUpdatedAt($value){ ; }
}
