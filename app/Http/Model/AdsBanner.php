<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsBanner extends Model {
    use SoftDeletes;

    protected $table = 'cms_tm_fe_inventory_ads';
    protected $dates = ['delete_at'];

    protected $fillable = [
        'banner_type_id',
        '_image_alt',
        '_start_date',
        '_end_date',
        '_image_url',
    	'_image_real_name',
        '_image_enc_name',
        '_position',
        '_active',
        '_title',
        '_desc',
        '_href_url',
        '_href_open_type',
        '_active',
        'created_by',
        'updated_by'
    ];
}