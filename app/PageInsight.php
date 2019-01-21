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
}
