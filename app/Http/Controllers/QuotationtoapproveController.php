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

class QuotationtoapproveController extends Controller
{
	public function index(Request $request)
    {

		if ($request->ajax()) {
		$data = DB::table('quotation')
		    	->join('customers','quotation.id_customer','customers.id')
		    	->select('customers.c_name','customers.c_code','quotation.*')
		    	->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		// $action = '<a class="btn btn-info btn-sm" id="print-st" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i></a>
		// <a class="btn btn-success btn-sm" id="approve-sta" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-check"></i></a>
		// <meta name="csrf-token" content="{{ csrf_token() }}">
		// <a id="delete-st" data-id='.$row->id.' class="btn btn-danger delete-st btn-sm"><i class="fas fa-trash"></i></a>';


		$action = 
				'<div class="btn-group">
				  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fas fa-cogs"></i>
				  </button>
				  <div class="dropdown-menu dropdown-menu-right">
				    <a class="btn btn-info btn-sm dropdown-item" id="print-st" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Print Invoice</a>
					<a class="btn btn-success btn-sm dropdown-item" id="approve-sta" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-check"></i> Give Approval</a>
					<meta name="csrf-token" content="{{ csrf_token() }}">
					<a id="delete-st" data-id='.$row->id.' class="btn btn-danger delete-st btn-sm dropdown-item"><i class="fas fa-trash"></i> Delete</a>
				  </div>
				</div>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('inventory.quotationToApprove');
    }

    public function edit($id)
	{
		$where = array('id' => $id);
		$product = DB::table('quotation')->where($where)->first();
		return Response::json($product);
	}

	public function print(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();

		$information =DB::table('quotation')->where('id',$request->id)->first();

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
		  // $invoice->setType("Advanced");    // Invoice Type
		  $invoice->setType("Unapproved Quotation");    // Invoice Type
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
		  foreach ($content as $item ) {

		  	$Description = DB::table('products')->where('id',$item->id)->first();

		  	$invoice->addItem("$item->name",$Description->p_description,$item->qty,false,$item->price,false,$item->price*$item->qty);
		  }




		  $invoice->addTotal("Total",$information->net_price);
		  $invoice->addTotal("Total Payable",$information->total_price,true);
		  $invoice->addTotal("Paid",$information->amount_paid);
		  $invoice->addTotal("Due",$information->amount_due);
		  

		  //payment details -------------------------------------------------------------

		  $PaymentDetails = json_decode($information->payment_description);

		  $invoice->addTitle("Payment Details");
		  
		  $invoice->addParagraph("Cash: $PaymentDetails[0]. \nCard: $PaymentDetails[1]. \nCheque: $PaymentDetails[2]");


		  //payment details -------------------------------------------------------------

		  // $invoice->addBadge("Payment Paid");
		  
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
		$pr = DB::table('quotation')->where('id',$id)->delete();
		return Response::json($product);
	}
    //---------------------------------------------------------------------------------------
}
