<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageInsight extends Model
{
    protected $casts = [
        'pageInsight' => 'array',
        'optimizableResources' => 'array',
        'impactsList' => 'array',
        'problemsList' => 'array'  
    ];

    /**
     * Get the site that owns the PageInsight.
     */
    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
