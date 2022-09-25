<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect,Response;
use Auth;

class ICTViewController extends Controller
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

            $getName = DB::table('icts')->where('id',$req->id)->first();

            $icts="";

            if ($From == 0 || $To==0) {
            	$icts = DB::table('ictsview')->where('ictview_id',$req->ict_id)->get();
       //      	echo "<pre>";
		    	// print_r($icts);
		    	// exit();
            }
            else{
            	$icts = DB::table('ictsview')
            	  ->where('ictview_id',$req->ict_id)
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
            }


            return view('Accounts.ictview',compact('icts','From','To','getName'));
        }
    }

    public function ICTPay(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

        $allTotalcheck = DB::table('alltotals')->where('id',1)->first();
        $mhTotalcheck = $allTotalcheck->mhin_total;

        if ($mhTotalcheck<$request->ictview_credit) {
            $notification=array(
                'message'=>'Given Ammount is Greater Than Total Balance',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    	//ICT info--------------------------------------------------------
    		$ictInfo = explode(':', $request->ictview_name);

    		// $ict_id = $ictInfo[0];
    		$ictview_particulars = $ictInfo[0];
    		$ictview_id = $ictInfo[1];
    	//ICT info--------------------------------------------------------

        //Balance info update------------------------------------------------------------

        $ictBalance =  DB::table('ictsbalance')->where('ictb_id',$ictview_id)->first();

        if (empty($ictBalance )) {
            // echo "<pre>";
            // print_r("empty");
            // exit();

            $notification=array(
                'message'=>'Wrong Name & ID is Given',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

        $totalBalanceICT = $ictBalance->ictb_balance;
        $totalBalanceICT = $totalBalanceICT+$request->ictview_credit;
        $totalBalanceICT = $totalBalanceICT-$request->ictview_debit;

        $balancedata = array();
        $balancedata['ictb_particulars'] = $ictBalance->ictb_particulars;
        $balancedata['ictb_id'] = $ictBalance->ictb_id;
        $balancedata['ictb_balance'] = $totalBalanceICT;

        $balanceUpdate=DB::table('ictsbalance')->where('ictb_id',$ictBalance->ictb_id)->update($balancedata);


        //Balance info update------------------------------------------------------------

    		// $ictview_balance = $request->ictview_credit-$request->ictview_debit;

    	$data = array();
    	$data['ictview_particulars']=$ictview_particulars;
    	$data['ictview_id']=$ictview_id;
    	$data['ictview_folio']=$request->ictview_folio;
        $data['ictview_user']=self::UserInfo();
    	$data['ictview_credit']=$request->ictview_credit;
    	$data['ictview_debit']=$request->ictview_debit;
    	$data['ictview_balance']=$totalBalanceICT;
    	$data['ictview_note']=$request->ictview_note;
    	$data['ictview_disburse']=$request->ictview_disburse." ".date('H:i:s');

    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

			$mhTotal  = $mhTotal-$request->ictview_credit;  		
    	//mhtotal adjust-------------------------------------------------------------------------------

		$ictView = DB::table('ictsview')->insert($data);
		if ($ictView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'ICT Data Inserted Successfully',
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
		$product = DB::table('ictsview')->where($where)->first();
		return Response::json($product);
	}

	public function updateICTPay(Request $request)
	{
		// echo "<pre>";
  //   	print_r($request->all());
  //   	exit();

		$ictCreditInfo = DB::table('ictsview')->where('id',$request->id)->first();

			$ictview_debit = $ictCreditInfo->ictview_debit+$request->ictview_paying;

			// if ($ictview_debit>$request->ictview_credit) {
			// 	$ictview_debit = $request->ictview_credit;
			// }


        //Balance info update------------------------------------------------------------

        $ictBalance =  DB::table('ictsbalance')->where('ictb_id',$ictCreditInfo->ictview_id)->first();

        $totalBalanceICT = $ictBalance->ictb_balance;
        $totalBalanceICT = $totalBalanceICT-$ictCreditInfo->ictview_credit;
        $totalBalanceICT = $totalBalanceICT+$request->ictview_credit;

        $totalBalanceICT = $totalBalanceICT+$ictCreditInfo->ictview_debit;
        $totalBalanceICT = $totalBalanceICT-$request->ictview_debit;

        $balancedata = array();
        $balancedata['ictb_particulars'] = $ictBalance->ictb_particulars;
        $balancedata['ictb_id'] = $ictBalance->ictb_id;
        $balancedata['ictb_balance'] = $totalBalanceICT;

        $balanceUpdate=DB::table('ictsbalance')->where('ictb_id',$ictBalance->ictb_id)->update($balancedata);
        //Balance info update------------------------------------------------------------

			// $ictview_balance = $request->ictview_credit-$ictview_debit;

		$data = array();
    	$data['ictview_particulars']=$request->ictview_particulars;
    	$data['ictview_id']=$request->ictview_id;
    	$data['ictview_folio']=$request->ictview_folio;
        $data['ictview_user']=self::UserInfo();
    	$data['ictview_credit']=$request->ictview_credit;
    	$data['ictview_debit']=$ictview_debit;
    	$data['ictview_balance']=$totalBalanceICT;
    	$data['ictview_note']=$request->ictview_note;
    	$data['ictview_disburse']=$request->ictview_disburse." ".date('H:i:s');
        $data['updated_at'] = date("Y-m-d H:i:s");

    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

    		
    		if ($ictCreditInfo->ictview_credit != $request->ictview_credit) {
    			$mhTotal  = $mhTotal+$ictCreditInfo->ictview_credit;
    			$mhTotal  = $mhTotal-$request->ictview_credit;
    		}
			  		
    	//mhtotal adjust-------------------------------------------------------------------------------
    	$ictView = DB::table('ictsview')->where('id',$request->id)->update($data);
		if ($ictView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

        	//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('icts')->where('ict_id',$request->ictview_id)->first();

		 		$icts = DB::table('ictsview')->where('ictview_id',$request->ictview_id)->get();

		 		return view('Accounts.ictview',compact('icts','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
		else
		{
			//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('icts')->where('ict_id',$request->ictview_id)->first();

		 		$icts = DB::table('ictsview')->where('ictview_id',$request->ictview_id)->get();

		 		return view('Accounts.ictview',compact('icts','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
	}
//---------------------------------------------------------------------------------------------
    public function UserInfo()
    {
        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

        $userInfo = $Sessionuser->name ." : ".$Sessionuser->code;

        return $userInfo;
    }
    
}
