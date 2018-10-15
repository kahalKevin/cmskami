<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;
	
    protected $table = 'cms_tm_user';

    public $timestamps = true;

    protected $sluggable = [
        'build_from' => 'username'
    ];

    protected $urlKey = 'slug';

    protected $fillable = [
    	'user_level_id',
        '_email',
        '_password',
        '_password_expired',
        '_full_name',
        '_initial_name',
        '_phone',
        '_address',
        '_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        '_password',
    ];

    public function getAuthPassword()
    {
        return $this->_password;
    }

    public function getRememberTokenName()
    {
        return "_remember_token";
    }    
}