<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect,Response;
use Auth;

class OthersViewController extends Controller
{
	public function index(Request $req)
    {
    	// echo "<pre>";
    	// print_r($req->all());
    	// exit();

    	$method = $req->method();

        if ($req->isMethod('post'))
        {
        	$From = $req->input('from');
            $To   = $req->input('to');

            $getName = DB::table('others')->where('id',$req->id)->first();

            $others="";

            if ($From == 0 || $To==0) {
            	$others = DB::table('othersview')->where('othersview_id',$req->others_id)->get();
       //      	echo "<pre>";
		    	// print_r($others);
		    	// exit();
            }
            else{
            	$others = DB::table('othersview')
            	  ->where('othersview_id',$req->others_id)
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
            }


            return view('Accounts.othersview',compact('others','From','To','getName'));
        }
    }

    public function OthersPay(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

        $allTotalcheck = DB::table('alltotals')->where('id',1)->first();
        $mhTotalcheck = $allTotalcheck->mhin_total;

        if ($mhTotalcheck<$request->othersview_credit) {
            $notification=array(
                'message'=>'Given Ammount is Greater Than Total Balance',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    	//Others info--------------------------------------------------------
    		$othersInfo = explode(':', $request->othersview_name);

    		// $others_id = $othersInfo[0];
    		$othersview_particulars = $othersInfo[0];
    		$othersview_id = $othersInfo[1];
    	//Others info--------------------------------------------------------

         //Balance info update------------------------------------------------------------

        $othersBalance =  DB::table('othersbalance')->where('othersb_id',$othersview_id)->first();

        if (empty($othersBalance )) {
            // echo "<pre>";
            // print_r("empty");
            // exit();

            $notification=array(
                'message'=>'Wrong Name & ID is Given',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }


        $totalBalanceOthers = $othersBalance->othersb_balance;
        $totalBalanceOthers = $totalBalanceOthers+$request->othersview_credit;
        $totalBalanceOthers = $totalBalanceOthers-$request->othersview_debit;

        $balancedata = array();
        $balancedata['othersb_particulars'] = $othersBalance->othersb_particulars;
        $balancedata['othersb_id'] = $othersBalance->othersb_id;
        $balancedata['othersb_balance'] = $totalBalanceOthers;

        $balanceUpdate=DB::table('othersbalance')->where('othersb_id',$othersBalance->othersb_id)->update($balancedata);


        //Balance info update------------------------------------------------------------

    		// $othersview_balance = $request->othersview_credit-$request->othersview_debit;

    	$data = array();
    	$data['othersview_particulars']=$othersview_particulars;
    	$data['othersview_id']=$othersview_id;
    	$data['othersview_folio']=$request->othersview_folio;
        $data['othersview_user']=self::UserInfo();
    	$data['othersview_credit']=$request->othersview_credit;
    	$data['othersview_debit']=$request->othersview_debit;
    	$data['othersview_balance']=$totalBalanceOthers;
    	$data['othersview_note']=$request->othersview_note;
    	$data['othersview_disburse']=$request->othersview_disburse." ".date('H:i:s');

    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

			$mhTotal  = $mhTotal-$request->othersview_credit;  		
    	//mhtotal adjust-------------------------------------------------------------------------------

		$othersView = DB::table('othersview')->insert($data);
		if ($othersView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'Others Data Inserted Successfully',
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
		$product = DB::table('othersview')->where($where)->first();
		return Response::json($product);
	}
	public function updateOthersPay(Request $request)
	{
		// echo "<pre>";
  //   	print_r($request->all());
  //   	exit();

		$othersCreditInfo = DB::table('othersview')->where('id',$request->id)->first();

			$othersview_debit = $othersCreditInfo->othersview_debit+$request->othersview_paying;

			// if ($othersview_debit>$request->othersview_credit) {
			// 	$othersview_debit = $request->othersview_credit;
			// }


        //Balance info update------------------------------------------------------------

        $othersBalance =  DB::table('othersbalance')->where('othersb_id',$othersCreditInfo->othersview_id)->first();

        $totalBalanceOthers = $othersBalance->othersb_balance;
        $totalBalanceOthers = $totalBalanceOthers-$othersCreditInfo->othersview_credit;
        $totalBalanceOthers = $totalBalanceOthers+$request->othersview_credit;

        $totalBalanceOthers = $totalBalanceOthers+$othersCreditInfo->othersview_debit;
        $totalBalanceOthers = $totalBalanceOthers-$request->othersview_debit;

        $balancedata = array();
        $balancedata['othersb_particulars'] = $othersBalance->othersb_particulars;
        $balancedata['othersb_id'] = $othersBalance->othersb_id;
        $balancedata['othersb_balance'] = $totalBalanceOthers;

        $balanceUpdate=DB::table('othersbalance')->where('othersb_id',$othersBalance->othersb_id)->update($balancedata);
        //Balance info update------------------------------------------------------------

			// $othersview_balance = $request->othersview_credit-$othersview_debit;

		$data = array();
    	$data['othersview_particulars']=$request->othersview_particulars;
    	$data['othersview_id']=$request->othersview_id;
    	$data['othersview_folio']=$request->othersview_folio;
        $data['othersview_user']=self::UserInfo();
    	$data['othersview_credit']=$request->othersview_credit;
    	$data['othersview_debit']=$othersview_debit;
    	$data['othersview_balance']=$totalBalanceOthers;
    	$data['othersview_note']=$request->othersview_note;
    	$data['othersview_disburse']=$request->othersview_disburse." ".date('H:i:s');
        $data['updated_at'] = date("Y-m-d H:i:s");
    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

    		
    		if ($othersCreditInfo->othersview_credit != $request->othersview_credit) {
    			$mhTotal  = $mhTotal+$othersCreditInfo->othersview_credit;
    			$mhTotal  = $mhTotal-$request->othersview_credit;
    		}
			  		
    	//mhtotal adjust-------------------------------------------------------------------------------
    	$othersView = DB::table('othersview')->where('id',$request->id)->update($data);
		if ($othersView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

        	//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('others')->where('others_id',$request->othersview_id)->first();

		 		$others = DB::table('othersview')->where('othersview_id',$request->othersview_id)->get();

		 		return view('Accounts.othersview',compact('others','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
		else
		{
			//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('others')->where('others_id',$request->othersview_id)->first();

		 		$others = DB::table('othersview')->where('othersview_id',$request->othersview_id)->get();

		 		return view('Accounts.othersview',compact('others','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
	}
//-----------------------------------------------------------------------------------------------
    public function UserInfo()
    {
        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

        $userInfo = $Sessionuser->name ." : ".$Sessionuser->code;

        return $userInfo;
    }

    
}
