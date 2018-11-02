<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Club as Club;
use App\Http\Model\League as League;
use App\Http\Model\Player as Player;
use App\Http\Model\ProductTag as ProductTag;
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
        $club = Club::create($request->all() + ['created_by' =>  Auth::user()->id]);
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just created new Club.');
        return redirect()->route("clubs.index");        
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
        $clubs = Club::find($id);
		$leagues = League::query()->where('_active', '=' , '1')->get();
        return view('clubs.edit')->with(compact('leagues', 'clubs'));
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
        $club = Club::find($id);
            $club->league_id = $request->league_id;        
            $club->_name = $request->_name;
            $club->_desc = $request->_desc;
            $club->_active = $request->_active;
            $club->updated_by =  Auth::user()->id;
        $club->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $club->_name);
        return redirect()->route("clubs.index");          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $players = Player::where('club_id', $id)->get();
        foreach ($players as $player) {
            $player_delete = $this->destroyPlayer($player->id);
        }

        $tags_deleted = ProductTag::where('club_id',$id)->delete();
        $club = Club::find($id);
        $club->delete();
        \Session::flash('flash_message','You have just delete '. $club->_name);        
    }

    public function destroyPlayer($id)
    {
        $tags_deleted = ProductTag::where('player_id',$id)->delete();
        $player = Player::find($id);
        $player->delete();
    }    

    public function loadData(Request $request)
    {   
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }
        $query = Club::join('cms_tm_league','cms_tm_club.league_id','cms_tm_league.id')
         ->select(
         		  'cms_tm_club.id',
                  'cms_tm_league._name AS league_name',
                  'cms_tm_club._name',
                  'cms_tm_club._desc',
                  'cms_tm_club._active'
          )->where(function($q) use ($request) {
              $q->where('cms_tm_club._name','LIKE', '%'.$request->keywordSearch.'%')
                ->orWhere('cms_tm_club._desc','LIKE', '%'.$request->keywordSearch.'%');
              });
        if(isset($request->status)) {
            $status = '1';
            if($request->status == 'false'){
                $status = '0';
            }
            $query = $query->where('cms_tm_club._active', '=' , $status);
        }
            
        if (isset($request->leagueId))
            $query->where('cms_tm_club.league_id', '=' , $request->leagueId);
        
        return Datatables::of($query->get())->addIndexColumn()->make(true);
    }
}
