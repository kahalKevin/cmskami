<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\TermOfUse as TermOfUse;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Auth;
use Carbon;

class TermUserController extends Controller
{
    protected $rules = array(
        '_content' => 'required'
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
    public function index()
    {
        $query = TermOfUse::join('cms_tm_user','cms_tm_fe_term_of_use.created_by','cms_tm_user.id')
         ->select(
          'cms_tm_fe_term_of_use.id',
          'cms_tm_fe_term_of_use._content',
          'cms_tm_fe_term_of_use.created_by',
          'cms_tm_fe_term_of_use.created_at',
          'cms_tm_user._full_name'
        );

        $policy = $query->first();
        return view('termofuse.create')->with(compact('policy'));
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
        $mytime = Carbon\Carbon::now();
        $policy = TermOfUse::create($request->all() + [
            'created_by' =>  Auth::user()->id,
            'created_at' =>  $mytime->toDateTimeString()
        ]);
        \Session::flash('flash_message','You have just created new Term Of Use.');
        return redirect()->route('termUser.index');
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
        $mytime = Carbon\Carbon::now();
        $policy = TermOfUse::find($id);
        $policy->_content =  $request->_content;
        $policy->created_by =  Auth::user()->id;
        $policy->created_at =  $mytime->toDateTimeString();
        $policy->save();
        \Session::flash('flash_message','You have just update Term Of Use');
        return redirect()->route("termUser.index");
    }
}
