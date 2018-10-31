<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\ProductGallery as ProductGallery;
use App\Http\Model\Product as Product;
use App\Http\Model\Type as Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class ProductGalleryController extends Controller
{
    //For Validation
    protected $rules = array(

    );
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = Product::find($request->product_id);
        return view('product-galleries.index')->with(compact('request', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

        $image = $request->file('_upload_image');

        $imageName = $image->getClientOriginalName();
        $path = $image->store('public/images/product');
        $publicPath = \Storage::url($path);        

        $product_gallery = ProductGallery::create([
            'created_by' =>  Auth::user()->id,
            'product_id' => $request->product_id, 
            'attachment_type_id' => 'ATTACHMENT03', 
            '_name' => $request->_name,
            '_description' => $request->_desc,
            '_name' => $request->_name,
            '_real_name' => $imageName, 
            '_enc_name' => $image->hashName(), 
            '_url' => $publicPath,
            '_active' => $request->_active            
        ]);

        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just add new gallery');
        return redirect()->route('product-gallery.index',  array('product_id'=> $request->product_id));       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function loadData(Request $request)
    {   
        $query = ProductGallery::where('product_id', '=' , $request->product_id);
        return Datatables::of($query->get())->addIndexColumn()->make(true);
    }
}
