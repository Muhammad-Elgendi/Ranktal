<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //

    /**
     * Get the users of the site
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get the urls for the site.
     */
    public function urls()
    {
        return $this->hasMany('App\Url');
    }

     /**
     * Get the crawlingJob for the site.
     */
    public function crawlingJob()
    {
        return $this->hasOne('App\CrawlingJob');
    }

    /**
     * Get the campaigns for the site.
     */
    public function campaigns()
    {
        return $this->hasMany('App\campaign');
    }

    /**
     * Get the metric for the site.
     */
    public function metric()
    {
        return $this->hasOne('App\Metric');
    }

    /**
     * Get the PageInsight for the site.
     */
    public function pageInsight()
    {
        return $this->hasOne('App\PageInsight');
    }
}
