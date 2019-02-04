<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['url'];
    protected $keyType = 'string';

    /**
     * Get the titles for the url.
     */
    public function titles()
    {
        return $this->hasMany('App\Title','url','url');
    }

    /**
     * Get the redirect for the url.
     */
    public function redirect()
    {
        return $this->hasOne('App\Redirect','url','url');
    }

    /**
     * Get the robots for the url.
     */
    public function robots()
    {
        return $this->hasMany('App\Robot','url','url');
    }

    /**
     * Get the refreshes for the url.
     */
    public function refreshes()
    {
        return $this->hasMany('App\Refresh','url','url');
    }

    /**
     * Get the description for the url.
     */
    public function description()
    {
        return $this->hasOne('App\Description','url','url');
    }

    /**
     * Get the content for the url.
     */
    public function content()
    {
        return $this->hasOne('App\Content','url','url');
    }

    /**
     * Get the site that owns the url.
     */
    public function site()
    {
        return $this->belongsTo('App\Site');
    }


    /**
     * Get the similarities for the url.
     */
    public function similarities()
    {
        return $this->hasMany('App\Similarity','url','src_url');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }

}
