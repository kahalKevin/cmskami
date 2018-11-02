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

class PlayerController extends Controller
{
    //For Validation
    protected $rules = array(
            'club_id'       => 'required',
            '_name'         => 'required',
            '_number_shirt' => 'required'
    );
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $leagues = League::query()->where('_active', '=' , '1')->get(); 
        if(isset($request->league_id))
        $clubs = Club::query()->where('league_id', '=' , $request->league_id)->get();       
        return view('players.index')->with(compact('leagues', 'request', 'clubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leagues = League::query()->where('_active', '=' , '1')->get();
        return view('players.create')->with(compact('leagues', 'request'));
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
        $player = Player::create($request->all() + ['created_by' =>  Auth::user()->id]);
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just created new Player.');
        return redirect()->route("players.index");        
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
        $players = Player::find($id);
        $club_tmp = Club::query()->where('id', '=' , $players->club_id)->first();
        $league_id = $club_tmp->league_id;
        $leagues = League::query()->where('_active', '=' , '1')->get();
        $clubs = Club::query()->where('league_id', '=' , $league_id)->get();
        return view('players.edit')->with(compact('leagues', 'clubs', 'players', 'league_id'));
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
        $player = Player::find($id);
            $player->club_id = $request->club_id;        
            $player->_name = $request->_name;
            $player->_number_shirt = $request->_number_shirt;
            $player->_active = $request->_active;
            $player->updated_by =  Auth::user()->id;
        $player->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $player->_name);
        return redirect()->route("players.index");             
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tags_deleted = ProductTag::where('player_id',$id)->delete();
        $player = Player::find($id);
        $player->delete();
        \Session::flash('flash_message','You have just deleted '. $player->_name);
    }

    public function loadData(Request $request)
    {   
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }
        $query = Player::join('cms_tm_club','cms_tm_player.club_id','cms_tm_club.id')
         ->join('cms_tm_league','cms_tm_club.league_id','cms_tm_league.id')
         ->select(
                  'cms_tm_player.id',
                  'cms_tm_club._name AS club_name',
                  'cms_tm_league._name AS league_name',
                  'cms_tm_player._name',
                  'cms_tm_player._number_shirt',
                  'cms_tm_player._active'
          )->where(function($q) use ($request) {
              $q->where('cms_tm_player._name','LIKE', '%'.$request->keywordSearch.'%')
                ->orWhere('cms_tm_player._number_shirt','LIKE', '%'.$request->keywordSearch.'%');
              });
            
            if(isset($request->status)) {
                $status = '1';
                if($request->status == 'false'){
                    $status = '0';
                }
                $query = $query->where('cms_tm_player._active', '=' , $status);
            }
            
            if (isset($request->leagueId))
                $query->where('cms_tm_club.league_id', '=' , $request->leagueId);
            if (isset($request->clubId))
                $query->where('cms_tm_player.club_id', '=' , $request->clubId);
        return Datatables::of($query->get())->addIndexColumn()->make(true);
    }
}
