<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sleeve extends Model{
	use SoftDeletes;

    protected $table = 'cms_tm_sleeve';
    protected $dates = ['delete_at'];

    public $timestamps = true;

    protected $fillable = [
    	'_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}