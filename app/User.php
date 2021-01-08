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
        'name', 'email', 'password', 'company','subscribed_until'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'subscribed_until'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'limits' => 'object',
        'usage' => 'object'
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

    /**
     * Safly Get the user's image.
     *
     * @return string
     */
    public function getPhotoAttribute(){
        if(empty($this->image)){
            return '/img/user.png';
        }
        else if (file_exists( public_path() . '/img/users/' . $this->image)) {
            return '/img/users/' . $this->image;
        } else {
            return '/img/user.png';
        }
    }

    /**
     * Get the user's available credits.
     *
     * @return int
     */
    public function available_credit($credit){
        if(empty($this->usage)){
            return $this->limits->$credit - 0;
        }
        else {
            return $this->limits->$credit - $this->usage->$credit;
        }
    }

}
