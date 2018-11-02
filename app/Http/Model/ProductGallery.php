<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model {
    use SoftDeletes;    
	
    protected $table = 'cms_tm_product_attachment';
    protected $dates = ['delete_at'];

    protected $fillable = [
        'product_id',
        'attachment_type_id',
    	'_name',
        '_description',
        '_position',
        '_value',       
        '_url',
        '_real_name',
        '_enc_name',
        '_active',                
        'created_by',
        'created_at'
    ];
}