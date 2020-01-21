<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    //
    /**
     * Get the site that owns the Metric.
     */
    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
