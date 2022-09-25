<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect,Response;
use Auth;

class SuppliesViewController extends Controller
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

            $getName = DB::table('supplies')->where('id',$req->id)->first();

            $supplies="";

            if ($From == 0 || $To==0) {
            	$supplies = DB::table('suppliesview')->where('suppliesview_id',$req->supplies_id)->get();
       //      	echo "<pre>";
		    	// print_r($occs);
		    	// exit();
            }
            else{
       //      	echo "<pre>";
		    	// print_r($req->all());
		    	// exit();
            	$supplies = DB::table('suppliesview')
            	  ->where('suppliesview_id',$req->supplies_id)
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
            }


            return view('Accounts.supplyview',compact('supplies','From','To','getName'));
        }
    }

    public function SupplyPay(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();


        $allTotalcheck = DB::table('alltotals')->where('id',1)->first();
        $mhTotalcheck = $allTotalcheck->mhin_total;

        if ($mhTotalcheck<$request->suppliesview_credit) {
            $notification=array(
                'message'=>'Given Ammount is Greater Than Total Balance',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    	//Supplies info--------------------------------------------------------
    		$suppliesInfo = explode(':', $request->suppliesview_particulars);

    		// $supplies_id = $suppliesInfo[0];
    		$suppliesview_particulars = $suppliesInfo[0];
    		$suppliesview_id = $suppliesInfo[1];
    	//Supplies info--------------------------------------------------------

        //Balance info update------------------------------------------------------------

        $suppliesBalance =  DB::table('suppliesbalance')->where('suppliesb_id',$suppliesview_id)->first();

        if (empty($suppliesBalance )) {
            // echo "<pre>";
            // print_r("empty");
            // exit();

            $notification=array(
                'message'=>'Wrong District & ID is Given',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

        $totalBalanceSupplies = $suppliesBalance->suppliesb_balance;
        $totalBalanceSupplies = $totalBalanceSupplies+$request->suppliesview_credit;
        $totalBalanceSupplies = $totalBalanceSupplies-$request->suppliesview_debit;

        $balancedata = array();
        $balancedata['suppliesb_particulars'] = $suppliesBalance->suppliesb_particulars;
        $balancedata['suppliesb_id'] = $suppliesBalance->suppliesb_id;
        $balancedata['suppliesb_balance'] = $totalBalanceSupplies;

        $balanceUpdate=DB::table('suppliesbalance')->where('suppliesb_id',$suppliesBalance->suppliesb_id)->update($balancedata);


        //Balance info update------------------------------------------------------------


    		// $suppliesview_balance = $request->suppliesview_credit-$request->suppliesview_debit;

    	$data = array();
    	$data['suppliesview_name']=$request->suppliesview_name;
    	$data['suppliesview_particulars']=$suppliesview_particulars;
    	$data['suppliesview_id']=$suppliesview_id;
    	$data['suppliesview_folio']=$request->suppliesview_folio;
        $data['suppliesview_user']=self::UserInfo();
    	$data['suppliesview_credit']=$request->suppliesview_credit;
    	$data['suppliesview_debit']=$request->suppliesview_debit;
    	$data['suppliesview_balance']=$totalBalanceSupplies;
    	$data['suppliesview_note']=$request->suppliesview_note;
    	$data['suppliesview_disburse']=$request->suppliesview_disburse." ".date('H:i:s');

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

			$mhTotal  = $mhTotal-$request->suppliesview_credit;  		
    	//mhtotal adjust-------------------------------------------------------------------------------

		$suppliesView = DB::table('suppliesview')->insert($data);
		if ($suppliesView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'Supply Data Inserted Successfully',
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
		$product = DB::table('suppliesview')->where($where)->first();
		return Response::json($product);
	}

	public function updateSupplyPay(Request $request)
	{
		// echo "<pre>";
  //   	print_r($request->all());
  //   	exit();

		$suppliesCreditInfo = DB::table('suppliesview')->where('id',$request->id)->first();

			$suppliesview_debit = $suppliesCreditInfo->suppliesview_debit+$request->suppliesview_paying;

			// if ($suppliesview_debit>$request->suppliesview_credit) {
			// 	$suppliesview_debit = $request->suppliesview_credit;
			// }


        //Balance info update------------------------------------------------------------

        $suppliesBalance =  DB::table('suppliesbalance')->where('suppliesb_id',$suppliesCreditInfo->suppliesview_id)->first();

        $totalBalanceSupplies = $suppliesBalance->suppliesb_balance;
        $totalBalanceSupplies = $totalBalanceSupplies-$suppliesCreditInfo->suppliesview_credit;
        $totalBalanceSupplies = $totalBalanceSupplies+$request->suppliesview_credit;

        $totalBalanceSupplies = $totalBalanceSupplies+$suppliesCreditInfo->suppliesview_debit;
        $totalBalanceSupplies = $totalBalanceSupplies-$request->suppliesview_debit;

        $balancedata = array();
        $balancedata['suppliesb_particulars'] = $suppliesBalance->suppliesb_particulars;
        $balancedata['suppliesb_id'] = $suppliesBalance->suppliesb_id;
        $balancedata['suppliesb_balance'] = $totalBalanceSupplies;

        $balanceUpdate=DB::table('suppliesbalance')->where('suppliesb_id',$suppliesBalance->suppliesb_id)->update($balancedata);
        //Balance info update------------------------------------------------------------

			// $suppliesview_balance = $request->suppliesview_credit-$suppliesview_debit;

		$data = array();
		$data['suppliesview_name']=$request->suppliesview_name;
    	$data['suppliesview_particulars']=$request->suppliesview_particulars;
    	$data['suppliesview_id']=$request->suppliesview_id;
    	$data['suppliesview_folio']=$request->suppliesview_folio;
        $data['suppliesview_user']=self::UserInfo();
    	$data['suppliesview_credit']=$request->suppliesview_credit;
    	$data['suppliesview_debit']=$suppliesview_debit;
    	$data['suppliesview_balance']=$totalBalanceSupplies;
    	$data['suppliesview_note']=$request->suppliesview_note;
    	$data['suppliesview_disburse']=$request->suppliesview_disburse." ".date('H:i:s');
        $data['updated_at'] = date("Y-m-d H:i:s");
    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	//mhtotal adjust-------------------------------------------------------------------------------
    		$allTotal = DB::table('alltotals')->where('id',1)->first();
    		$mhTotal = $allTotal->mhin_total;

    		
    		if ($suppliesCreditInfo->suppliesview_credit != $request->suppliesview_credit) {
    			$mhTotal  = $mhTotal+$suppliesCreditInfo->suppliesview_credit;
    			$mhTotal  = $mhTotal-$request->suppliesview_credit;
    		}
			  		
    	//mhtotal adjust-------------------------------------------------------------------------------
    	$suppliesView = DB::table('suppliesview')->where('id',$request->id)->update($data);
		if ($suppliesView) {
			$dataTotal = array();
	    	$dataTotal['mhin_total'] = $mhTotal;

        	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

        	//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('supplies')->where('supplies_id',$request->suppliesview_id)->first();

		 		$supplies = DB::table('suppliesview')->where('suppliesview_id',$request->suppliesview_id)->get();

		 		return view('Accounts.supplyview',compact('supplies','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
		else
		{
			//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('supplies')->where('supplies_id',$request->suppliesview_id)->first();

		 		$supplies = DB::table('suppliesview')->where('suppliesview_id',$request->suppliesview_id)->get();

		 		return view('Accounts.supplyview',compact('supplies','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
	}
//------------------------------------------------------------------------------------------------
    public function UserInfo()
    {
        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

        $userInfo = $Sessionuser->name ." : ".$Sessionuser->code;

        return $userInfo;
    }
    
}
