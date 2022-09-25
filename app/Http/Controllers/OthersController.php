<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use Auth;

class OthersController extends Controller
{
	public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	    $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	    $role = $Sessionuser->role;

	    if ($role ==4){
	    	if ($request->ajax()) {
			$data = DB::table('others')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-others" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		else{
			if ($request->ajax()) {
			$data = DB::table('others')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-others" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>
			<a class="btn btn-warning btn-sm" id="edit-others" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		return view('Accounts.others');
    }

    public function StoreOthers(Request $request)
    {
    	$validatedData = $request->validate([
        'others_name' => 'required|max:255',
        'others_id' => 'required|unique:others',
        'others_note' => 'required',
    	]);

    	$data = array();
    	$data['others_name'] = $request->others_name;
    	$data['others_id'] = $request->others_id;
    	$data['others_note'] = $request->others_note;
    	
    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('others')->insert($data);

    	$balancedata = array();
    	$balancedata['othersb_particulars'] = $request->others_name;
    	$balancedata['othersb_id'] = $request->others_id;
    	$balancedata['othersb_balance'] = 0;

    	$user=DB::table('othersbalance')->insert($balancedata);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Others Created Successfully',
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
		$product = DB::table('others')->where($where)->first();
		return Response::json($product);
	}

	public function updateOthers(Request $request)
    {
    	$validatedData = $request->validate([
        'others_name' => 'required|max:255',
        'others_id' => 'required',
        'others_note' => 'required',
    	]);

    	//Balance info update------------------------------------------------------------
    	$othersInfo =  DB::table('others')->where('id',$request->id)->first();

    	$othersBalance =  DB::table('othersbalance')->where('othersb_id',$othersInfo->others_id)->first();

    	$balancedata = array();
    	$balancedata['othersb_particulars'] = $request->others_name;
    	$balancedata['othersb_id'] = $request->others_id;
    	$balancedata['othersb_balance'] = $othersBalance->othersb_balance;

    	$balanceUpdate=DB::table('othersbalance')->where('othersb_id',$othersBalance->othersb_id)->update($balancedata);
    	//Balance info update------------------------------------------------------------


    	//rename all payments-----------------------------------
    	$othersviewpayment = DB::table('othersview')->where('othersview_id',$othersInfo->others_id)->get();

    	
    	foreach ($othersviewpayment as $key) {

    		$dataOthersView = array();
    		$dataOthersView['othersview_particulars']=$request->others_name;
    		$dataOthersView['othersview_id']=$request->others_id;
    		$dataOthersView['othersview_folio']=$key->othersview_folio;
    		$dataOthersView['othersview_user']=$key->othersview_user;
    		$dataOthersView['othersview_credit']=$key->othersview_credit;
    		$dataOthersView['othersview_debit']=$key->othersview_debit;
    		$dataOthersView['othersview_balance']=$key->othersview_balance;
    		$dataOthersView['othersview_note']=$key->othersview_note;
    		$dataOthersView['othersview_disburse']=$key->othersview_disburse;
    		
    		$mkd = DB::table('othersview')->where('id',$key->id)->update($dataOthersView);

    		// if ($mkd) {
    		// 	dd($dataOccView);
    		// }
    	}
    	//rename all payments-----------------------------------


    	$data = array();
    	$data['others_name'] = $request->others_name;
    	$data['others_id'] = $request->others_id;
    	$data['others_note'] = $request->others_note;
    	$data['updated_at'] = date("Y-m-d H:i:s");
    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('others')->where('id',$request->id)->update($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Others Updated Successfully',
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
//-----------------------------------------------------------------------------------------
}
