<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TermOfUse extends Model {
	
    public $timestamps = false;
    
    protected $table = 'cms_tm_fe_term_of_use';

    protected $fillable = [
        '_content',
        'created_by',
        'created_at'
    ];
}