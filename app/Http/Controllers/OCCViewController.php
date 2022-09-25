<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect,Response;
use Auth;

class OCCViewController extends Controller
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

            $getName = DB::table('occs')->where('id',$req->id)->first();

            $occs="";

            if ($From == 0 || $To==0) {
            	$occs = DB::table('occsview')->where('occview_id',$req->occ_id)->get();
       //      	echo "<pre>";
		    	// print_r($occs);
		    	// exit();
            }
            else{
            	$occs = DB::table('occsview')
            	  ->where('occview_id',$req->occ_id)
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
            }


            return view('Accounts.occview',compact('occs','From','To','getName'));
        }
    }

    public function OCCPay(Request $request)
    {
    	// echo "<pre>";
    	// print_r($request->all());
    	// exit();

        // $allTotalcheck = DB::table('alltotals')->where('id',1)->first();
        // $mhTotalcheck = $allTotalcheck->mhin_total;

        // if ($mhTotalcheck<$request->occview_credit) {
        //     $notification=array(
        //         'message'=>'Given Ammount is Greater Than Total Balance',
        //         'alert-type'=>'error'
        //     );
        //     return Redirect()->back()->with($notification);
        // }



    	//OCC info--------------------------------------------------------
    		$occInfo = explode(':', $request->occview_name);

    		// $occ_id = $occInfo[0];
    		$occview_particulars = $occInfo[0];
    		$occview_id = $occInfo[1];
    	//OCC info--------------------------------------------------------

        //Balance info update------------------------------------------------------------

        $occBalance =  DB::table('occsbalance')->where('occb_id',$occview_id)->first();

        if (empty($occBalance )) {
            // echo "<pre>";
            // print_r("empty");
            // exit();

            $notification=array(
                'message'=>'Wrong Name & ID is Given',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }


        $totalBalanceOCC = $occBalance->occb_balance;
        $totalBalanceOCC = $totalBalanceOCC+$request->occview_credit;
        $totalBalanceOCC = $totalBalanceOCC-$request->occview_debit;

        $balancedata = array();
        $balancedata['occb_particulars'] = $occBalance->occb_particulars;
        $balancedata['occb_id'] = $occBalance->occb_id;
        $balancedata['occb_balance'] = $totalBalanceOCC;

        $balanceUpdate=DB::table('occsbalance')->where('occb_id',$occBalance->occb_id)->update($balancedata);


        //Balance info update------------------------------------------------------------

    		// $occview_balance = $request->occview_credit-$request->occview_debit;

    	$data = array();
    	$data['occview_particulars']=$occview_particulars;
    	$data['occview_id']=$occview_id;
    	$data['occview_folio']=$request->occview_folio;
        $data['occview_user']=self::UserInfo();
    	$data['occview_credit']=$request->occview_credit;
    	$data['occview_debit']=$request->occview_debit;
    	$data['occview_balance']=$totalBalanceOCC;
    	$data['occview_note']=$request->occview_note;
    	$data['occview_disburse']=$request->occview_disburse." ".date('H:i:s');

    	//mhtotal adjust-------------------------------------------------------------------------------
   //  		$allTotal = DB::table('alltotals')->where('id',1)->first();
   //  		$mhTotal = $allTotal->mhin_total;

			// $mhTotal  = $mhTotal-$request->occview_credit;  		
    	//mhtotal adjust-------------------------------------------------------------------------------

		$occView = DB::table('occsview')->insert($data);
		if ($occView) {
			// $dataTotal = array();
	  //   	$dataTotal['mhin_total'] = $mhTotal;

   //      	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

	 		$notification=array(
	 			'message'=>'OCC Data Inserted Successfully',
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
		$product = DB::table('occsview')->where($where)->first();
		return Response::json($product);
	}

	public function updateOCCPay(Request $request)
	{
		// echo "<pre>";
  //   	print_r($request->all());
  //   	exit();

		$occCreditInfo = DB::table('occsview')->where('id',$request->id)->first();

			$occview_debit = $occCreditInfo->occview_debit+$request->occview_paying;

			// if ($occview_debit>$request->occview_credit) {
			// 	$occview_debit = $request->occview_credit;
			// }

        //Balance info update------------------------------------------------------------

        $occBalance =  DB::table('occsbalance')->where('occb_id',$occCreditInfo->occview_id)->first();

        $totalBalanceOCC = $occBalance->occb_balance;
        $totalBalanceOCC = $totalBalanceOCC-$occCreditInfo->occview_credit;
        $totalBalanceOCC = $totalBalanceOCC+$request->occview_credit;

        $totalBalanceOCC = $totalBalanceOCC+$occCreditInfo->occview_debit;
        $totalBalanceOCC = $totalBalanceOCC-$request->occview_debit;

        $balancedata = array();
        $balancedata['occb_particulars'] = $occBalance->occb_particulars;
        $balancedata['occb_id'] = $occBalance->occb_id;
        $balancedata['occb_balance'] = $totalBalanceOCC;

        $balanceUpdate=DB::table('occsbalance')->where('occb_id',$occBalance->occb_id)->update($balancedata);
        //Balance info update------------------------------------------------------------


			// $occview_balance = $request->occview_credit-$occview_debit;

		$data = array();
    	$data['occview_particulars']=$request->occview_particulars;
    	$data['occview_id']=$request->occview_id;
    	$data['occview_folio']=$request->occview_folio;
        $data['occview_user']=self::UserInfo();
    	$data['occview_credit']=$request->occview_credit;
    	$data['occview_debit']=$occview_debit;
    	$data['occview_balance']=$totalBalanceOCC;
    	$data['occview_note']=$request->occview_note;
    	$data['occview_disburse']=$request->occview_disburse." ".date('H:i:s');
        $data['updated_at'] = date("Y-m-d H:i:s");
    	//mhtotal adjust-------------------------------------------------------------------------------
    		// $allTotal = DB::table('alltotals')->where('id',1)->first();
    		// $mhTotal = $allTotal->mhin_total;

    		
    		// if ($occCreditInfo->occview_credit != $request->occview_credit) {
    		// 	$mhTotal  = $mhTotal+$occCreditInfo->occview_credit;
    		// 	$mhTotal  = $mhTotal-$request->occview_credit;
    		// }
			  		
    	//mhtotal adjust-------------------------------------------------------------------------------
    	$occView = DB::table('occsview')->where('id',$request->id)->update($data);
		if ($occView) {
			// $dataTotal = array();
	  //   	$dataTotal['mhin_total'] = $mhTotal;

   //      	$updateTotal = DB::table('alltotals')->where('id',1)->update($dataTotal);

        	//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('occs')->where('occ_id',$request->occview_id)->first();

		 		$occs = DB::table('occsview')->where('occview_id',$request->occview_id)->get();

		 		return view('Accounts.occview',compact('occs','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
		else
		{
			//------------------------------------------------------------------------------
		    	$From=0;
		 		$To=0;
		 		$getName = DB::table('occs')->where('occ_id',$request->occview_id)->first();

		 		$occs = DB::table('occsview')->where('occview_id',$request->occview_id)->get();

		 		return view('Accounts.occview',compact('occs','From','To','getName'));
		 		//------------------------------------------------------------------------------
		}
	}

//---------------------------------------------------------------------------------------
    public function UserInfo()
    {
        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

        $userInfo = $Sessionuser->name ." : ".$Sessionuser->code;

        return $userInfo;
    }
}
