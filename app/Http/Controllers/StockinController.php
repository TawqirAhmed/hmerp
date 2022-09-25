<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use DNS1D;
use Auth;

class StockinController extends Controller
{
	public function index(Request $request)
	{
		$Sessionid=Auth::id();
	    $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	    $role = $Sessionuser->role;

	    if ($role ==5){

			if ($request->ajax()) {
			$data = DB::table('products')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->addColumn('action', function($row){

				$action = 
					'<div class="btn-group">
					  <button  style = "font-size: .75rem;" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fas fa-cogs"></i>
					  </button>
					  <div class="dropdown-menu dropdown-menu-right">
					    <a class="btn btn-info btn-sm dropdown-item" id="edit-barcode" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Barcode</a>
				        <a class="btn btn-success btn-sm dropdown-item" id="edit-stock" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-arrow-up"></i> Add Product</a>
						<meta name="csrf-token" content="{{ csrf_token() }}">
						
					  </div>
					</div>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}


		}else if($role ==2){

			if ($request->ajax()) {
			$data = DB::table('products')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->addColumn('action', function($row){

				$action = 
					// $action = 
					'<div class="btn-group">
					  <button  style = "font-size: .75rem;" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fas fa-cogs"></i>
					  </button>
					  <div class="dropdown-menu dropdown-menu-right">
					    <a class="btn btn-info btn-sm dropdown-item" id="edit-barcode" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Barcode</a>
				        <a class="btn btn-success btn-sm dropdown-item" id="edit-stock" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-arrow-up"></i> Add Product</a>
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
			$data = DB::table('products')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->addColumn('action', function($row){

			// $action = '<a class="btn btn-info btn-sm" id="edit-barcode" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i></a>
	  //       <a class="btn btn-success btn-sm" id="edit-stock" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-arrow-up"></i></a>
	  //       <a class="btn btn-warning btn-sm" id="edit-products" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			// <meta name="csrf-token" content="{{ csrf_token() }}">';

				$action = 
					'<div class="btn-group">
					  <button  style = "font-size: .75rem;" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fas fa-cogs"></i>
					  </button>
					  <div class="dropdown-menu dropdown-menu-right">
					    <a class="btn btn-info btn-sm dropdown-item" id="edit-barcode" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i> Barcode</a>
				        <a class="btn btn-success btn-sm dropdown-item" id="edit-stock" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-arrow-up"></i> Add Product</a>
				        <a class="btn btn-warning btn-sm dropdown-item" id="edit-products" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i> Edit Product</a>
						<meta name="csrf-token" content="{{ csrf_token() }}">
						<a title="Delete" id="delete-product" data-id='.$row->id.' class="btn btn-danger delete-product btn-sm dropdown-item"><i class="fas fa-trash"></i>Delete Product</a>
					  </div>
					</div>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}

		return view('inventory.stockin');
	}

	public function AddProduct(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();

		$validatedData = $request->validate([
        'p_name' => 'required|max:255',
        'p_sku' => 'required|unique:products',
        'p_buy' => 'required',
        'p_unit' => 'required',
    	]);

		$p_sell = self::Calculateprice($request->p_buy,$request->p_profit);


		$data = array();
		$data['p_name'] =$request->p_name;
		$data['p_sku'] =$request->p_sku;
		$data['p_box'] =$request->p_box;
		$data['p_description'] =$request->p_description;
		$data['p_buy'] =$request->p_buy;
		$data['p_profit'] =$request->p_profit;
		$data['p_sell'] =$p_sell;
		$data['p_unit'] =$request->p_unit;
		$data['p_previous'] =0;
		$data['p_new'] =$request->p_new;
		$data['p_total'] =$request->p_new;
		$data['p_out'] =0;
		$data['p_disburse'] =$request->p_disburse." ".date('H:i:s');

		$product=DB::table('products')->insert($data);


		//product purchase------------------------------------------------------------------
		$puchaseData = array();
		$puchaseData['ppurchase_name'] =$request->p_name;
		$puchaseData['ppurchase_sku'] =$request->p_sku;
		$puchaseData['ppurchase_quantity'] =$request->p_new;
		$puchaseData['ppurchase_purchase'] =$request->p_disburse." ".date('H:i:s');

		$product=DB::table('productspurchase')->insert($puchaseData);
		//product purchase------------------------------------------------------------------




		if ($product) {
	 		$notification=array(
	 			'message'=>'Product added Successfully',
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


	public function edit($id)
	{
		$where = array('id' => $id);
		$product = DB::table('products')->where($where)->first();
		return Response::json($product);
	}

	public function updateProduct(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();
		$validatedData = $request->validate([
		'id' => 'required',
        'p_name' => 'required|max:255',
        'p_sku' => 'required',
        'p_buy' => 'required',
        'p_unit' => 'required',
    	]);

		$productInfo = DB::table('products')->where('id',$request->id)->first();


    	$p_sell = self::Calculateprice($request->p_buy,$request->p_profit);

    	$data = array();
		$data['p_name'] =$request->p_name;
		$data['p_sku'] =$request->p_sku;
		$data['p_box'] =$request->p_box;
		$data['p_description'] =$request->p_description;
		$data['p_buy'] =$request->p_buy;
		$data['p_profit'] =$request->p_profit;
		$data['p_sell'] =$p_sell;
		$data['p_unit'] =$request->p_unit;
		$data['p_previous'] =$productInfo->p_previous;
		$data['p_new'] =$productInfo->p_new;
		$data['p_total'] =$productInfo->p_total;
		$data['p_out'] =$productInfo->p_out;
		$data['p_disburse'] =$request->p_disburse." ".date('H:i:s');
		$data['updated_at'] = date("Y-m-d H:i:s");


		$product=DB::table('products')->where('id',$request->id)->update($data);

		//product purchase------------------------------------------------------------------
		$purchaseInfo = DB::table('productspurchase')->where('ppurchase_sku',$productInfo->p_sku)->get();

		// echo "<pre>";
		// print_r($purchaseInfo);
		// exit();

		foreach ($purchaseInfo as $key) {
			$keyid = $key->id;

			$puchaseData = array();
			$puchaseData['ppurchase_name'] =$request->p_name;
			$puchaseData['ppurchase_sku'] =$request->p_sku;
			$puchaseData['ppurchase_quantity'] =$key->ppurchase_quantity;
			$puchaseData['ppurchase_purchase'] =$key->ppurchase_purchase;

			$productPurchase=DB::table('productspurchase')->where('id',$keyid)->update($puchaseData);
		}

			// $puchaseData = array();
			// $puchaseData['ppurchase_name'] =$request->p_name;
			// $puchaseData['ppurchase_sku'] =$request->p_sku;
			// $puchaseData['ppurchase_quantity'] =$request->p_new;
			// $puchaseData['ppurchase_purchase'] =$request->p_disburse." ".date('H:i:s');

			// $product=DB::table('productspurchase')->insert($puchaseData);
		//product purchase------------------------------------------------------------------

        if ($product) {
            $notification=array(
                'message'=>'Update Product Successful',
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

	public function updateStock(Request $request)
	{
		// echo "<pre>";
		// print_r($request->all());
		// exit();
		$validatedData = $request->validate([
		'id' => 'required',
        'p_new' => 'required|max:255',
    	]);

    	$productInfo = DB::table('products')->where('id',$request->id)->first();

    	$data = array();
		$data['p_name'] =$productInfo->p_name;
		$data['p_sku'] =$productInfo->p_sku;
		$data['p_box'] =$productInfo->p_box;
		$data['p_description'] =$productInfo->p_description;
		$data['p_buy'] =$productInfo->p_buy;
		$data['p_profit'] =$productInfo->p_profit;
		$data['p_sell'] =$productInfo->p_sell;
		$data['p_unit'] =$productInfo->p_unit;
		$data['p_previous'] =$productInfo->p_total;
		$data['p_new'] =$request->p_new;
		$data['p_total'] =$productInfo->p_total+$request->p_new;
		$data['p_out'] =$productInfo->p_out;
		$data['p_disburse'] =$request->p_disburse." ".date('H:i:s');
		$data['updated_at'] = date("Y-m-d H:i:s");

		$product=DB::table('products')->where('id',$request->id)->update($data);

		//product purchase------------------------------------------------------------------
		$puchaseData = array();
		$puchaseData['ppurchase_name'] =$productInfo->p_name;
		$puchaseData['ppurchase_sku'] =$productInfo->p_sku;
		$puchaseData['ppurchase_quantity'] =$request->p_new;
		$puchaseData['ppurchase_purchase'] =$request->p_disburse." ".date('H:i:s');

		$product=DB::table('productspurchase')->insert($puchaseData);
		//product purchase------------------------------------------------------------------

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

	public function barcode(Request $request)
    {
        $productID=$request->id;
        $ProductName=$request->bar_name;
        // $amount=$request->bar_new;
        $amount=0;
        $producto = DB::table('products')
                        ->where('id',$productID)
                        ->first();

         $code=$producto->p_sku; 

         $data = DNS1D::getBarcodeSVG($producto->p_sku, 'C128',$ProductName,1,50); 
         
         // echo $ProductName;

        return view('barcode',compact('amount','ProductName','productID','code','data'));
    }


    public function destroy($id)
	{
		$deleteProduct = DB::table('products')
                        ->where('id',$id)
                        ->delete();

        // $product = Product::where('id',$id)->delete();
		return Response::json($product);
	}
    
//------------------------------------------------------------------------------------------------------
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
