<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class optimization extends Model
{
    //
    /**
     * Get the campaign that owns the optimization of the page.
     */
    public function campaign()
    {
        return $this->belongsTo('App\campaign');
    }
}