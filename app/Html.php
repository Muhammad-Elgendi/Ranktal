<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Html extends Model
{

    public $incrementing = false;
    protected $primaryKey = 'page_id';
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
