<?php

namespace App\Http\Controllers;

use App\Http\Model\FEUser as FEUser;
use App\Http\Model\UserSubscriber as UserSubscriber; 
use App\Http\Model\TxContactUs as TxContactUs;
use App\Http\Model\Type as Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class ReportController extends Controller
{    
    public function indexSales(Request $request)
    {
        $status = Type::where('category_id', '=', 33)->get();
        $payment_method = Type::where('category_id', '=', 31)->get();
        return view('reports.index-sales')->with(compact('request', 'status', 'payment_method'));
    }

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

    public function indexSubscriber(Request $request)
    {
        $total_user_subscribe = UserSubscriber::where('_unsub_at', '!=', null)->count();
        $total_user_unsubscribe = UserSubscriber::where('_unsub_at', '=', null)->count();

        return view('reports.index-subscriber')->with(compact('total_user_subscribe', 'total_user_unsubscribe', 'request'));
    } 

    
    public function indexContactUs(Request $request)
    {
        $total = TxContactUs::all()->count();

        return view('reports.index-contact-us')->with(compact('total', 'request'));
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

    public function loadDataSubscriber(Request $request)
    {   
        $query = UserSubscriber::query();

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('create_date', '>=' , $period[0]);
            $query = $query->where('create_date', '<=' , $period[1]);
        }

        if(isset($request->status) && $request->status != 'all') {
            if($request->status == 'subscribe'){
                $query = $query->where('_unsub_at', '=', null);
            }  else {
                $query = $query->where('_unsub_at', '!=', null);
            }
        }                          

        return Datatables::of($query)->addIndexColumn()->make(true);
    } 

    public function loadDataContactUs(Request $request)
    {   
        $query = TxContactUs::query();

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('created_at', '>=' , $period[0]);
            $query = $query->where('created_at', '<=' , $period[1]);
        }

        return Datatables::of($query)->addIndexColumn()->make(true);
    }    
} 
