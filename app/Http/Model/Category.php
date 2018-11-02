<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use SoftDeletes;

    protected $table = 'cms_tm_category';
    protected $dates = ['delete_at'];

    protected $fillable = [
        'parent_category_id',
        'gender_allocation_id',
    	'_name',
        '_slug',
        '_desc',
        '_image_url',
        '_image_alt',
        '_image_real_name',
        '_image_enc_name',
        '_meta_title',
        '_meta_desc',
        '_meta_keyword',        
        '_active',
        'created_by',
        'updated_by'
    ];
}