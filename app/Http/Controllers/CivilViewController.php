<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect,Response;
use Auth;

class CivilViewController extends Controller
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

            $getName = DB::table('civils')->where('id',$req->id)->first();

            $civils="";

            if ($From == 0 || $To==0) {
            	$civils = DB::table('civilsview')->where('civilview_id',$req->civil_id)->get();
       //      	echo "<pre>";
		    	// print_r($civils);
		    	// exit();
            }
            else{
            	$civils = DB::table('civilsview')
            	  ->where('civilview_id',$req->civil_id)
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
            }


            return view('Accounts.civilview',compact('civils','From','To','getName'));
        }
    }

    public function CivilPay(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();
        $allTotalcheck = DB::table('alltotals')->where('id',1)->first();
        $mhTotalcheck = $allTotalcheck->mhin_total;

        if ($mhTotalcheck<$request->civilview_credit) {
            $notification=array(
                'message'=>'Given Ammount is Greater Than Total Balance',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    	//Civil info--------------------------------------------------------
    		$civilInfo = explode(':', $request->civilview_name);

    		// $civil_id = $civilInfo[0];
    		$civilview_particulars = $civilInfo[0];
    		$civilview_id = $civilInfo[1];
    	//Civil info--------------------------------------------------------

        //Balance info update------------------------------------------------------------

        $civilBalance =  DB::table('civilsbalance')->where('civilb_id',$civilview_id)->first();

        if (empty($civilBalance )) {
            // echo "<pre>";
            // print_r("empty");
            // exit();

            $notification=array(
                'message'=>'Wrong Name & ID is Given',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

        $totalBalanceCivil = $civilBalance->civilb_balance;
        $totalBalanceCivil = $totalBalanceCivil+$request->civilview_credit;
        $totalBalanceCivil = $totalBalanceCivil-$request->civilview_debit;

        $balancedata = array();
        $balancedata['civilb_particulars'] = $civilBalance->civilb_particulars;
        $balancedata['civilb_id'] = $civilBalance->civilb_id;
        $balancedata['civilb_balance'] = $totalBalanceCivil;

        $balanceUpdate=DB::table('civilsbalance')->where('civilb_id',$civilBalance->civilb_id)->update($balancedata);


        //Balance info update------------------------------------------------------------

    		// $civilview_balance = $request->civilview_credit-$request->civilview_debit;

    	$data = array();
    	$data['civilview_particulars']=$civilview_particulars;
    	$data['civilview_id']=$civilview_id;
    	$data['civilview_folio']=$request->civilview_folio;
        $data['civilview_user']=self::UserInfo();
    	$data['civilview_credit']=$request->civilview_credit;
    	$data['civilview_debit']=$request->civilview_debit;
    	$data['civilview_balance']=$totalBalanceCivil;
    	$data['civilview_note']=$request->civilview_note;
    	$data['civilview_disburse']=$request->civilview_disburse." ".date('H:i:s');

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

			$mhTotal  = $mhTotal-$request->civilview_credit;  		
    	//mhtotal adjust-------------------------------------------------------------------------------

		$civilView = DB::table('civilsview')->insert($data);
		if ($civilView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'Civil Data Inserted Successfully',
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
		$product = DB::table('civilsview')->where($where)->first();
		return Response::json($product);
	}

	public function updateCivilPay(Request $request)
	{
		// echo "<pre>";
  //   	print_r($request->all());
  //   	exit();

		$civilCreditInfo = DB::table('civilsview')->where('id',$request->id)->first();

			$civilview_debit = $civilCreditInfo->civilview_debit+$request->civilview_paying;

			// if ($civilview_debit>$request->ocivilview_credit) {
			// 	$ocivilview_debit = $request->civilview_credit;
			// }

        //Balance info update------------------------------------------------------------

        $civilBalance =  DB::table('civilsbalance')->where('civilb_id',$civilCreditInfo->civilview_id)->first();

        $totalBalanceCivil = $civilBalance->civilb_balance;
        $totalBalanceCivil = $totalBalanceCivil-$civilCreditInfo->civilview_credit;
        $totalBalanceCivil = $totalBalanceCivil+$request->civilview_credit;

        $totalBalanceCivil = $totalBalanceCivil+$civilCreditInfo->civilview_debit;
        $totalBalanceCivil = $totalBalanceCivil-$request->civilview_debit;

        $balancedata = array();
        $balancedata['civilb_particulars'] = $civilBalance->civilb_particulars;
        $balancedata['civilb_id'] = $civilBalance->civilb_id;
        $balancedata['civilb_balance'] = $totalBalanceCivil;

        $balanceUpdate=DB::table('civilsbalance')->where('civilb_id',$civilBalance->civilb_id)->update($balancedata);
        //Balance info update------------------------------------------------------------

			// $civilview_balance = $request->civilview_credit-$civilview_debit;

		$data = array();
    	$data['civilview_particulars']=$request->civilview_particulars;
    	$data['civilview_id']=$request->civilview_id;
    	$data['civilview_folio']=$request->civilview_folio;
        $data['civilview_user']=self::UserInfo();
    	$data['civilview_credit']=$request->civilview_credit;
    	$data['civilview_debit']=$civilview_debit;
    	$data['civilview_balance']=$totalBalanceCivil;
    	$data['civilview_note']=$request->civilview_note;
    	$data['civilview_disburse']=$request->civilview_disburse." ".date('H:i:s');
        $data['updated_at'] = date("Y-m-d H:i:s");

    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

    		
    		if ($civilCreditInfo->civilview_credit != $request->civilview_credit) {
    			$mhTotal  = $mhTotal+$civilCreditInfo->civilview_credit;
    			$mhTotal  = $mhTotal-$request->civilview_credit;
    		}
			  		
    	//mhtotal adjust-------------------------------------------------------------------------------
    	$civilView = DB::table('civilsview')->where('id',$request->id)->update($data);
		if ($civilView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

        	//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('civils')->where('civil_id',$request->civilview_id)->first();

		 		$civils = DB::table('civilsview')->where('civilview_id',$request->civilview_id)->get();

		 		return view('Accounts.civilview',compact('civils','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
		else
		{
			//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('civils')->where('civil_id',$request->civilview_id)->first();

		 		$civils = DB::table('civilsview')->where('civilview_id',$request->civilview_id)->get();

		 		return view('Accounts.civilview',compact('civils','From','To','getName'));
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
