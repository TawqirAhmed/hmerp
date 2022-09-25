<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use Auth;


class OCCController extends Controller
{
    public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	  $role = $Sessionuser->role;

	  if ($role ==4){
	    	if ($request->ajax()) {
			$data = DB::table('occs')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-occ" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		else{
			if ($request->ajax()) {
			$data = DB::table('occs')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-occ" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>
			<a class="btn btn-warning btn-sm" id="edit-occ" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		return view('Accounts.occ');
    }

    public function StoreOCC(Request $request)
    {
    	$validatedData = $request->validate([
        'occ_name' => 'required|max:255',
        'occ_id' => 'required|unique:occs',
        'occ_note' => 'required',
    	]);

    	$data = array();
    	$data['occ_name'] = $request->occ_name;
    	$data['occ_id'] = $request->occ_id;
    	$data['occ_note'] = $request->occ_note;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('occs')->insert($data);

    	$balancedata = array();
    	$balancedata['occb_particulars'] = $request->occ_name;
    	$balancedata['occb_id'] = $request->occ_id;
    	$balancedata['occb_balance'] = 0;

    	$user=DB::table('occsbalance')->insert($balancedata);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'OCC Created Successfully',
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
		$product = DB::table('occs')->where($where)->first();
		return Response::json($product);
	}

	public function updateOCC(Request $request)
    {
    	$validatedData = $request->validate([
        'occ_name' => 'required|max:255',
        'occ_id' => 'required',
        'occ_note' => 'required',
    	]);

    	//Balance info update------------------------------------------------------------
    	$occInfo =  DB::table('occs')->where('id',$request->id)->first();

    	$occBalance =  DB::table('occsbalance')->where('occb_id',$occInfo->occ_id)->first();

    	$balancedata = array();
    	$balancedata['occb_particulars'] = $request->occ_name;
    	$balancedata['occb_id'] = $request->occ_id;
    	$balancedata['occb_balance'] = $occBalance->occb_balance;

    	$balanceUpdate=DB::table('occsbalance')->where('occb_id',$occBalance->occb_id)->update($balancedata);
    	//Balance info update------------------------------------------------------------

    		//rename all payments-----------------------------------
    	$occviewpayment = DB::table('occsview')->where('occview_id',$occInfo->occ_id)->get();

    	
    	foreach ($occviewpayment as $key) {

    		$dataOccView = array();
    		$dataOccView['occview_particulars']=$request->occ_name;
    		$dataOccView['occview_id']=$request->occ_id;
    		$dataOccView['occview_folio']=$key->occview_folio;
    		$dataOccView['occview_user']=$key->occview_user;
    		$dataOccView['occview_credit']=$key->occview_credit;
    		$dataOccView['occview_debit']=$key->occview_debit;
    		$dataOccView['occview_balance']=$key->occview_balance;
    		$dataOccView['occview_note']=$key->occview_note;
    		$dataOccView['occview_disburse']=$key->occview_disburse;
    		
    		$mkd = DB::table('occsview')->where('id',$key->id)->update($dataOccView);

    		// if ($mkd) {
    		// 	dd($dataOccView);
    		// }
    	}
    	//rename all payments-----------------------------------
    	// dd("here");

    	$data = array();
    	$data['occ_name'] = $request->occ_name;
    	$data['occ_id'] = $request->occ_id;
    	$data['occ_note'] = $request->occ_note;
    	$data['updated_at'] = date("Y-m-d H:i:s");

    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

    	$user=DB::table('occs')->where('id',$request->id)->update($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'OCC Updated Successfully',
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

//-----------------------------------------------------------------------------------------------------------
}
