<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Sleeve extends Model{	
    protected $table = 'cms_tm_sleeve';

    public $timestamps = true;

    protected $fillable = [
    	'_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}