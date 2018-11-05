<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Order as Order;
use App\Http\Model\Type as Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class OrderController extends Controller
{
    //For Validation
    protected $rules = array(

    );
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_methods = Type::where('category_id', '=', 31)->get();
        $allStatus = Type::where('category_id', '=', 33)->get();
        return view('orders.index')->with(compact('request', 'payment_methods', 'allStatus'));
    }
    
    public function incomingOrderIndex(Request $request)
    {
        $payment_methods = Type::where('category_id', '=', 31)->get();
        return view('orders.incoming-index')->with(compact('request', 'payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
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

    public function destroyClub($id)
    {

    }

    public function destroyPlayer($id)
    {

    }  

    public function loadData(Request $request)
    {   
        $query = Order::join('sys_type','fe_tx_order.status_id','sys_type.id')
            ->select(
                  'fe_tx_order.id',
                  'fe_tx_order._email',
                  'fe_tx_order._receiver_name',
                  'fe_tx_order._receiver_phone',
                  'fe_tx_order._address',
                  'fe_tx_order._grand_total',
                  'fe_tx_order.created_at',
                  'sys_type._name'
            )        
        ->where(function($q) use ($request) {
          $q->where('fe_tx_order.id','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('fe_tx_order._email','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('fe_tx_order._receiver_name', 'LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('fe_tx_order._receiver_phone', 'LIKE', '%'.$request->keywordSearch.'%');
          });

        if(isset($request->paymentMethod)) {
            $query = $query->where('fe_tx_order.payment_method_id', '=' , $request->paymentMethod);
        }

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('fe_tx_order.created_at', '>=' , $period[0]);
            $query = $query->where('fe_tx_order.created_at', '<=' , $period[1]);
        }

        if(isset($request->status)) {
            $query = $query->where('fe_tx_order.status_id', '=' , $request->status);
        }
                
        return Datatables::of($query
        )->addIndexColumn()->make(true);
    } 
    
    public function loadDataIncomingOrder(Request $request)
    {   
        $query = Order::join('sys_type','fe_tx_order.status_id','sys_type.id')
            ->select(
                  'fe_tx_order.id',
                  'fe_tx_order._email',
                  'fe_tx_order._receiver_name',
                  'fe_tx_order._receiver_phone',
                  'fe_tx_order._address',
                  'fe_tx_order._grand_total',
                  'fe_tx_order.created_at',
                  'sys_type._name'
            )        
        ->where(function($q) use ($request) {
          $q->where('fe_tx_order.id','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('fe_tx_order._email','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('fe_tx_order._receiver_name', 'LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('fe_tx_order._receiver_phone', 'LIKE', '%'.$request->keywordSearch.'%');
          });

        if(isset($request->paymentMethod)) {
            $query = $query->where('fe_tx_order.payment_method_id', '=' , $request->paymentMethod);
        }

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('fe_tx_order.created_at', '>=' , $period[0]);
            $query = $query->where('fe_tx_order.created_at', '<=' , $period[1]);
        }
         
        $query = $query->where('fe_tx_order.status_id', '=' , 'STATUSORDER0');
                
        return Datatables::of($query
        )->addIndexColumn()->make(true);
    }    
}
