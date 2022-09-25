<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DB;
use Illuminate\Support\Str;
use Redirect,Response;
// use DNS1D;
use Cart;
use Auth;
use Konekt\PdfInvoice\InvoicePrinter;
use stdClass;

class approvepercentageController extends Controller
{
	public function index(Request $request)
	{
		Cart::destroy();
		$saleId = $request->id;
		$salestoapprove = DB::table('salestoapprove')->where('id',$saleId)->first();
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
	        $data['weight'] =0;
	        $data['options'] =['0'=>0];

	 //        echo "<pre>";
		// print_r($data);
	        $add = Cart::add($data);
		}
		// exit();

		$paymentDescription = json_decode($salestoapprove->payment_description);

		return view('inventory.approvepercentage',compact('costomerid','salestoapprove','paymentDescription'));
	}

	public function UpdatePercentage(Request $request,$rowId)
	{

		// echo "<pre>";
		// print_r($request->all());
		// exit();
		$product = DB::table('products')->where('id',$request->pid)->first();

		$sellPrice = self::Calculateprice($product->p_sell,$request->percentage);

		$data = array();
        $data['id'] =$product->id;
        $data['name'] =$product->p_name;
        $data['qty'] =$request->qty;
        $data['price'] =$sellPrice;
        $data['weight'] =$product->p_sell-$sellPrice;
        $data['options'] =['0'=>$request->percentage];
        // $data['taxRate'] =$request->percentage;
		$update=Cart::update($rowId, $data);

		// $productlist = Cart::content();
		// foreach ($productlist as $key) {
		// 	echo "<pre>";
		// 	print_r($key->options[0]);
		// }
		// echo "<pre>";
		// print_r($productlist);
		// exit();

        if ($update) {

   //      	echo "<pre>";
			// print_r($update);
			// exit();
        	$saleId = $request->sale_id;
			$salestoapprove = DB::table('salestoapprove')->where('id',$saleId)->first();
			$costomerid = $request->customer_id;



            $notification=array(
                'message'=>'Product Update To Cart',
                'alert-type'=>'success'
            );
            // return Redirect()->back()->with($notification);
            $paymentDescription = json_decode($salestoapprove->payment_description);
            return view('inventory.approvepercentage',compact('costomerid','salestoapprove','paymentDescription'))->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            $paymentDescription = json_decode($salestoapprove->payment_description);
            return view('inventory.approvepercentage',compact('costomerid','salestoapprove','paymentDescription'))->with($notification);
        }

	}


	public function clearCart()
	{
		Cart::destroy();
    	return redirect()->route('salesto');
	}

	public function ApproveSale(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();

		$saleId = $request->sale_id;
		$salestoapprove = DB::table('salestoapprove')->where('id',$saleId)->first();

		$productlist = Cart::content();

		//calculating profits-----------------------------------------------------------
		

		$profitJson=array();
    	$profitObj = new stdClass();

    	$profit_total = 0;

    	$newTotal=0;

    	foreach ($productlist as $por_p) {
    		$temp_product = DB::table('products')->where('id',$por_p->id)->first();

    		// $sellPrice = self::Calculateprice($por_p->price,$request->sta_percentage);
    		$discountPer = array();
    		$discountPer = $por_p->options;

    		// if ($discountPer) {
    		// 	echo "<pre>";
    		// 	print_r($discountPer[0]);
    			
    		// }
    		// exit();

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
    		$profitObj->p_discount_per = $discountPer[0];
    		$profitObj->p_discount = $por_p->weight;

    		$myJSON = json_encode($profitObj);

    		array_push($profitJson, $myJSON);

    		$profit_total = $profit_total + $p_total;
        
    	}

    	$proJson = json_encode($profitJson);
    	$profit_data = array();
    	$profit_data['p_bill_code'] = $salestoapprove->bill_code;
    	$profit_data['p_data'] = $proJson;
    	$profit_data['p_total'] = $profit_total;

    	$StockAdjust=DB::table('profits')->insert($profit_data);
		//calculating profits-----------------------------------------------------------


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

		//approve sale ------------------------------------------------------------------------


            //VAT Calculation----------------------------------------------------------
            $vatPercent = 0;
            if ($request->vat_percent !=null) {
            	$vatPercent = $request->vat_percent;
            }
            
            $totalVAT = self::Calculateprice($newTotal,$vatPercent) - $newTotal;

            $grandTotal = $newTotal+$totalVAT;

            //VAT Calculation----------------------------------------------------------


    		$newdue=0;
    		$newfinalpaid = 0;
    		if ($grandTotal<$request->amount_paid) {
    			$newdue =0;
    			$newfinalpaid = $grandTotal;
    		}else{
    			$newdue =$grandTotal-$request->amount_paid;
    			$newfinalpaid = $request->amount_paid;
    		}

    		

    		$dataSales=array();
			$dataSales['products']=$productlist;
	        $dataSales['bill_code']=$salestoapprove->bill_code;
	        $dataSales['id_customer']=$salestoapprove->id_customer;
	        $dataSales['id_seller']=$salestoapprove->id_seller;
	        $dataSales['net_price']=$newTotal;
	        $dataSales['vat_percent']=$vatPercent;
	        $dataSales['total_vat']=$totalVAT;
	        $dataSales['total_price']=$grandTotal;
	        $dataSales['payment_method']=$salestoapprove->payment_method;
	        $dataSales['payment_description']=$paymentDescription;
	        $dataSales['amount_paid']=$newfinalpaid;
	        $dataSales['amount_due']=$newdue;
	        $dataSales['profit_percentage']=0;
	        $dataSales['profits']=$profit_total;

	        $ApproveSale=DB::table('approvedsales')->insert($dataSales);
	        
	        if ($ApproveSale) {
	        	$dltSalestoapprove = DB::table('salestoapprove')->where('id',$saleId)->delete();

	        	if ($dltSalestoapprove) {
	        		$notification=array(
		 			'message'=>'Sales Approved Successfully',
		 			'alert-type'=>'success'
		 		);
	        	Cart::destroy();
		 		return Redirect()->route('salesto');

		 	}else{
		 		$notification=array(
		 			'message'=>'Something Went Wrong',
		 			'alert-type'=>'error'
		 		);
		 		Cart::destroy();
		 		return Redirect()->route('salesto');
		 	
	        	}
	        }
    	//approve sale ------------------------------------------------------------------------
	}

    //----------------------------------------------------------------------------------
    public function Calculateprice($price,$percent)
	{

		$total = 0;
		if ($percent==0) {
			$total = $price;
		}
		else if($percent<0)
		{
			$total = $price-(($price / 100)*(-1*$percent));
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
