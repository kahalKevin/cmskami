<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model {
	
    public $timestamps = false;
    
    protected $table = 'cms_tm_fe_privacy_policy';

    protected $fillable = [
        '_content',
        'created_by',
        'created_at'
    ];
}