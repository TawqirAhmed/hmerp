<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use DB;

class AddProductBarcode extends Controller
{

	public function index ()
    {
    	return view('inventory.stockinbarcode');
    }


    public function BarcodeADD(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit();barcode_input
         $notification=array(
                'message'=>'ADD Product Successful',
                'alert-type'=>'success'
            );


        $getproduct = DB::table('products')->where('p_sku',$request->barcode_input)->first();


        if (!$getproduct) {

            $notification=array(
                'message'=>'Product not found. Add Product First!!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }


        $id = $getproduct->id;


        $purchaseCart = session()->get('purchaseCart');
         // if cart is empty then this the first product
        if(!$purchaseCart) {
            $purchaseCart = [
                    $id => [
                        "name" => $getproduct->p_name,
                        "sku" => $getproduct->p_sku,
                        "quantity" => 1,
                        "box" => $getproduct->p_box,
                    ]
            ];
            session()->put('purchaseCart', $purchaseCart);
            return redirect()->back()->with($notification);
        }

        // if cart not empty then check if this product exist then increment quantity
        if(isset($purchaseCart[$id])) {
            $purchaseCart[$id]['quantity']++;
            session()->put('purchaseCart', $purchaseCart);
            return redirect()->back()->with($notification);
        }

        // if item not exist in cart then add to cart with quantity = 1
        $purchaseCart[$id] = [
            "name" => $getproduct->p_name,
            "sku" => $getproduct->p_sku,
            "quantity" => 1,
            "box" => $getproduct->p_box,
        ];
        session()->put('purchaseCart', $purchaseCart);
        return redirect()->back()->with($notification);



    }




    public function barcodeClearCart()
    {
        session()->forget('purchaseCart');
        return redirect()->back();
    }



    public function update(Request $request)
    {
        if($request->id and $request->quantity and $request->box)
        {
            $purchaseCart = session()->get('purchaseCart');
            $purchaseCart[$request->id]["quantity"] = $request->quantity;
            $purchaseCart[$request->id]["box"] = $request->box;
            session()->put('purchaseCart', $purchaseCart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $purchaseCart = session()->get('purchaseCart');
            if(isset($purchaseCart[$request->id])) {
                unset($purchaseCart[$request->id]);
                session()->put('purchaseCart', $purchaseCart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }




    public function barcodeUpdateProducts()
    {


        if(session('purchaseCart')){
            foreach(session('purchaseCart') as $id => $details){
                // echo "<pre>";
                // print_r($id." : ".$details['sku']." : ".$details['box']." : ".$details['quantity']." : ".$details['name']);
                $boxInfo = $details['box'];
                $new = $details['quantity'];

                $productInfo = DB::table('products')->where('id',$id)->first();

                $data = array();
                $data['p_name'] =$productInfo->p_name;
                $data['p_sku'] =$productInfo->p_sku;
                $data['p_box'] =$boxInfo;
                $data['p_description'] =$productInfo->p_description;
                $data['p_buy'] =$productInfo->p_buy;
                $data['p_profit'] =$productInfo->p_profit;
                $data['p_sell'] =$productInfo->p_sell;
                $data['p_unit'] =$productInfo->p_unit;
                $data['p_previous'] =$productInfo->p_total;
                $data['p_new'] =$new;
                $data['p_total'] =$productInfo->p_total+$new;
                $data['p_out'] =$productInfo->p_out;
                $data['p_disburse'] =$productInfo->p_disburse;
                $data['updated_at'] = date("Y-m-d H:i:s");

                $product=DB::table('products')->where('id',$id)->update($data);

                //product purchase------------------------------------------------------------------
                $puchaseData = array();
                $puchaseData['ppurchase_name'] =$productInfo->p_name;
                $puchaseData['ppurchase_sku'] =$productInfo->p_sku;
                $puchaseData['ppurchase_quantity'] =$new;
                $puchaseData['ppurchase_purchase'] =$productInfo->p_disburse;

                $product2=DB::table('productspurchase')->insert($puchaseData);
                //product purchase------------------------------------------------------------------


            }
        }
                      

  //   	echo "<pre>";
		// print_r("barcodeUpdateProducts");
		// exit();

    	session()->forget('purchaseCart');

        if ($product) {
            $notification=array(
                'message'=>'Update Inventory Successful',
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

    //----------------------------------------------------------------------------------
}
