<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use Auth;

class ICTController extends Controller
{
    public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	    $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	    $role = $Sessionuser->role;

	    if ($role ==4){
	    	if ($request->ajax()) {
			$data = DB::table('icts')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-ict" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		else{
			if ($request->ajax()) {
			$data = DB::table('icts')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-ict" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>
			<a class="btn btn-warning btn-sm" id="edit-ict" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		return view('Accounts.ict');
    }

    public function StoreICT(Request $request)
    {
    	$validatedData = $request->validate([
        'ict_name' => 'required|max:255',
        'ict_id' => 'required|unique:icts',
        'ict_note' => 'required',
    	]);

    	$data = array();
    	$data['ict_name'] = $request->ict_name;
    	$data['ict_id'] = $request->ict_id;
    	$data['ict_note'] = $request->ict_note;

    	// echo "<pre>";
    	// print_r($request->all());
    	// // print_r($data);
    	// exit();
    	$user=DB::table('icts')->insert($data);

    	$balancedata = array();
    	$balancedata['ictb_particulars'] = $request->ict_name;
    	$balancedata['ictb_id'] = $request->ict_id;
    	$balancedata['ictb_balance'] = 0;

    	$user=DB::table('ictsbalance')->insert($balancedata);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'ICT Created Successfully',
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
		$product = DB::table('icts')->where($where)->first();
		return Response::json($product);
	}

	public function updateICT(Request $request)
    {
    	$validatedData = $request->validate([
        'ict_name' => 'required|max:255',
        'ict_id' => 'required',
        'ict_note' => 'required',
    	]);

    	


    	//Balance info update------------------------------------------------------------
    	$ictInfo =  DB::table('icts')->where('id',$request->id)->first();

    	$ictBalance =  DB::table('ictsbalance')->where('ictb_id',$ictInfo->ict_id)->first();

    	$balancedata = array();
    	$balancedata['ictb_particulars'] = $request->ict_name;
    	$balancedata['ictb_id'] = $request->ict_id;
    	$balancedata['ictb_balance'] = $ictBalance->ictb_balance;

    	$balanceUpdate=DB::table('ictsbalance')->where('ictb_id',$ictBalance->ictb_id)->update($balancedata);
    	//Balance info update------------------------------------------------------------

    	//rename all payments-----------------------------------
    	$ictsviewpayment = DB::table('ictsview')->where('ictview_id',$ictInfo->ict_id)->get();

    	
    	foreach ($ictsviewpayment as $key) {

    		$dataIctsView = array();
    		$dataIctsView['ictview_particulars']=$request->ict_name;
    		$dataIctsView['ictview_id']=$request->ict_id;
    		$dataIctsView['ictview_folio']=$key->ictview_folio;
    		$dataIctsView['ictview_user']=$key->ictview_user;
    		$dataIctsView['ictview_credit']=$key->ictview_credit;
    		$dataIctsView['ictview_debit']=$key->ictview_debit;
    		$dataIctsView['ictview_balance']=$key->ictview_balance;
    		$dataIctsView['ictview_disburse']=$key->ictview_disburse;
    		$dataIctsView['ictview_note']=$key->ictview_note;
    		
    		$mkd = DB::table('ictsview')->where('id',$key->id)->update($dataIctsView);

    		// if ($mkd) {
    		// 	dd($dataOccView);
    		// }
    	}
    	//rename all payments-----------------------------------
    	


        $data = array();
        $data['ict_name'] = $request->ict_name;
        $data['ict_id'] = $request->ict_id;
        $data['ict_note'] = $request->ict_note;
        $data['updated_at'] = date("Y-m-d H:i:s");
        // echo "<pre>";
        // print_r($data);
        // exit();
        $user=DB::table('icts')->where('id',$request->id)->update($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'ICT Updated Successfully',
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
//-----------------------------------------------------------------------------------------------------
}
