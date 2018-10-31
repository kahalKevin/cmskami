<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model {
	
    protected $table = 'cms_tm_product_tag';
    
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