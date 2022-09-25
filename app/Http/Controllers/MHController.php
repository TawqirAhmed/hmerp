<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use Auth;

class MHController extends Controller
{
     public function index(Request $request)
    {
    	$Sessionid=Auth::id();
	    $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	    $role = $Sessionuser->role;

	    if ($role == 4) {
	    	if ($request->ajax()) {
			$data = DB::table('mhins')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			// $action = '<a class="btn btn-warning btn-sm" id="edit-mh" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			// <meta name="csrf-token" content="{{ csrf_token() }}">
			// ';
				$action = '
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}
		else{
			if ($request->ajax()) {
			$data = DB::table('mhins')->get();
			return Datatables::of($data)
			->addIndexColumn()
			->editColumn('created_at', function($row) {
	                    return $row->created_at;
	                })
			->addColumn('action', function($row){

			$action = '<a class="btn btn-warning btn-sm" id="edit-mh" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
			<meta name="csrf-token" content="{{ csrf_token() }}">
			';

			

			return $action;

			})
			->rawColumns(['action'])
			->make(true);
			}
		}

		return view('mh_accounts');
    }

    public function AddToMH(Request $request)
    {

        // $userInfo = self::UserInfo();

    	$validatedData = $request->validate([
        'mhin_head' => 'required|max:255',
        'mhin_amount' => 'required',
    	]);


        if ($request->mhin_amount<0) {
            $notification=array(
                'message'=>'Ammout Can Not Be Less Than Zero.',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    	$data = array();
    	$data['mhin_head']=$request->mhin_head;
    	$data['mhin_amount']=$request->mhin_amount;
    	$data['mhin_note']=$request->mhin_note;
        $data['mhin_user']=self::UserInfo();
    	$data['mhin_disburse']=$request->mhin_disburse." ".date("H:i:s");

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

    		$mhTotal  = $mhTotal+$request->mhin_amount;
    	//mhtotal adjust-------------------------------------------------------------------------------

		$user=DB::table('mhins')->insert($data);

		if ($user) {

        	$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'MH Data Inserted Successfully',
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
		$product = DB::table('mhins')->where($where)->first();
		return Response::json($product);
	}

	public function updateMh(Request $request)
    {
    	$validatedData = $request->validate([
        'mhin_head' => 'required|max:255',
        'mhin_amount' => 'required',
    	]);

    	$data = array();
    	$data['mhin_head']=$request->mhin_head;
    	$data['mhin_amount']=$request->mhin_amount;
    	$data['mhin_note']=$request->mhin_note;
        $data['mhin_user']=self::UserInfo();
    	$data['mhin_disburse']=$request->mhin_disburse." ".date("H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

    		$mhInfo = DB::table('mhins')->where('id',$request->id)->first();

    		if ($mhInfo->mhin_amount != $request->mhin_amount) {
				$mhTotal  = $mhTotal-$mhInfo->mhin_amount;  
				$mhTotal  = $mhTotal+$request->mhin_amount;  			
    		}

    		
    	//mhtotal adjust-------------------------------------------------------------------------------

		$user=DB::table('mhins')->where('id',$request->id)->update($data);

		if ($user) {

        	$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'MH Data Updated Successfully',
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
    //--------------------------------------------------------------------------------------------------------

    public function UserInfo()
    {
        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

        $userInfo = $Sessionuser->name ." : ".$Sessionuser->code;

        return $userInfo;
    }
}
