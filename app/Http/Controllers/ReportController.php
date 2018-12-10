<?php

namespace App\Http\Controllers;

use App\Http\Model\FEUser as FEUser;
use App\Http\Model\UserSubscriber as UserSubscriber; 
use App\Http\Model\TxContactUs as TxContactUs;
use App\Http\Model\Type as Type;
use App\Http\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;
use DB;

class ReportController extends Controller
{    
    public function indexSales(Request $request)
    {
        $status = Type::where('category_id', '=', 33)->get();
        $payment_method = Type::where('category_id', '=', 31)->get();

        $query = Order::leftJoin('fe_tx_order_detail','fe_tx_order.id','fe_tx_order_detail.order_id')
            ->select(
                  'fe_tx_order_detail._qty',
                  'fe_tx_order_detail.product_weight',
                  'fe_tx_order.id',
                  'fe_tx_order.row_last_modified',
                  'fe_tx_order._email',
                  'fe_tx_order._total_amount',
                  'fe_tx_order._freight_amount',
                  'fe_tx_order._grand_total'
            )
        ->where(function($q) use ($request) {
          $q->where('fe_tx_order.id','LIKE', '%'.$request->keyword.'%')
            ->orWhere('fe_tx_order._email','LIKE', '%'.$request->keyword.'%')
            ->orWhere('fe_tx_order._receiver_name', 'LIKE', '%'.$request->keyword.'%')
            ->orWhere('fe_tx_order._receiver_phone', 'LIKE', '%'.$request->keyword.'%');
          });

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('row_last_modified', '>=' , $period[0]);
            $query = $query->where('row_last_modified', '<=' , $period[1]);
        }

        if(isset($request->status)) {
            $query = $query->where('status_id', '=' , $request->status);
        }

        if(isset($request->paymentMethod)) {
            $query = $query->where('payment_method_id', '=' , $request->paymentMethod);
        }
        $result = $query->get();
        
        $item = 0;
        $weight = 0;
        $total_item_amount = 0;
        $total_weigth_amount = 0;
        $grand_total = 0;
        foreach ($result as $res) {
            $item = $item + $res->_qty;
            $weight = $weight + $res->product_weight;
            $total_item_amount = $total_item_amount + $res->_total_amount;
            $total_weigth_amount = $total_weigth_amount + $res->_freight_amount;
        }
        $grand_total = $total_item_amount + $total_weigth_amount;

        return view('reports.index-sales')->with(compact('request', 'status', 'payment_method', 'item', 'weight', 'total_item_amount', 'total_weigth_amount', 'grand_total'));
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
        $total_user_subscribe = UserSubscriber::where('_unsub_at', '=', null)->count();
        $total_user_unsubscribe = UserSubscriber::where('_unsub_at', '!=', null)->count();

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
            $query = $query->where('fe_tm_user.created_at', '>=' , $period[0]);
            $query = $query->where('fe_tm_user.created_at', '<=' , $period[1]);
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


    public function loadDataSales(Request $request)
    {   
        $query = Order::leftJoin('fe_tx_order_detail','fe_tx_order.id','fe_tx_order_detail.order_id')
            ->select(
                  'fe_tx_order_detail._qty',
                  'fe_tx_order_detail.product_weight',
                  'fe_tx_order.id',
                  'fe_tx_order.row_last_modified',
                  'fe_tx_order._email',
                  'fe_tx_order._total_amount',
                  'fe_tx_order._freight_amount',
                  'fe_tx_order._grand_total'
            )
        ->where(function($q) use ($request) {
          $q->where('fe_tx_order.id','LIKE', '%'.$request->keyword.'%')
            ->orWhere('fe_tx_order._email','LIKE', '%'.$request->keyword.'%')
            ->orWhere('fe_tx_order._receiver_name', 'LIKE', '%'.$request->keyword.'%')
            ->orWhere('fe_tx_order._receiver_phone', 'LIKE', '%'.$request->keyword.'%');
          });

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('row_last_modified', '>=' , $period[0]);
            $query = $query->where('row_last_modified', '<=' , $period[1]);
        }

        if(isset($request->status)) {
            $query = $query->where('status_id', '=' , $request->status);
        }

        if(isset($request->paymentMethod)) {
            $query = $query->where('payment_method_id', '=' , $request->paymentMethod);
        }
        return Datatables::of($query)->addIndexColumn()->make(true);
    }    

    public function loadDataSubscriber(Request $request)
    {   
        $query = UserSubscriber::query();

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('created_at', '>=' , $period[0]);
            $query = $query->where('created_at', '<=' , $period[1]);
        }

        if(isset($request->status) && $request->status != 'all') {
            if($request->status == 'subscribe'){
                $query = $query->where('_unsub_at', '=', null);
            }  else {
                $query = $query->where('_unsub_at', '!=', null);
            }
        }                          

        return Datatables::of($query)
            ->addColumn('status', function($subscribe) {
                    if ($subscribe->_unsub_at == null) {
                        return 'Subscribed';
                    } else {
                        return 'Unsubsribed';
                    }
                }
            )
            ->addIndexColumn()->make(true);
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
