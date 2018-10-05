<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backlink extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['source_url', 'target_url','anchor_text','isDoFollow'];
    protected $casts =[
        'isDoFollow' => 'boolean'
    ];
}
