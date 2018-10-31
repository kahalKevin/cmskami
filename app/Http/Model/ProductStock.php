<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model {
	
    protected $table = 'cms_tm_product_stock';
    
    protected $fillable = [
        'product_id',
        'size_id',
    	'_stock',
        '_available',
        'created_by',
        'created_at'
    ];
}