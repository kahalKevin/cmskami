<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeBanner extends Model {
    use SoftDeletes;
	
    protected $table = 'cms_tm_fe_homebanner';
    protected $dates = ['delete_at'];

    protected $fillable = [
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