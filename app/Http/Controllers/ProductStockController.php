<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\ProductStock as ProductStock;
use App\Http\Model\Product as Product;
use App\Http\Model\Size as Size;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class ProductStockController extends Controller
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
        $sizes = Size::query()->get();
        return view('product-stocks.index')->with(compact('request', 'product', 'sizes'));
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
        $product_stock = ProductStock::create([
            'created_by' =>  Auth::user()->id,
            'product_id' => $request->product_id, 
            'size_id' => $request->size_id, 
            '_available' => $request->_available
        ]);

        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just add new size');
        return redirect()->route('product-stock.index',  array('product_id'=> $request->product_id));         
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
        $tags_deleted = ProductStock::where('id',$id)->delete();
        \Session::flash('flash_message','You have just delete size');
    }

    public function loadData(Request $request)
    {   
        $query = ProductStock::join('cms_tm_size','cms_tm_product_stock.size_id','cms_tm_size.id')
         ->select(
                  'cms_tm_product_stock.id',
                  'cms_tm_size._name AS size_name',
                  'cms_tm_product_stock._available'
          )
         ->where('cms_tm_product_stock.product_id', '=' , $request->product_id);
        return Datatables::of($query->get())->addIndexColumn()->make(true);
    }
}
