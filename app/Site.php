<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //

    public function user()
    {
        return $this->belongsTo('App\User');
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
}
