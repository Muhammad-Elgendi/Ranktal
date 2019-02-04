<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class CrawlingJob extends Model
{
    //   

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    // set created_at only
    public function setUpdatedAt($value){ ; }


}
