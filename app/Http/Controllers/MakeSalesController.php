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

class MakeSalesController extends Controller
{
	public function Index()
    {

        $product=DB::table('products')->get();
        $customer = DB::table('customers')->get();
    	return view('inventory.makesales',compact('product','customer'));
    }

    public function AddCart(Request $request)
    {

    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

    	$totalProduct = DB::table('products')->where('id',$request->id)->first();

    	if ($totalProduct->p_total <=0) {
	    		$notification=array(
	            'message'=>'Product is Out of Stock',
	            'alert-type'=>'error'
	        );
	        return Redirect()->back()->with($notification);
    	}

        $data = array();
        $data['id'] =$request->id;
        $data['name'] =$request->name;
        $data['qty'] =$request->qty;
        $data['price'] =$request->p_sell;
        $data['weight'] =$request->weight;

        $add = Cart::add($data);

        if ($add) 
        {
            $notification=array(
                'message'=>'Product Added To Cart',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

        
    }

    public function AddCartBarcode(Request $request)
    {
        

        $productInput=DB::table('products')->where('p_sku',$request->barcode_input)->first();

        // echo "<pre>";
        // print_r($productInput);
        // exit();

        if ($productInput == null) {
             $notification=array(
                            'message'=>'Product not selected or Wrong product id.',
                            'alert-type'=>'warning'
                        );
                        return Redirect()->back()->with($notification);
        }

        $data = array();
        $data['id'] =$productInput->id;
        $data['name'] =$productInput->p_name;
        $data['qty'] =1;
        $data['price'] =$productInput->p_sell;
        $data['weight'] =1;

        $content = Cart::content();
        $tempqty=0;
        foreach ($content as $key) {
            if($key->id==$productInput->id){
                $tempqty=$key->qty;
            }
        }

        $tempqty=$tempqty+1;

        $product = DB::table('products')->where('id',$productInput->id)->first();

        $stock = $product->p_total;

        $stockleft=$stock-$tempqty;

        if($stockleft>=0){

            $add = Cart::add($data);

            if ($add) {
                        $notification=array(
                            'message'=>'Product Added To Cart',
                            'alert-type'=>'success'
                        );
                        return Redirect()->back()->with($notification);

                    }else{
                        $notification=array(
                            'message'=>'Something Went Wrong',
                            'alert-type'=>'error'
                        );
                        return Redirect()->back()->with($notification);
                    }
        }else{
             $notification=array(
                            'message'=>'Product out of stock',
                            'alert-type'=>'warning'
                        );
                        return Redirect()->back()->with($notification);
        }



    }

    public function removeCart($rowId)
    {
        Cart::remove($rowId);
        $notification=array(
            'message'=>'Product remove from Cart',
            'alert-type'=>'warning'
        );
        return Redirect()->back()->with($notification);
        
    }

    public function UpdateCart(Request $request,$rowId)
    {
  //   	echo "<pre>";
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
            $notification=array(
                'message'=>'Product Update To Cart',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        } 
    }

    public function clearCart()
	{
		Cart::destroy();
    	return redirect()->route('makesales');
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
        	// return redirect()->route('makesales');
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

        //Sales table insert---------------------------------------------------------------


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
	    	
	        $StoreSales=DB::table('salestoapprove')->insert($dataSales);
	    //Sales table insert---------------------------------------------------------------

        //Stock Adjust--------------------------------------------------------------------
    	

    	foreach ($content as $pro) {
    		$tempQty = $pro->qty;
    		$temp_product = DB::table('products')->where('id',$pro->id)->first();

    		$temp_p_stock = $temp_product->p_total-$tempQty;



    		$data = array();
	    	$data['p_name'] = $temp_product->p_name;
	    	$data['p_sku'] = $temp_product->p_sku;
            $data['p_box'] = $temp_product->p_box;
	    	$data['p_description'] = $temp_product->p_description;
	        $data['p_buy'] = $temp_product->p_buy;
	        $data['p_profit'] = $temp_product->p_profit;
	    	$data['p_sell'] = $temp_product->p_sell;
            $data['p_unit'] = $temp_product->p_unit;
	    	$data['p_previous'] = $temp_product->p_previous;
	    	$data['p_new'] = $temp_product->p_new;
	    	$data['p_total'] = $temp_p_stock;
            $data['p_out'] = $temp_product->p_out + $tempQty;
	    	$data['p_disburse'] = $temp_product->p_disburse;


	        
	        $user=DB::table('products')->where('id',$temp_product->id)->update($data);

            $pout = array();
            $pout['pout_name']=$temp_product->p_name;
            $pout['pout_sku']=$temp_product->p_sku;
            $pout['pout_billno']=$billCode;
            $pout['pout_quantity']=$tempQty;
            $pout['pout_saledate']=date('Y-m-d',time());

            $pOut = DB::table('productout')->insert($pout);

    	}


    	//Stock Adjust--------------------------------------------------------------------	
    	// echo "<pre>";
    	// print_r("Success");
    	// exit();

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

    //-------------------------------------------------------------------------------------------------
}
