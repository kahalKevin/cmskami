<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Club as Club;
use App\Http\Model\League as League;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class ClubController extends Controller
{
    //For Validation
    protected $rules = array(
    		'league_id' => 'required',
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
    	$leagues = League::query()->where('_active', '=' , '1')->get();
        return view('clubs.index')->with(compact('leagues', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$leagues = League::query()->where('_active', '=' , '1')->get();
        return view('clubs.create')->with(compact('leagues', 'request'));
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
        $size = Club::create($request->all() + ['created_by' =>  Auth::user()->id, '_active' =>  '1']);
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
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }
        $clubs = Club::join('cms_tm_league','cms_tm_club.league_id','cms_tm_league.id')
         ->select(
         		  'cms_tm_club.id',
                  'cms_tm_league._name AS league_name',
                  'cms_tm_club._name',
                  'cms_tm_club._desc',
                  'cms_tm_club._active'
          )->where(function($q) use ($request) {
              $q->where('cms_tm_club._name','LIKE', '%'.$request->keywordSearch.'%')
                ->orWhere('cms_tm_club._desc','LIKE', '%'.$request->keywordSearch.'%');
              })
            ->where('cms_tm_club._active', '=' , $status)
            ->where('cms_tm_club.league_id', '=' , $request->leagueId)
         ->get();
        return Datatables::of($clubs)->addIndexColumn()->make(true);
    }
}
