<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTag extends Model {
    use SoftDeletes;    
	
    protected $table = 'cms_tm_product_tag';
    protected $dates = ['delete_at'];    
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'league_id',
    	'club_id',
        'player_id',
        'sleeve_id',
        'created_by',
        'created_at'
    ];
}