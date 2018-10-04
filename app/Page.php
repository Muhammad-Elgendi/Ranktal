<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $casts = [
        'parsedUrl' => 'array',
        'isMultiTitle' => 'boolean',
        'isMultiDescription' => 'boolean',   
        'h1' => 'array',
        'h2' => 'array',
        'h3' => 'array',
        'h4' => 'array',
        'h5' => 'array',
        'h6' => 'array',
        'alt' => 'array',
        'emptyAlt' => 'array',
        'openGraph' => 'array',
        'twitterCard' => 'array',
        'bItems' => 'array',
        'iItems' => 'array',
        'emItems' => 'array',
        'strongItems' => 'array',
        'markItems' => 'array',
        'isFlashExist' => 'boolean',
        'links' => 'array',
        'isAllowedFromRobots' => 'boolean'
    ];

    /**
     * Get the raw html record associated with the page.
     */
    public function html()
    {
        return $this->hasOne('App\Html');
    }
}
