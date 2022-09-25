<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use Auth;

class SupplyController extends Controller
{
    public function index(Request $request)
    {
      $Sessionid=Auth::id();
	  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	  $role = $Sessionuser->role;

	  if ($role ==4){

	    	if ($request->ajax()) {
			$data = DB::table('supplies')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-supply" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
	  }
	  else{
	  		if ($request->ajax()) {
			$data = DB::table('supplies')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-supply" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>
			<a class="btn btn-warning btn-sm" id="edit-supply" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
	  }

		return view('Accounts.supply');
    }

    public function StoreSupply(Request $request)
    {
    	$validatedData = $request->validate([
        'supplies_name' => 'required|max:255',
        'supplies_id' => 'required|unique:supplies',
        'supplies_note' => 'required',
    	]);

    	$data = array();
    	$data['supplies_name'] = $request->supplies_name;
    	$data['supplies_id'] = $request->supplies_id;
    	$data['supplies_note'] = $request->supplies_note;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('supplies')->insert($data);

        $balancedata = array();
        $balancedata['suppliesb_particulars'] = $request->supplies_name;
        $balancedata['suppliesb_id'] = $request->supplies_id;
        $balancedata['suppliesb_balance'] = 0;

        $user=DB::table('suppliesbalance')->insert($balancedata);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Supply Created Successfully',
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
		$product = DB::table('supplies')->where($where)->first();
		return Response::json($product);
	}

	public function updateSupply(Request $request)
    {

    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

    	$validatedData = $request->validate([
        'supplies_name' => 'required|max:255',
        'supplies_id' => 'required',
        'supplies_note' => 'required',
    	]);

        //Balance info update------------------------------------------------------------
        $suppliesInfo =  DB::table('supplies')->where('id',$request->id)->first();

        $suppliesBalance =  DB::table('suppliesbalance')->where('suppliesb_id',$suppliesInfo->supplies_id)->first();

        $balancedata = array();
        $balancedata['suppliesb_particulars'] = $request->supplies_name;
        $balancedata['suppliesb_id'] = $request->supplies_id;
        $balancedata['suppliesb_balance'] = $suppliesBalance->suppliesb_balance;

        $balanceUpdate=DB::table('suppliesbalance')->where('suppliesb_id',$suppliesBalance->suppliesb_id)->update($balancedata);
        //Balance info update------------------------------------------------------------


        //rename all payments-----------------------------------
    	$suppliesview = DB::table('suppliesview')->where('suppliesview_id',$suppliesInfo->supplies_id)->get();

    	
    	foreach ($suppliesview as $key) {

    		$datasuppliesview = array();
    		$datasuppliesview['suppliesview_name']=$key->suppliesview_name;
    		$datasuppliesview['suppliesview_particulars']=$request->supplies_name;
    		$datasuppliesview['suppliesview_id']=$request->supplies_id;
    		$datasuppliesview['suppliesview_folio']=$key->suppliesview_folio;
    		$datasuppliesview['suppliesview_user']=$key->suppliesview_user;
    		$datasuppliesview['suppliesview_credit']=$key->suppliesview_credit;
    		$datasuppliesview['suppliesview_debit']=$key->suppliesview_debit;
    		$datasuppliesview['suppliesview_balance']=$key->suppliesview_balance;
    		$datasuppliesview['suppliesview_note']=$key->suppliesview_note;
    		$datasuppliesview['suppliesview_disburse']=$key->suppliesview_disburse;
    		
    		$mkd = DB::table('suppliesview')->where('id',$key->id)->update($datasuppliesview);

    		// if ($mkd) {
    		// 	dd($dataOccView);
    		// }
    	}
    	//rename all payments-----------------------------------




    	$data = array();
    	$data['supplies_name'] = $request->supplies_name;
    	$data['supplies_id'] = $request->supplies_id;
    	$data['supplies_note'] = $request->supplies_note;
        $data['updated_at'] = date("Y-m-d H:i:s");
    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('supplies')->where('id',$request->id)->update($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Supply Updated Successfully',
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

//----------------------------------------------------------------------------------------------------------
}
