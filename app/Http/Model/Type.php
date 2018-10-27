<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Type extends Model {
	
    protected $table = 'sys_type';
    
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'category_id',
        '_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}