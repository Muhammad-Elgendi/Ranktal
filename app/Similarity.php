<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Similarity extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['src_url','dest_url'];
    protected $keyType = 'string';
 

    /**
     * Get the url that owns the title.
     */
    public function url()
    {
        return $this->belongsTo('App\Url','src_url','url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }
}
