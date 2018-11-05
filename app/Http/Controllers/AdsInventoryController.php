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
            '_image_alt' => 'required',
            '_start_date' => 'required|date',
            '_end_date' => 'required|date|after_or_equal:_start_date',
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

    public function formatTimeDate($inputDate){
        // "10/28/2018 6:12 PM"
        $bySpace = explode(" ", $inputDate);
        $datePieces = explode("/", $bySpace[0]);
        $datePart = $datePieces[2]."-".$datePieces[0]."-".$datePieces[1];

        $timePieces = explode(":", $bySpace[1]);
        if($bySpace[2] == "PM"){
            $timePieces[0] += 12; 
        }
        $timePart = $timePieces[0].":".$timePieces[1].":00";
        $outputDate = $datePart." ".$timePart;
        return $outputDate;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banner_types = Type::query()->where('category_id', 34)->get();
        return view('adsbanner.index')->with(compact('banner_types', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner_types = Type::query()->where('category_id', 34)->get();
        return view('adsbanner.create')->with(compact('banner_types'));
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
                '_period' => 'required|between:41,41',
        ]);
        $dateSeparated = explode(" - ", $request->_period);
        $request->merge(['_start_date' => $dateSeparated[0]]);
        $request->merge(['_end_date' => $dateSeparated[1]]);
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
            '_image_real_name' => $imageName, 
            '_image_enc_name' => $imageId.'.'.$extension, 
            '_image_url' => '/storage/images/adsbanner/'.$imageId.'.'.$extension, 
            '_position' =>  '0'
        ]);
        \Session::flash('flash_message','You have just created new Ads/Inventory Banner.');
        return redirect()->route('adsInventory.index');
    }

    public function loadData(Request $request)
    {
         if(isset($request->_period)){
          request()->validate([
                  '_period' => 'required|between:41,41',
          ]);
          $dateSeparated = explode(" - ", $request->_period);
          $request->merge(['_start_date' => $dateSeparated[0]]);
          $request->merge(['_end_date' => $dateSeparated[1]]);
         }

        $status = '1';
        $query = AdsBanner::query()
        ->where(function($q) use ($request) {
          $q->where('_title','LIKE', '%'.$request->_title.'%')
            ->where('_href_url','LIKE', '%'.$request->_href_url.'%')
            ->where('banner_type_id', 'LIKE', '%'.$request->banner_type_id.'%');
          });

        if(isset($request->status)) {
            $status = '1';
            if($request->status == 'false'){
                $status = '0';
            }
            $query = $query->where('_active', '=' , $status);
        }

        if(isset($request->_start_date)) {
            $query = $query->where('_start_date', '>=' , $request->_start_date);
        }

        if(isset($request->_end_date)) {
            $query = $query->where('_end_date', '<=' , $request->_end_date);
        }
        return Datatables::of($query
        )->addIndexColumn()->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adsbanners = AdsBanner::find($id);
        $banner_types = Type::query()->where('category_id', 34)->get();
        $period = $adsbanners->_start_date . ' - ' . $adsbanners->_end_date;
        return view('adsbanner.edit')->with(compact('banner_types', 'adsbanners', 'period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
                '_period' => 'required|between:41,41',
        ]);
        $dateSeparated = explode(" - ", $request->_period);
        $request->merge(['_start_date' => $dateSeparated[0]]);
        $request->merge(['_end_date' => $dateSeparated[1]]);      
        request()->validate([
                '_upload_image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $this->validate($request, $this->rules);
        $adsbanner = AdsBanner::find($id);
        $adsbanner->_image_alt = $request->_image_alt;        
        $adsbanner->banner_type_id = $request->banner_type_id;
        $adsbanner->_title = $request->_title;        
        $adsbanner->_href_url = $request->_href_url;
        $adsbanner->_href_open_type = $request->_href_open_type;
        $adsbanner->_desc = $request->_desc;
        $adsbanner->_active = $request->_active;        
        $adsbanner->updated_by =  Auth::user()->id;
        $adsbanner->_start_date = $request->_start_date;
        $adsbanner->_end_date = $request->_end_date;

        if($request->hasFile('_upload_image')){
            $banner = $request->file('_upload_image');
            $imageId = uniqid();
            $extension = $banner->getClientOriginalExtension();
            $imageName = $banner->getClientOriginalName();
            if(!Storage::disk('adsbanner')->put($imageId.'.'.$extension,  File::get($banner))){
                dd(false);
            }
            unlink(storage_path("app/public/images/adsbanner/".$adsbanner->_image_enc_name));
            $adsbanner->_image_real_name = $imageName;
            $adsbanner->_image_enc_name = $imageId.'.'.$extension;
            $adsbanner->_image_url = '/storage/images/adsbanner/'.$imageId.'.'.$extension;
        }

        $adsbanner->save();
        \Session::flash('flash_message','You have just update '. $adsbanner->_image_real_name);
        return redirect()->route("adsInventory.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adsbanner = AdsBanner::find($id);
        $adsbanner->delete();
        unlink(storage_path("app/public/images/adsbanner/".$adsbanner->_image_enc_name));    
        \Session::flash('flash_message','You have just deleted '. $adsbanner->_image_real_name);
    }
}
