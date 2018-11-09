<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FEUser extends Model {
    use SoftDeletes;    
	
    protected $table = 'fe_tm_user';
    protected $dates = ['delete_at'];

    protected $fillable = [
    ];
}