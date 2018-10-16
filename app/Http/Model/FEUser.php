<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class FEUser extends Model {

    protected $table = 'fe_tm_user';

    protected $fillable = [
        '_email',
        '_password',
        '_first_name',
        '_last_name',
        '_phone',
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
}