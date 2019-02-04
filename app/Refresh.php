<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refresh extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url', 'type'];

    /**
     * Get the url that owns the Refreshes.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','url','url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }
    
}
