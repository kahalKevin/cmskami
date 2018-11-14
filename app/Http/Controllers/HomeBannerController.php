<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\HomeBanner as HomeBanner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Datatables;
use Auth;

class HomebannerController extends Controller
{

    //For Validation
    protected $rules = array(
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
        return view('homebanners.index')->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('homebanners.create');
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
        if(!Storage::disk('homebanner')->put($imageId.'.'.$extension,  File::get($banner))){
            dd(false);
        }

        $homebanners = HomeBanner::create($request->all() + [
            'created_by' =>  Auth::user()->id, 
            '_image_real_name' => $imageName, 
            '_image_enc_name' => $imageId.'.'.$extension, 
            '_image_url' => '/storage/images/homebanner/'.$imageId.'.'.$extension, 
            '_position' =>  '0'
        ]);
        \Session::flash('flash_message','You have just created new Home Banner.');
        return redirect()->route('home.index');
    }

    public function loadData(Request $request)
    {
        return Datatables::of(HomeBanner::query())->addIndexColumn()->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         // get the nerd
        $homebanner = HomeBanner::find($id);

        // show the edit form and pass the nerd
        return view('homebanners.edit')->with('homebanners', $homebanner);
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
                '_upload_image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);        
        $this->validate($request, $this->rules);
        $homebanner = HomeBanner::find($id);
        $homebanner->_title = $request->_title;        
        $homebanner->_href_url = $request->_href_url;
        $homebanner->_href_open_type = $request->_href_open_type;
        $homebanner->_desc = $request->_desc;
        $homebanner->_active = $request->_active;
        $homebanner->updated_by =  Auth::user()->id;

        if($request->hasFile('_upload_image')){
            $banner = $request->file('_upload_image');
            $imageId = uniqid();
            $extension = $banner->getClientOriginalExtension();
            $imageName = $banner->getClientOriginalName();
            if(!Storage::disk('homebanner')->put($imageId.'.'.$extension,  File::get($banner))){
                dd(false);
            }
            if(file_exists(storage_path("app/public/images/homebanner/".$homebanner->_image_enc_name))){
                unlink(storage_path("app/public/images/homebanner/".$homebanner->_image_enc_name));
            }
            $homebanner->_image_real_name = $imageName;
            $homebanner->_image_enc_name = $imageId.'.'.$extension;
            $homebanner->_image_url = '/storage/images/homebanner/'.$imageId.'.'.$extension;
        }

        $homebanner->save();
        \Session::flash('flash_message','You have just update '. $homebanner->_image_real_name);
        return redirect()->route("home.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homebanner = HomeBanner::find($id);
        $homebanner->delete();
        if(file_exists(storage_path("app/public/images/homebanner/".$homebanner->_image_enc_name))){
            unlink(storage_path("app/public/images/homebanner/".$homebanner->_image_enc_name));
        }
        \Session::flash('flash_message','You have just delete '. $homebanner->_image_real_name);
    }
}
