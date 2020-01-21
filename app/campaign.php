<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campaign extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function optimization()
    {
        return $this->hasMany('App\optimization');
    }
    
    /**
     * Get the site of the campaign
     */
    public function site()
    {
        return $this->belongsTo('App\Site');
    }

}
