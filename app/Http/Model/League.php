<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;

class League extends Model{	
	use SoftDeletes;

    protected $table = 'cms_tm_league';
    protected $dates = ['delete_at'];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);
    }

    protected $fillable = [
    	'_name',
        '_desc',
        '_active',
        'created_by',
        'updated_by'
    ];
}