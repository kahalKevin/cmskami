<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Club extends Model {
	
    protected $table = 'cms_tm_club';

    protected $fillable = [
        'league_id',
    	'_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}