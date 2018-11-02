<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\League as League;
use App\Http\Model\Club as Club;
use App\Http\Model\Player as Player;
use App\Http\Model\ProductTag as ProductTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class LeagueController extends Controller
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
        return view('leagues.index')->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leagues.create');
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
        $request->request->add(['updated_by' => Auth::user()->id]);
        $leagues = League::create($request->all() + ['created_by' =>  Auth::user()->id]);
        \Session::flash('flash_message','You have just created new League');
        return redirect()->route("leagues.index");    
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
        $leagues = League::find($id);

        return view('leagues.edit')->with('leagues', $leagues);
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
        $league = League::find($id);
            $league->_name = $request->_name;
            $league->_desc = $request->_desc;
            $league->updated_by =  Auth::user()->id;
            $league->_active = $request->_active;
        $league->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $league->_name);
        return redirect()->route("leagues.index");        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clubs = Club::where('league_id', $id)->get();
        foreach ($clubs as $club) {
            $club_delete = $this->destroyClub($club->id);
        }

        $tags_deleted = ProductTag::where('league_id',$id)->delete();

        $league = League::find($id);
        $league->delete();
        \Session::flash('flash_message','You have just delete '. $league->_name);
    }

    public function destroyClub($id)
    {
        $players = Player::where('club_id', $id)->get();
        foreach ($players as $player) {
            $player_delete = $this->destroyPlayer($player->id);
        }

        $tags_deleted = ProductTag::where('club_id',$id)->delete();
        $club = Club::find($id);
        $club->delete();
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
                
        return Datatables::of(League::query()
            //->where('_active', '=' , $status)
            )->addIndexColumn()->make(true);
    }

    public function getClubs($id) {
        $clubs = Club::query()->where("league_id",$id)->pluck("_name","id");
        return json_encode($clubs);
    }
}
