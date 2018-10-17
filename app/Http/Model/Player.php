<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Player extends Model {
	
    protected $table = 'cms_tm_player';

    protected $fillable = [
        'club_id',
    	'_name',
        '_number_shirt',
        '_active',
        'created_by',
        'updated_by'
    ];
}