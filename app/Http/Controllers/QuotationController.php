<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
// use DNS1D;
use Cart;
use Auth;
use Konekt\PdfInvoice\InvoicePrinter;
use stdClass;

class QuotationController extends Controller
{
	public function index()
	{
		$product=DB::table('products')->get();
        $customer = DB::table('customers')->get();
    	return view('inventory.makequotation',compact('product','customer'));
	}

    public function clearCart()
    {
        Cart::destroy();
        return redirect()->route('makequotation');
    }


	public function PrintBill(Request $request)
	{
		$request->validate([
        'customer_id' => 'required','amount_paid' => 'required','payment_method' => 'required',],
        [
            'customer_id.required'=>'Select A Customer or Add A Customer',
            'amount_paid.required'=>'Add Paid Amount.',
            'payment_method.required'=>'Add Pyment Method.',
        ]);

		// echo "<pre>";
		// print_r($request->all());
		// exit();

		// Customer Info--------------------------------------------------------------------------
		$customerinfo = explode(':', $request->customer_id);

        $customerID = $customerinfo[0];

        $iscustomer = DB::table('customers')->where('id',$customerID)->first();

        if (empty($iscustomer )) {
            $notification=array(
                'message'=>'This Customer is not registered.',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

        // Customer Info--------------------------------------------------------------------------
        if (Cart::total() == 0) {
            $notification=array(
                'message'=>'Invoice is empty. Add Some Product.',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
        	// return redirect()->route('advancedsales');
        }

        $content = Cart::content();

        //calculating profits-----------------------------------------------------------

        $profit_total = 0;

        foreach ($content as $por_p) {
            $temp_product = DB::table('products')->where('id',$por_p->id)->first();


            $profit_single = $por_p->price - $temp_product->p_buy;
            $p_total = 0;
            if ($profit_single >=0) {
                $p_total = $por_p->qty*$profit_single;
            }

            $profit_total = $profit_total + $p_total;
        
        }
        //calculating profits-----------------------------------------------------------

        //Quotation table insert---------------------------------------------------------------


	        $referancedata = DB::table('referances')->where('id',2)->first();

            // $billCode=Str::random(8);$referance->r_billcode
            // $billCode="HM-B0000".$referancedata->r_billcode;
            $billCode=" ";
            if ($referancedata->r_billcode < 1000) {
                $billCode="HM-B0000".$referancedata->r_billcode;
            }
            elseif ($referancedata->r_billcode < 10000) {
                $billCode="HM-B000".$referancedata->r_billcode;
            }
            elseif ($referancedata->r_billcode < 100000) {
                $billCode="HM-B00".$referancedata->r_billcode;
            }
            elseif ($referancedata->r_billcode < 1000000) {
                $billCode="HM-B0".$referancedata->r_billcode;
            }
            else{
                $billCode="HM-B".$referancedata->r_billcode;
            }

	        $sellerId = Auth::id(); 

	        $Totaltax = str_replace(",","",Cart::tax());

	        $subTotal = str_replace(",","",Cart::subtotal());

	        $temp = str_replace(",","",$request->carttotal);
	        $carttotal=floatval($temp);
	        $paid = $request->amount_paid;
	        $amountDue = $carttotal-(float)$paid;

	        $amountChange = 0;

	        if($amountDue <= 0){

	        	$amountChange = $amountDue*(-1);
	        	$amountDue = 0;
	        }


	        $ifChangePaid = $paid - $amountChange;  

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

	        $dataSales=array();

	        if($amountDue <= 0){

		        $dataSales['products']=$content;
		        $dataSales['bill_code']=$billCode;
		        $dataSales['id_customer']=$customerID;
		        $dataSales['id_seller']=$sellerId;
		        $dataSales['net_price']=$subTotal;
		        $dataSales['total_price']=$carttotal;
		        $dataSales['payment_method']=$request->payment_method;
                $dataSales['payment_description']=$paymentDescription;
		        $dataSales['amount_paid']=$ifChangePaid;
		        $dataSales['amount_due']=0.00;
                $dataSales['amount_profit']=$profit_total;

	    	}else{

	    		$dataSales['products']=$content;
		        $dataSales['bill_code']=$billCode;
		        $dataSales['id_customer']=$customerID;
		        $dataSales['id_seller']=$sellerId;
		        $dataSales['net_price']=$subTotal;
		        $dataSales['total_price']=$carttotal;
		        $dataSales['payment_method']=$request->payment_method;
                $dataSales['payment_description']=$paymentDescription;
		        $dataSales['amount_paid']=$paid;
		        $dataSales['amount_due']=$amountDue;
                $dataSales['amount_profit']=$profit_total;


	    	}
	    	
	        $StoreSales=DB::table('quotation')->insert($dataSales);
	    //Advanced  table insert---------------------------------------------------------------

     
        $pbill=array();
        $pbill['r_billcode']=$referancedata->r_billcode+1;
        $referancedata = DB::table('referances')->where('id',2)->update($pbill);
            
    	$notification=array(
                'message'=>'Invoice is Submitted for approval',
                'alert-type'=>'success'
            );
    	Cart::destroy();
    	return redirect()->back()->with($notification);

	}
    //--------------------------------------------------------------------------------------
}
