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

class ApprovedQuotationController extends Controller
{
	public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	    $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	    $role = $Sessionuser->role;

	    if ($role == 3) {
	    	if ($request->ajax()) {
		$data = $data = DB::table('approvedadvancedsales')
		    	->join('customers','approvedadvancedsales.id_customer','customers.id')
		    	->select('customers.c_name','customers.c_code','approvedadvancedsales.*')
		    	->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		

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
		$data = $data = DB::table('approvedquotation')
		    	->join('customers','approvedquotation.id_customer','customers.id')
		    	->select('customers.c_name','customers.c_code','approvedquotation.*')
		    	->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		

		$action = 
				'<div class="btn-group">
				  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fas fa-cogs"></i>
				  </button>
				  <div class="dropdown-menu dropdown-menu-right">
				    <a class="btn btn-info btn-sm dropdown-item" id="print-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Print Invoice</a>
					<a class="btn btn-warning btn-sm dropdown-item" id="edit-as" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i> Edit Sell Info</a>
					<a class="btn btn-warning btn-sm dropdown-item" id="edit-as-payment" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen"></i> Edit Payment Info</a>
					<meta name="csrf-token" content="{{ csrf_token() }}">
					<a id="delete-as" data-id='.$row->id.' class="btn btn-danger delete-as btn-sm dropdown-item"><i class="fas fa-trash"></i> Delete</a>
				  </div>
				</div>';

		

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}
	}
		return view('inventory.approvedQuotation');
    }

     public function edit($id)
	{
		$where = array('id' => $id);
		$product = DB::table('approvedquotation')->where($where)->first();
		return Response::json($product);
	}

	public function updateAS(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

    	if ($request->amount_paying < 0) {
    		$notification=array(
	 			'message'=>'Paying Amount is Less Than Zero',
	 			'alert-type'=>'warning'
	 		);
	 		return Redirect()->back()->with($notification);
    	}

    	$product = DB::table('approvedquotation')->where('id',$request->id)->first();

    	$temppaid = $product->amount_paid+$request->amount_paying;
    	$tempdue = $product->amount_due-$request->amount_paying;

    	$newpaid = 0;
    	if ($temppaid>$product->total_price) {
    		$newpaid = $product->total_price;
    	}
    	else{
    		$newpaid = $temppaid;
    	}

    	$newdue = 0;
    	if ($tempdue < 0) {
    		$newdue = 0;
    	}
    	else{
    		$newdue = $tempdue;
    	}

    	$data = array();
    	$data['products'] = $product->products;
    	$data['bill_code'] = $product->bill_code;
    	$data['id_customer'] = $product->id_customer;
    	$data['id_seller'] = $product->id_seller;
    	$data['net_price'] = $product->net_price;
    	$data['vat_percent'] = $product->vat_percent;
    	$data['total_vat'] = $product->total_vat;
    	$data['total_price'] = $product->total_price;
    	$data['payment_method'] = $product->payment_method;
    	$data['payment_description'] = $product->payment_description;
    	$data['amount_paid'] = $newpaid;
    	$data['amount_due'] = $newdue;
    	$data['profit_percentage'] = $product->profit_percentage;
    	$data['profits'] = $product->profits;

    	$sale = DB::table('approvedquotation')->where('id',$request->id)->update($data);

    	if ($sale) {
    		$notification=array(
	 			'message'=>'Quotation Update Successfully',
	 			'alert-type'=>'success'
	 		);
	 		return Redirect()->back()->with($notification);
    	}
    	else{
    		$notification=array(
	 			'message'=>'Something Went Wrong',
	 			'alert-type'=>'error'
	 		);
	 		return Redirect()->back()->with($notification);
    	}


    }

    public function updateADASPayment(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

    	$product = DB::table('approvedquotation')->where('id',$request->id)->first();
    	// Payment Details-----------------------------------------------------------


            $Cash = " ";
            $Card = " ";
            $Cheque = " ";
            $phoneNo = " ";

            if ($request->cash_description != null) {
                $Cash = $request->cash_description;
            } 
            if ($request->card_description != null) {
                $Card = $request->card_description;
            } 
            if ($request->cheque_description != null) {
                $Cheque = $request->cheque_description;
            }
            
            $contacArray = [$Cash,$Card,$Cheque];
            $paymentDescription = json_encode($contacArray);

            //Payment Details-----------------------------------------------------------
        $data = array();
    	$data['products'] = $product->products;
    	$data['bill_code'] = $product->bill_code;
    	$data['id_customer'] = $product->id_customer;
    	$data['id_seller'] = $product->id_seller;
    	$data['net_price'] = $product->net_price;
    	$data['vat_percent'] = $product->vat_percent;
    	$data['total_vat'] = $product->total_vat;
    	$data['total_price'] = $product->total_price;
    	$data['payment_method'] = $product->payment_method;
    	$data['payment_description'] = $paymentDescription;
    	$data['amount_paid'] = $product->amount_paid;
    	$data['amount_due'] = $product->amount_due;
    	$data['profit_percentage'] = $product->profit_percentage;
    	$data['profits'] = $product->profits;

    	$sale = DB::table('approvedquotation')->where('id',$request->id)->update($data);

    	if ($sale) {
    		$notification=array(
	 			'message'=>'Payment Details Update Successfully',
	 			'alert-type'=>'success'
	 		);
	 		return Redirect()->back()->with($notification);
    	}
    	else{
    		$notification=array(
	 			'message'=>'Something Went Wrong',
	 			'alert-type'=>'error'
	 		);
	 		return Redirect()->back()->with($notification);
    	}

    }

     public function print(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();

		$information =DB::table('approvedquotation')->where('id',$request->id)->first();

        $content=json_decode($information->products);

        $saleDate = substr($information->created_at,0,10);
      	$saleTime = substr($information->created_at,11,18);

        $customer_id = $information->id_customer;

	    $customer = DB::table('customers')->where('id',$customer_id)->first();

	      $size = 'A4';
          $currency = 'Tk '; 
          $language = 'en';

          $invoice = new InvoicePrinter($size,$currency,$language);

		  /* Header settings */
		  $invoice->setLogo("public/images/default/ProPic.jpg");   //logo image path
		  $invoice->setAddress($request->company_name);
		  $invoice->setCustomer($customer->c_code);
		  $invoice->setColor("#007fff");      // pdf color scheme
		  $invoice->setType("Quotation");    // Invoice Type
		  $invoice->setReference($information->bill_code);   // Reference
		  $invoice->setDate("    ".$saleDate);   //Billing Date
		  $invoice->setTime($saleTime);   //Billing Time
		  // $invoice->setDue(date('M dS ,Y',strtotime('+3 months')));    // Due Date
		  // $invoice->setFrom(array("Seller Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));

		  // $employeeName = " ";
    //       $employeeCode = " ";

		  // if ($request->employees_id !=null) {
		  // 	// $employee = $request->employees_id;
		  // 	$employee = explode(':', $request->employees_id);

    //     	$employeeID = $employee[0];
    //     	$employeeName = $employee[1];
    //     	$employeeCode = $employee[2];
		  // }

		  // $invoice->setFrom(array("$employeeName","$employeeCode",));

		  $Sessionid=Auth::id();
    	  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

		  $invoice->setFrom(array("$Sessionuser->name","$Sessionuser->code",));
		  
		  // $invoice->setFrom(array("$getseller->name","Demo Pos Makers","$getseller->email"));
		  
		  $datacon = json_decode($customer->c_contact);

		  $c_contact = $datacon[0]." ".$datacon[1]." ".$datacon[2]." ".$datacon[3];

		  $lineOne = "";
    	$lineTwo = "";
    	$lineThree = "";
    	$phoneNo = "";

    	$cInfoArray=array($customer->c_name,"Customer Code: ".$customer->c_code);
    	// echo "<pre>";
    	// print_r($cInfoArray);
    	// exit();

    	if ($datacon[0] != " ") {
    		// $cInfoArray[0] = $datacon[0];
    		array_push($cInfoArray, $datacon[0]);
    	} 
    	if ($datacon[1] != " ") {
    		array_push($cInfoArray, $datacon[1]);
    	} 
    	if ($datacon[2] != " ") {
    		array_push($cInfoArray, $datacon[2]);
    	} 
    	if ($datacon[3] != " ") {
    		array_push($cInfoArray, "Contact NO: ". $datacon[3]);
    	} 

    	// $cInfoArray=array();

		  // $invoice->setTo(array("$customer->c_name","$customer->c_contact","",""));
		  $invoice->setTo($cInfoArray);

		  $totalSellDiscount = 0;
		  $totalWithoutDiscount = 0;

		  foreach ($content as $item ) {

		  	$totalSellDiscount = $totalSellDiscount+($item->weight*$item->qty);

		  	$Description = DB::table('products')->where('id',$item->id)->first();

		  	$sellPrice = self::Calculateprice($item->price,$information->profit_percentage);

		  	$totalWithoutDiscount = $totalWithoutDiscount+(($sellPrice+$item->weight)*$item->qty);

		  	$invoice->addItem("$item->name",$Description->p_description,$item->qty,false,$sellPrice+$item->weight,false,($sellPrice+$item->weight)*$item->qty);
		  }



		  $amountDue = $information->amount_due;
		  $invoice->addTotal("Total",$totalWithoutDiscount);
		  $invoice->addTotal("VAT $information->vat_percent %",$information->total_vat);
		  $invoice->addTotal("Discount Earned",$totalSellDiscount);
		  $invoice->addTotal("Total Payable",$information->total_price,true);
		  $invoice->addTotal("Paid",$information->amount_paid);
		  $invoice->addTotal("Due",$amountDue);
		  
		  //payment details -------------------------------------------------------------

		  $PaymentDetails = json_decode($information->payment_description);

		  $invoice->addTitle("Payment Details");
		  
		  $invoice->addParagraph("Cash: $PaymentDetails[0]. \nCard: $PaymentDetails[1]. \nCheque: $PaymentDetails[2]");


		  //payment details -------------------------------------------------------------
		  
		  $invoice->addTitle("Return & Replacement Policies :");
		  
		  $invoice->addParagraph("Please, the invoice must be with you. The products are not to be returned unless it is to be submitted as to replace with another product(s) ; which must be submitted within 30-days of the product(s) selling date ; if the products are not ; installed, broken, burned, stained as usual with hologram sticker.  ");
		  
		  $invoice->setFooternote("Developed by Mackasoft");
		  
		  $invoice->render('example1.pdf','I'); 
		  /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */



		  // Cart::destroy();
    // 	  return redirect()->route('pos-page');
        //Printing Bill-----------------------------------------------------------------

	}

	public function destroy($id)
	{
		$pr = DB::table('approvedquotation')->where('id',$id)->delete();
		return Response::json($product);
	}
    //--------------------------------------------------------------------------------------
    public function Calculateprice($price,$percent)
	{

		$total = 0;
		if ($percent<=0) {
			$total = $price;
		}
		else{
			$total = $price+(($price / 100)*$percent);
		}
		// echo "<pre>";
		// print_r($total);
		// exit();
		return $total;

	}
}
