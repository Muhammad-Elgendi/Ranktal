<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url'];

    /**
     * Get the url that owns the content.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','url','url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }
}
