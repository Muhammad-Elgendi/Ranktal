<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url', 'title'];

    /**
     * Get the url that owns the title.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','url','url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }
}
