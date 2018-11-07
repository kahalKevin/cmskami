<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model {
	use SoftDeletes;

    protected $table = 'fe_tx_order_detail';
    protected $dates = ['delete_at'];
    
    protected $fillable = [

    ];
}