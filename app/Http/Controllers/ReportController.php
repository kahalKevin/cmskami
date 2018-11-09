<?php

namespace App\Http\Controllers;

use App\Http\Model\FEUser as FEUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class ReportController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexRegistrant(Request $request)
    {
        $total_user = FEUser::all()->count();
        $total_user_email_verified = FEUser::where('_verified_email_at', '!=', null)->count();
        $total_user_phone_verified = FEUser::where('_verified_phone_at', '!=', null)->count();
        $total_user_not_verified = FEUser::where('_verified_phone_at', '=', null)
        ->where('_verified_email_at', '=', null)
        ->count();

        return view('reports.index-registrant')->with(compact('total_user', 'total_user_phone_verified', 'total_user_email_verified', 'total_user_not_verified' ,'request'));
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('leagues.index')->with('request', $request);
    } 

    public function loadDataRegistrant(Request $request)
    {   
        $query = FEUser::leftJoin('sys_type','fe_tm_user.gender_id','sys_type.id')
            ->select(
                  'fe_tm_user.id',
                  'fe_tm_user._email',
                  'fe_tm_user._verified_email_at',
                  'fe_tm_user._phone',
                  'fe_tm_user._verified_phone_at',
                  'fe_tm_user._first_name',
                  'fe_tm_user._last_name',
                  'sys_type._name AS gender',
                  'fe_tm_user._dob',
                  'fe_tm_user.created_at'              
            );

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('created_at', '>=' , $period[0]);
            $query = $query->where('created_at', '<=' , $period[1]);
        }

        if(isset($request->verified) && $request->verified != 'all') {
            if($request->verified == 'email'){
                $query = $query->where('_verified_email_at', '!=', null);
            } else if($request->verified == 'phone'){
                $query = $query->where('_verified_phone_at', '!=', null);
            } else {
                $query = $query->where('_verified_phone_at', '=', null);
                $query = $query->where('_verified_email_at', '=', null);
            }
        }                          

        return Datatables::of($query)->addIndexColumn()->make(true);
    }    
} 
