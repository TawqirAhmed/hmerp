<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProductInfoController extends Controller
{

	 public function index(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            // dd($req->all());
            
            // $From = 0;
            // $To   = 0;
            // $p_Name = $req->products_id;

            

            // $product = DB::table('products')
            //       ->where('p_name',$p_Name)
            //       ->get();

            // $Totalproduct = 0;
            // foreach ($product as $key ) {
            //     $Totalproduct = $Totalproduct + $key->p_total;
            // }

            // return view('inventory.productinfo',compact('product','From','To','Totalproduct','p_Name'));

            $p_temp = explode(':',$req->products_id);

            $From = 0;
            $To   = 0;
            $p_Name = $p_temp[0];

            $p_sku = $p_temp[1];

            

            $product = DB::table('products')
                  ->where('p_sku',$p_sku)
                  ->get();

            // dd($product);

            $Totalproduct = 0;
            foreach ($product as $key ) {
                $Totalproduct = $Totalproduct + $key->p_total;
            }

            return view('inventory.productinfo',compact('product','From','To','Totalproduct','p_Name','p_sku'));



        }
        else
        {
            $From = 0;
            $To   = 0;
            $p_Name = "";
            $p_sku = "";

            // $product = DB::table('products')->get();
            $product = array();

            $Totalproduct = 0;
            foreach ($product as $key ) {
                $Totalproduct = $Totalproduct + $key->p_total;
            }

            return view('inventory.productinfo',compact('product','From','To','Totalproduct','p_Name','p_sku'));
            // return view('inventory.productinfo');
        }
    }
    //-----------------------------------------------------------------------------------------
}
