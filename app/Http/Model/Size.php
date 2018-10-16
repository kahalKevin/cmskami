<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Size extends Model{	
    protected $table = 'cms_tm_size';

    public $timestamps = true;

    protected $fillable = [
    	'_name',
        '_desc',
        '_active',
        'created_by'
    ];
}