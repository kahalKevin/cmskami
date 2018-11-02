<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Sleeve as Sleeve;
use App\Http\Model\ProductTag as ProductTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class SleeveController extends Controller
{
    //For Validation
    protected $rules = array(
            '_name'       => 'required',
            '_desc'      => 'required'
    );
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('sleeves.index')->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sleeves.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $sleeve = Sleeve::create($request->all() + ['created_by' =>  Auth::user()->id]);
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just created new Sleeve.');
        return redirect()->route("sleeves.index");        
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
        $sleeves = Sleeve::find($id);

        return view('sleeves.edit')->with('sleeves', $sleeves);
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
        $this->validate($request, $this->rules);
        $sleeve = Sleeve::find($id);
            $sleeve->_name = $request->_name;
            $sleeve->_desc = $request->_desc;
            $sleeve->_active = $request->_active;
        $sleeve->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $sleeve->_name);
        return redirect()->route("sleeves.index");              
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tags_deleted = ProductTag::where('sleeve_id',$id)->delete();
        $sleeve = Sleeve::find($id);
        $sleeve->delete();
        \Session::flash('flash_message','You have just delete '. $sleeve->_name);
    }

    public function loadData(Request $request)
    {   
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }
                
        return Datatables::of(Sleeve::query()
            //->where('_active', '=' , $status)
            )->addIndexColumn()->make(true);
    }
}
