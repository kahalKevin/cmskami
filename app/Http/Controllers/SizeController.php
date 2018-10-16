<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Size as Size;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class SizeController extends Controller
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
        return view('sizes.index')->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sizes.create');
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
        $size = Size::create($request->all() + ['created_by' =>  Auth::user()->id, '_active' =>  '1']);
        return back()->with('success', 'You have just created new Size');
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
        $sizes = Size::find($id);

        return view('sizes.edit')->with('sizes', $sizes);
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
        $size = Size::find($id);
            $size->_name = $request->_name;
            $size->_desc = $request->_desc;
        $size->save();
        return back()->with('success', 'You have just update '. $size->_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Size::find($id);
        $size->_active = '0';
        $size->save();
    }

    public function loadData(Request $request)
    {   
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }
                
        return Datatables::of(Size::query()->where('_active', '=' , $status))->addIndexColumn()->make(true);
    }
}
