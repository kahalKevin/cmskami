<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model {
    use SoftDeletes;    
	
    protected $table = 'cms_tm_player';
    protected $dates = ['delete_at'];

    protected $fillable = [
        'club_id',
    	'_name',
        '_number_shirt',
        '_active',
        'created_by',
        'updated_by'
    ];
}