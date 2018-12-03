<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\User as User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;

class UserController extends Controller
{
    //For Validation
    protected $rulesCreate = array(
            '_email'       => 'required|email|unique:cms_tm_user,_email,{$id},id,deleted_at,NULL',
            '_password'      => 'required|min:6',
            '_phone' => 'digits_between:10,16|required|numeric',
            '_fullname' => 'required'
    );

    protected $rulesEdit = array(
        '_email'       => 'required|email',
        '_password'      => 'required|min:6',
        '_phone' => 'digits_between:10,16|required|numeric',
        '_fullname' => 'required'
    );
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('users.index')->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rulesCreate);
        // store
        $user = new User();
        $user->user_level_id = "USRLVL01";
        $user->_email = $request->_email;
        $user->_password = bcrypt($request->_password);
        $user->_full_name  = $request->_fullname;
        $user->_phone = $request->_phone;
        $user->_active = $request->_active;;

        $user->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just created new user.');
        return redirect()->route("users.index");
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
         // get the nerd
        $users = User::find($id);

        // show the edit form and pass the nerd
        return view('users.edit')->with('users', $users);
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
        $this->validate($request, $this->rulesEdit);
        $user = User::find($id);
            if($user->_password != $request->_password) {
                $user->_password = bcrypt($request->_password);
            }
            $user->user_level_id = "USRLVL01";
            $user->_email = $request->_email;
            $user->_full_name  = $request->_fullname;
            $user->_phone = $request->_phone;
            $user->_active = $request->_active;
        $user->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $user->_full_name);
        return redirect()->route("users.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just delete '. $user->_full_name);
    }

    public function loadData(Request $request)
    {   

        $query = User::query()
        ->where(function($q) use ($request) {
          $q->where('_email','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('_phone','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('_full_name', 'LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('_password', 'LIKE', '%'.$request->keywordSearch.'%');
          });

        if(isset($request->status)) {
            $status = '1';
            if($request->status == 'false'){
                $status = '0';
            }
            $query = $query->where('_active', '=' , $status);
        }
                
        return Datatables::of($query
        )->addIndexColumn()->make(true);
    }

    public function resetPassword(Request $request, $id)
    {   
        $user = User::find($id);
        $user->_password = bcrypt("superstore@2018");

        $request->session()->flash('flash_message', 'Your password changes to superstore@2018');

        $user->save();
    }
}
