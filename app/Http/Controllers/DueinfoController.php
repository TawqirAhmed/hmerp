<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class DueinfoController extends Controller
{

	public function index(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {

            // $From = $req->input('from');
            // $To   = $req->input('to');
            $From = 0;
            $To   = 0;


            $customerinfo = explode(':', $req->products_id);

            $customerID = $customerinfo[0];

            $p_id = $customerID;

            // $product = DB::table('products')
            // 	  ->where('p_name',$p_Name)
            //       ->whereDate('created_at', '>=', date($From))
            //       ->whereDate('created_at','<=', date($To))
            //       ->get();

            $customers = DB::table('customers')->where('id',$p_id)->first();
            $p_Name = $customers->c_name;

            $product = DB::table('approvedsales')
            	  ->join('customers','approvedsales.id_customer','customers.id')
		    	  ->select('customers.c_name','customers.c_code','approvedsales.*')
                  ->where('id_customer',$p_id)
                  ->where('amount_due','>',0)
                  ->get();

                  // echo "<pre>";
                  // print_r($product);
                  // exit();

            $Totalproduct = 0;
            foreach ($product as $key ) {
                $Totalproduct = $Totalproduct + $key->amount_due;
            }

            return view('inventory.dueinfo',compact('product','From','To','Totalproduct','p_Name'));
            // return view('inventory.productinfo');
        }
        else
        {
            $From = 0;
            $To   = 0;
            $p_Name = "";

            // $product = DB::table('products')->get();
            $product = array();

            $Totalproduct = 0;
            foreach ($product as $key ) {
                $Totalproduct = $Totalproduct + $key->amount_due;
            }

            return view('inventory.dueinfo',compact('product','From','To','Totalproduct','p_Name'));
            // return view('inventory.productinfo');
        }
    }
    //----------------------------------------------------------------------------------------
}
