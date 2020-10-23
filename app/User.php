<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'subscribed_until'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


     /**
     * The sites that belong to the user
     */
    public function sites()
    {
        return $this->belongsToMany('App\Site');
    }

       /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany('App\campaign');
    }

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function miniReports()
    {
        return $this->hasMany('App\MiniReport');
    }

    public function bulkReports()
    {
        return $this->hasMany('App\BulkReport');
    }
}
