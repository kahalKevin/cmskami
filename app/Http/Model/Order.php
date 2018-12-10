<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
	use SoftDeletes;

    protected $table = 'fe_tx_order';
    protected $dates = ['delete_at'];
    
    public $incrementing = false;

    protected $fillable = [
        'id',
        'cart_no',
        'guest_no',
    	'user_id',
        'user_address_id',
        '_email',
        '_address',
        '_receiver_name',
        '_receiver_phone',
        'ro_city_id',
        'ro_province_id',
        '_kota',
        '_kelurahan',
        '_kecamatan',
        '_kode_pos',
        'freight_provider_id',
        'payment_method_id',
        '_payment_at',
        '_image_bank_transfer_url',
        '_image_bank_transfer_real_name',
        '_image_bank_transfer_enc_name',
        'payment_gateway_id',
        'payment_gateway_trx_ref_no',
        'payment_gateway_callback_status',
        'payment_gateway_callback_raw',
        'payment_gateway_callback_date',
        '_total_amount',
        '_freight_amount',
        '_additional_fee',
        '_grand_total',
        'status_id',
        '_internal_note',
        '_confirm_at',
        '_shipment_date',
        'confirm_by_usercms',
        '_freight_awb_no',
        '_delivered_at',
        '_active',
        'created_by',
        'updated_by'
    ];
}