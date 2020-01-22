<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class CrawlingJob extends Model
{
    protected $dates = [
        'created_at'
    ];

    const UPDATED_AT = null;

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    // disable updated_at
    public function setUpdatedAt($value){
        ;
    }

}
