<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
	use SoftDeletes;

    protected $table = 'cms_tm_product';
    protected $dates = ['delete_at'];
    
    protected $fillable = [
        'category_id',
        'gender_allocation_id',
    	'_name',
        '_slug',
        '_meta_title',
        '_meta_desc',
        '_meta_keyword',
        '_desc',
        '_image_url',
        '_image_alt',
        '_image_real_name',
        '_image_enc_name',
        '_packaging_price',
        '_price',
        '_weight',
        '_sale_status',
        '_sale_expired_date',
        '_sale_percent',
        '_sale_price',
        '_desc_product',
        '_desc_delivery',
        '_desc_size',
        '_return_ability',
        '_desc_return',
        '_count_buy',                        
        '_active',
        'created_by',
        'updated_by'
    ];
}