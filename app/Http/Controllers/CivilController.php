<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use Auth;

class CivilController extends Controller
{
	public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	  	$Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	  	$role = $Sessionuser->role;

	  	if ($role ==4){
	    	if ($request->ajax()) {
			$data = DB::table('civils')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-civil" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		else{
			if ($request->ajax()) {
			$data = DB::table('civils')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-info btn-sm" id="view-civil" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-user"></i></a>
			<a class="btn btn-warning btn-sm" id="edit-civil" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		return view('Accounts.civil');
    }

    public function StoreCivil(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

    	$validatedData = $request->validate([
        'civil_name' => 'required|max:255',
        'civil_id' => 'required|unique:civils',
        'civil_note' => 'required',
    	]);

    	$data = array();
    	$data['civil_name'] = $request->civil_name;
    	$data['civil_id'] = $request->civil_id;
    	$data['civil_note'] = $request->civil_note;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('civils')->insert($data);

    	$balancedata = array();
    	$balancedata['civilb_particulars'] = $request->civil_name;
    	$balancedata['civilb_id'] = $request->civil_id;
    	$balancedata['civilb_balance'] = 0;

    	$user=DB::table('civilsbalance')->insert($balancedata);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Civil Created Successfully',
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
		$product = DB::table('civils')->where($where)->first();
		return Response::json($product);
	}

	public function updateCivil(Request $request)
    {
    	$validatedData = $request->validate([
        'civil_name' => 'required|max:255',
        'civil_id' => 'required',
        'civil_note' => 'required',
    	]);

    //Balance info update------------------------------------------------------------
	$civilInfo =  DB::table('civils')->where('id',$request->id)->first();

	$civilBalance =  DB::table('civilsbalance')->where('civilb_id',$civilInfo->civil_id)->first();

	$balancedata = array();
	$balancedata['civilb_particulars'] = $request->civil_name;
	$balancedata['civilb_id'] = $request->civil_id;
	$balancedata['civilb_balance'] = $civilBalance->civilb_balance;

	$balanceUpdate=DB::table('civilsbalance')->where('civilb_id',$civilBalance->civilb_id)->update($balancedata);
	//Balance info update------------------------------------------------------------

		//dd("Here");
		$civilsviewpayment = DB::table('civilsview')->where('civilview_id',$civilInfo->civil_id)->get();

    	//rename all payments-----------------------------------
    	foreach ($civilsviewpayment as $key) {

    		$civilsviewView = array();
    		$civilsviewView['civilview_particulars']=$request->civil_name;
    		$civilsviewView['civilview_id']=$request->civil_id;
    		$civilsviewView['civilview_folio']=$key->civilview_folio;
    		$civilsviewView['civilview_user']=$key->civilview_user;
    		$civilsviewView['civilview_credit']=$key->civilview_credit;
    		$civilsviewView['civilview_debit']=$key->civilview_debit;
    		$civilsviewView['civilview_balance']=$key->civilview_balance;
    		$civilsviewView['civilview_note']=$key->civilview_note;
    		$civilsviewView['civilview_disburse']=$key->civilview_disburse;
    		
    		$mkd = DB::table('civilsview')->where('id',$key->id)->update($civilsviewView);

    		// if ($mkd) {
    		// 	dd($dataOccView);
    		// }
    	}
    	//rename all payments-----------------------------------
    	// dd("here");




    	$data = array();
    	$data['civil_name'] = $request->civil_name;
    	$data['civil_id'] = $request->civil_id;
    	$data['civil_note'] = $request->civil_note;
    	$data['updated_at'] = date("Y-m-d H:i:s");
    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('civils')->where('id',$request->id)->update($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Civil Updated Successfully',
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
//----------------------------------------------------------------------------------------------------
}
