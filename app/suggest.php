<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suggest extends Model
{
    //
    public $incrementing = false;
    protected $primaryKey = ['keyword', 'source'];
}
