<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

use Cart;
use Auth;
use Konekt\PdfInvoice\InvoicePrinter;
use stdClass;

class DuesalesController extends Controller
{
    public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	    $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	    $role = $Sessionuser->role;

	    if ($role == 3) {
	    	if ($request->ajax()) {
		$data = DB::table('approvedsales')
		    	->join('customers','approvedsales.id_customer','customers.id')
		    	->select('customers.c_name','customers.c_code','approvedsales.*')
				->where('amount_due','>',0)
		    	->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-info btn-sm" id="print-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i></a>
		<a class="btn btn-warning btn-sm" id="edit-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<a class="btn btn-danger btn-sm" id="edit-due" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-cut"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		';

		// <a id="delete-as" data-id='.$row->id.' class="btn btn-danger delete-as btn-sm"><i class="fas fa-trash"></i></a>

		$action = 
				'<div class="btn-group">
				  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fas fa-cogs"></i>
				  </button>
				  <div class="dropdown-menu dropdown-menu-right">
				    <a class="btn btn-info btn-sm dropdown-item" id="print-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Print Invoice</a>
				    <a class="btn btn-warning btn-sm dropdown-item" id="edit-as-payment" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen"></i> Edit Payment Info</a>
					<meta name="csrf-token" content="{{ csrf_token() }}">
				  </div>
				</div>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}
	    }
	    else{
    	if ($request->ajax()) {
		$data = DB::table('approvedsales')
		    	->join('customers','approvedsales.id_customer','customers.id')
		    	->select('customers.c_name','customers.c_code','approvedsales.*')
				->where('amount_due','>',0)
		    	->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-info btn-sm" id="print-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i></a>
		<a class="btn btn-warning btn-sm" id="edit-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<a class="btn btn-danger btn-sm" id="edit-due" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-cut"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		';

		// <a id="delete-as" data-id='.$row->id.' class="btn btn-danger delete-as btn-sm"><i class="fas fa-trash"></i></a>

		$action = 
				'<div class="btn-group">
				  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fas fa-cogs"></i>
				  </button>
				  <div class="dropdown-menu dropdown-menu-right">
				    <a class="btn btn-info btn-sm dropdown-item" id="print-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Print Invoice</a>
					<a class="btn btn-warning btn-sm dropdown-item" id="edit-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i> Edit Sell Info</a>
					<a class="btn btn-warning btn-sm dropdown-item" id="edit-as-payment" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen"></i> Edit Payment Info</a>
					<a class="btn btn-danger btn-sm dropdown-item" id="edit-due" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-cut"></i> Edit Invoice</a>
					<meta name="csrf-token" content="{{ csrf_token() }}">
				  </div>
				</div>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}
	}
		return view('inventory.duesales');
    }

    public function clearCart()
	{
		Cart::destroy();
    	return redirect()->route('due_sales');
	}

    public function EditDue(Request $request)
	{
		Cart::destroy();
		$saleId = $request->id;
		$salestoapprove = DB::table('approvedsales')->where('id',$saleId)->first();
		$costomerid = $salestoapprove->id_customer;

		$productlist = json_decode($salestoapprove->products);

		// echo "<pre>";
		// print_r($productlist);
		// exit();

		foreach ($productlist as $pro=>$value) {
			$data = array();
	        $data['id'] =$value->id;
	        $data['name'] =$value->name;
	        $data['qty'] =$value->qty;
	        $data['price'] =$value->price;
	        $data['weight'] =1;

	 //        echo "<pre>";
		// print_r($data);
	        $add = Cart::add($data);
		}
		// exit();



		return view('inventory.editdue',compact('costomerid','salestoapprove'));
	}



	public function UpdateDue(Request $request,$rowId)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();
		$totalProduct = DB::table('products')->where('id',$request->idProduct)->first();

    	if ($totalProduct->p_total < $request->qty) {
	    		$notification=array(
	            'message'=>'Product Quantity is Higher Than Stock',
	            'alert-type'=>'error'
	        );
	        return Redirect()->back()->with($notification);
    	}

        $up=$request->qty;

	    $update=Cart::update($rowId, $up);

        if ($update)
        {
            $saleId = $request->bill_code;
			$salestoapprove = DB::table('approvedsales')->where('bill_code',$saleId)->first();
			$costomerid = $request->customer_id;



            $notification=array(
                'message'=>'Product Update To Cart',
                'alert-type'=>'success'
            );
            // return Redirect()->back()->with($notification);

            return view('inventory.editdue',compact('costomerid','salestoapprove'))->with($notification);


        }else{
            $saleId = $request->bill_code;
			$salestoapprove = DB::table('approvedsales')->where('bill_code',$saleId)->first();
			$costomerid = $request->customer_id;



            $notification=array(
                'message'=>'Something went Wrong',
                'alert-type'=>'error'
            );
            // return Redirect()->back()->with($notification);

            return view('inventory.editdue',compact('costomerid','salestoapprove'))->with($notification);
        } 
	}


	public function ApproveEdit(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();

		$saleId = $request->sale_id;
		$salestoapprove = DB::table('approvedsales')->where('id',$saleId)->first();

		$productlist = Cart::content();

		// echo "<pre>";
		// print_r($productlist);
		// exit();

		//calculating profits-----------------------------------------------------------
		

		$profitJson=array();
    	$profitObj = new stdClass();

    	$profit_total = 0;

    	$newTotal=0;

    	foreach ($productlist as $por_p) {
    		$temp_product = DB::table('products')->where('id',$por_p->id)->first();

    		// $sellPrice = self::Calculateprice($por_p->price,$request->sta_percentage);



    		$profit_single = $por_p->price - $temp_product->p_buy;
    		$p_total = 0;
    		if ($profit_single >=0) {
    			$p_total = $por_p->qty*$profit_single;
    		}
    		
    		$newTotal = $newTotal+($por_p->qty*$por_p->price);

    		$profitObj->id = $por_p->id;
    		$profitObj->quantity = $por_p->qty;
    		$profitObj->p_buy = $temp_product->p_buy;
    		$profitObj->selling_price = $por_p->price;
    		$profitObj->profit_total = $p_total;

    		$myJSON = json_encode($profitObj);

    		array_push($profitJson, $myJSON);

    		$profit_total = $profit_total + $p_total;
        
    	}

    	$proJson = json_encode($profitJson);
    	$profit_data = array();
    	$profit_data['p_bill_code'] = $salestoapprove->bill_code;
    	$profit_data['p_data'] = $proJson;
    	$profit_data['p_total'] = $profit_total;

  //   	echo "<pre>";
		// print_r($profit_data);
		// exit();


    	$StockAdjust=DB::table('profits')->where('p_bill_code',$salestoapprove->bill_code)->update($profit_data);
		//calculating profits-----------------------------------------------------------

		//approve sale ------------------------------------------------------------------------

    		$newdue =$newTotal-$request->amount_paid;

    		$amountPaid = $request->amount_paid;
    		if ($request->amount_paid > $newTotal) {
    			$newdue = 0;
    		}

    		if ($amountPaid>$newTotal) {
    			$amountPaid = $newTotal;
    		}

    		$dataSales=array();
			$dataSales['products']=$productlist;
	        $dataSales['bill_code']=$salestoapprove->bill_code;
	        $dataSales['id_customer']=$salestoapprove->id_customer;
	        $dataSales['id_seller']=$salestoapprove->id_seller;
	        $dataSales['net_price']=$newTotal;
	        $dataSales['total_price']=$newTotal;
	        $dataSales['payment_method']=$salestoapprove->payment_method;
	        $dataSales['amount_paid']=$amountPaid;
	        $dataSales['amount_due']=$newdue;

	        $dataSales['profit_percentage']=0;
	        $dataSales['profits']=$profit_total;

	  //       echo "<pre>";
			// print_r($dataSales);
			// exit();

	        $ApproveSale=DB::table('approvedsales')->where('bill_code',$salestoapprove->bill_code)->update($dataSales);
	        
	        if ($ApproveSale) {
	        	// $dltSalestoapprove = DB::table('salestoapprove')->where('id',$saleId)->delete();

	    //     	if ($dltSalestoapprove) {
	    //     		$notification=array(
		 		// 	'message'=>'Sales Updated Successfully',
		 		// 	'alert-type'=>'success'
		 		// );
	        	Cart::destroy();
		 		return Redirect()->route('due_sales');

		 	}else{
		 		$notification=array(
		 			'message'=>'Something Went Wrong',
		 			'alert-type'=>'error'
		 		);
		 		Cart::destroy();
		 		return Redirect()->route('due_sales');
		 	
	        	}
	        
    	//approve sale ------------------------------------------------------------------------
	}

    //-------------------------------------------------------------------------------------------------
}
