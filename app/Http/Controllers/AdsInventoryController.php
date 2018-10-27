<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\AdsBanner as AdsBanner;
use App\Http\Model\Type as Type;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Datatables;
use Auth;

class AdsInventoryController extends Controller
{    
    protected $rules = array(
            'banner_type_id' => 'required',
            '_start_date' => 'required',
            '_end_date' => 'required',
            '_title'         => 'required',
            '_href_url' => 'required|url',
            '_href_open_type' => 'required',
            '_desc' => 'required'
    );

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('adsbanners.index')->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner_type = Type::query()->where('category_id', 34)->get();
        return view('adsbanners.create')->with(compact('banner_type'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
                '_upload_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $this->validate($request, $this->rules);
        $banner = $request->file('_upload_image');
        $imageId = uniqid();
        $extension = $banner->getClientOriginalExtension();
        $imageName = $banner->getClientOriginalName();
        if(!Storage::disk('adsbanner')->put($imageId.'.'.$extension,  File::get($banner))){
            dd(false);
        }

        $adsbanners = AdsBanner::create($request->all() + [
            'created_by' =>  Auth::user()->id, 
            '_active' =>  '1', 
            '_image_real_name' => $imageName, 
            '_image_enc_name' => $imageId.'.'.$extension, 
            '_image_url' => '/storage/images/adsbanner/'.$imageId.'.'.$extension, 
            '_position' =>  '0'
        ]);
        \Session::flash('flash_message','You have just created new Home Banner.');
        return redirect()->route('home.index');
    }

    public function loadData(Request $request)
    {
        return Datatables::of(AdsBanner::query()->where('_active', '=' , '1'))->addIndexColumn()->make(true);
    }


            
}
