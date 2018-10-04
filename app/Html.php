<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Html extends Model
{

    protected $casts = [
        'header' => 'array'
    ];

    /**
     * Get the pageScraping that owns the raw Html.
     */
    public function page()
    {
        return $this->belongsTo('App\Page');
    }


}
