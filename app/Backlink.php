<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backlink extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['source_url', 'target_url','anchor_text','is_dofollow'];
    protected $casts =[
        'is_dofollow' => 'boolean'
    ];

    // set created_at only
    public function setUpdatedAt($value){ ; }
}
