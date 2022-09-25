<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

class CustomerController extends Controller
{

	 public function index(Request $request)
    {
  //   	$data = DB::table('customers')->get();



  //   	echo "<pre>";
		// print_r($data);
		// exit();

    	if ($request->ajax()) {
		$data = DB::table('customers')->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('c_contact', function($row) {

					$datacon = json_decode($row->c_contact);

					$c_contact = $datacon[0]." ".$datacon[1]." ".$datacon[2]." ".$datacon[3];

                    return $c_contact;
                })
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-customer" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		';

		// <a id="delete-customer" data-id='.$row->id.' class="btn btn-danger delete-customer btn-sm"><i class="fas fa-trash"></i></a>

		

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('customers');
    }

    public function StoreCustomer(Request $request)
    {

    	
    	$validatedData = $request->validate([
        'c_name' => 'required|max:255',
        'c_code' => 'required|unique:customers',
    	]);

    	$lineOne = " ";
    	$lineTwo = " ";
    	$lineThree = " ";
    	$phoneNo = " ";

    	if ($request->line_one != null) {
    		$lineOne = $request->line_one;
    	} 
    	if ($request->line_two != null) {
    		$lineTwo = $request->line_two;
    	} 
    	if ($request->line_three != null) {
    		$lineThree = $request->line_three;
    	} 
    	if ($request->phone_no != null) {
    		$phoneNo = $request->phone_no;
    	} 
    	

    	$contacArray = [$lineOne,$lineTwo,$lineThree,$phoneNo];
    	$contactJSON = json_encode($contacArray);

    	// $contactJ = json_decode($contactJSON);
    	// echo "<pre>";
    	// print_r($contactJ);
    	// exit();

    	$data = array();
    	$data['c_name'] = $request->c_name;
    	$data['c_code'] = $request->c_code;
    	$data['c_contact'] = $contactJSON;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('customers')->insert($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Customer Created Successfully',
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
		$product = DB::table('customers')->where($where)->first();
		return Response::json($product);
	}

	public function updateCustomer(Request $request)
    {
    	$validatedData = $request->validate([
        'c_name' => 'required|max:255',
    	]);

    	$lineOne = " ";
    	$lineTwo = " ";
    	$lineThree = " ";
    	$phoneNo = " ";

    	if ($request->line_one != null) {
    		$lineOne = $request->line_one;
    	} 
    	if ($request->line_two != null) {
    		$lineTwo = $request->line_two;
    	} 
    	if ($request->line_three != null) {
    		$lineThree = $request->line_three;
    	} 
    	if ($request->phone_no != null) {
    		$phoneNo = $request->phone_no;
    	} 
    	

    	$contacArray = [$lineOne,$lineTwo,$lineThree,$phoneNo];
    	$contactJSON = json_encode($contacArray);

    	$data = array();
    	$data['c_name'] = $request->c_name;
    	$data['c_code'] = $request->c_code;
    	$data['c_contact'] = $contactJSON;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('customers')->where('id',$request->id)->update($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Customer Updated Successfully',
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

    public function destroy($id)
	{
        $product = DB::table('customers')->where('id',$id)->delete();
		return Response::json($product);
	}
    //
}
