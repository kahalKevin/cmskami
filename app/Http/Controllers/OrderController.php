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

    } 
    
    public function loadDataIncomingOrder(Request $request)
    {   
        $query = Order::query()
        ->where(function($q) use ($request) {
          $q->where('id','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('_email','LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('_receiver_name', 'LIKE', '%'.$request->keywordSearch.'%')
            ->orWhere('_receiver_phone', 'LIKE', '%'.$request->keywordSearch.'%');
          });

        if(isset($request->paymentMethod)) {
            $query = $query->where('payment_method_id', '=' , $request->paymentMethod);
        }

        if(isset($request->period)) {
            $period = explode(" - ", $request->period);
            $query = $query->where('created_at', '>=' , $period[0]);
            $query = $query->where('created_at', '<=' , $period[1]);
        }
         
        $query = $query->where('status_id', '=' , 'STATUSORDER0');
                
        return Datatables::of($query
        )->addIndexColumn()->make(true);
    }    
}
