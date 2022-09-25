<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use DNS1D;

use Cart;
use Auth;
use Konekt\PdfInvoice\InvoicePrinter;
use stdClass;

class StockOutrecordsController extends Controller
{

	public function index(Request $request)
	{
		if ($request->ajax()) {
		$data = DB::table('stockouts')->get();
		return Datatables::of($data)
		->addIndexColumn()
		->addColumn('action', function($row){

		$action = '<a class="btn btn-info btn-sm" id="edit-stokouts" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">';

		

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('inventory.stockoutrecords');
	}

	public function edit($id)
	{
		$where = array('id' => $id);
		$product = DB::table('stockouts')->where($where)->first();
		return Response::json($product);
	}


	public function print(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();
		

		$information =DB::table('stockouts')->where('id',$request->id)->first();

        $content=json_decode($information->products);

        $saleDate = substr($information->created_at,0,10);
      	$saleTime = substr($information->created_at,11,18);

        $customer_id = $information->id_customer;

	    $customer = DB::table('customers')->where('id',$customer_id)->first();


	    $seller_id = $information->id_seller;
	    $seller = DB::table('users')->where('id',$seller_id)->first();

	      $size = 'A4';
          $currency = 'Tk '; 
          $language = 'en';

          $invoice = new InvoicePrinter($size,$currency,$language);

		  /* Header settings */
		  $invoice->setLogo("public/images/default/ProPic.jpg");   //logo image path
		  $invoice->setAddress($request->company_name);
		  $invoice->setCustomer($customer->c_code);
		  $invoice->setColor("#007fff");      // pdf color scheme
		  $invoice->setType("Stock Out Record");    // Invoice Type
		  $invoice->setReference($information->bill_code);   // Reference
		  $invoice->setDate("    ".$saleDate);   //Billing Date
		  $invoice->setTime($saleTime);   //Billing Time
		  // $invoice->setDue(date('M dS ,Y',strtotime('+3 months')));    // Due Date
		  // $invoice->setFrom(array("Seller Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));
		  $invoice->setFrom(array("$seller->name","$seller->email"));
		  
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

		  	// $sellPrice = self::Calculateprice($item->price,$information->profit_percentage);

		  	$invoice->addItem("$item->name",$Description->p_description,$item->qty,false,$item->price,false,$item->price*$item->qty);
		  }



		  // $amountDue = $information->amount_due;
		  $invoice->addTotal("Total",$information->net_price);
		  // $invoice->addTotal("Total Payable",$information->total_price,true);
		  // $invoice->addTotal("Paid",$information->amount_paid);
		  // if($amountDue > 0){
		  // 	$invoice->addTotal("Due",$amountDue);
		  // }else{
		  // 	// $invoice->addTotal("Change",$amountChange);
		  // }
		  // $invoice->addBadge("Payment Paid");
		  
		  $invoice->addTitle("Return & Replacement Policies :");
		  
		  $invoice->addParagraph("Please, the invoice must be with you. The products are not to be returned unless it is to be submitted as to replace with another product(s) ; which must be submitted within 30-days of the product(s) selling date ; if the products are not ; installed, broken, burned, stained as usual with hologram sticker.  ");
		  
		  $invoice->setFooternote("Developed by Mackasoft");
		  
		  $invoice->render('example1.pdf','I'); 
		  /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */

	}

    //-----------------------------------------------------------------------------------------------
}
