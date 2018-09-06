<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulkReport extends Model
{

    protected $fillable=[];


    protected $casts = [

        'arrayOfReports' => 'array'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
