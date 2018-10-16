<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class League extends Model{	
    protected $table = 'cms_tm_league';

    public $timestamps = true;

    protected $fillable = [
    	'_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}