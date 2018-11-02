<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model {
    use SoftDeletes;    
	
    protected $table = 'cms_tm_product_stock';
    protected $dates = ['delete_at'];

    protected $fillable = [
        'product_id',
        'size_id',
    	'_stock',
        '_available',
        'created_by',
        'created_at'
    ];
}