<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model {
    use SoftDeletes;

    protected $table = 'cms_tm_club';
    protected $dates = ['delete_at'];

    protected $fillable = [
        'league_id',
    	'_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}