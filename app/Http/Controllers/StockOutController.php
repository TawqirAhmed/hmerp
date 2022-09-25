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

class StockOutController extends Controller
{
    public function index()
    {
        $product=DB::table('products')->get();
    	return view('inventory.stockout',compact('product'));
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
    	return redirect()->route('stockout');
	}

	public function PrintBill(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();

        $request->validate([
        'customer_id' => 'required',],
        [
            'customer_id.required'=>'Select A Customer or Add A Customer',
        ]);

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
        	return redirect()->route('stockout');
        }

        $content = Cart::content();

		 //Stockout table insert---------------------------------------------------------------

        	$referancedata = DB::table('referances')->where('id',2)->first();

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

        	// $billCode="HM-B0000".$referancedata->r_billcode;
	        // $billCode=Str::random(8);$referance->r_billcode
        	
	        // echo "<pre>";
	        // print_r($billCode);
	        // exit();

	        $sellerId = Auth::id(); 

	        $Totaltax = str_replace(",","",Cart::tax());

	        $subTotal = str_replace(",","",Cart::subtotal());

	        $temp = str_replace(",","",$request->carttotal);
	        $carttotal=floatval($temp);

	        

	        $dataSales=array();

    		$dataSales['products']=$content;
	        $dataSales['bill_code']=$billCode;
	        $dataSales['id_seller']=$sellerId;
            $dataSales['id_customer']=$customerID;
	        $dataSales['net_price']=$subTotal;
	        $dataSales['total_price']=$carttotal;

	        $StoreSales=DB::table('stockouts')->insert($dataSales);
	    //Stockout table insert---------------------------------------------------------------

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

    	//Printing Bill-----------------------------------------------------------------

        $customer = DB::table('customers')->where('id',$request->customer_id)->first();

	        $getseller = DB::table('users')->where('id',$sellerId)->first(); 

		      $size = 'A4';
	          $currency = 'Tk '; 
	          $language = 'en';

	          $invoice = new InvoicePrinter($size,$currency,$language);

			  /* Header settings */
			  $invoice->setLogo("public/images/default/ProPic.jpg");   //logo image path
              $invoice->setCustomer($customer->c_code);
			  $invoice->setColor("#007fff");      // pdf color scheme
			  $invoice->setType("Stock Out Record");    // Invoice Type
			  $invoice->setReference("$billCode");   // Reference
			  $invoice->setDate(" ".date('M dS ,Y',time()));   //Billing Date
			  $invoice->setTime(date('h:i:s A',time()));   //Billing Time
			  // $invoice->setDue(date('M dS ,Y',strtotime('+3 months')));    // Due Date
			  // $invoice->setFrom(array("Seller Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));
			  $invoice->setFrom(array("$getseller->name","$getseller->email"));


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




			  $invoice->addTotal("Total",Cart::subtotal());
			  $invoice->addTotal("Grand Total",Cart::total(),true);
			 
			  
			  $invoice->addTitle("Turms & Conditions");
			  
			  $invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you.");
			  
			  $invoice->setFooternote("Developed by Mackasoft");
			  
			  // $invoice->render('example1.pdf','I'); 

			  /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */

			  $pbill=array();
			  $pbill['r_billcode']=$referancedata->r_billcode+1;
			  $referancedata = DB::table('referances')->where('id',2)->update($pbill);

			  Cart::destroy();

	    	  // return redirect()->route('stockout');

              if ($referancedata)
                {
                    $notification=array(
                        'message'=>'StockOut Created Succesfuly',
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

        //Printing Bill-----------------------------------------------------------------

	}
//---------------------------------------------------------------------------------------------   







}
