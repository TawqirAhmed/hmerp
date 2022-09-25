<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

class SupplierController extends Controller
{
	public function index(Request $request)
    {
    	// $data = MH::latest()->get();
  //   	$data =DB::table('mh_info')->get();
  //   	echo "<pre>";
		// print_r($data);
		// exit();

    	if ($request->ajax()) {
		$data = DB::table('suppliers')->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-supplier" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-supplier" data-id='.$row->id.' class="btn btn-danger delete-supplier btn-sm"><i class="fas fa-trash"></i></a>';

		

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('suppliers');
    }

    public function StoreSupplier(Request $request)
    {
    	$validatedData = $request->validate([
        's_name' => 'required|max:255',
        's_code' => 'required|unique:suppliers',
        's_contact' => 'required',
    	]);

    	$data = array();
    	$data['s_name'] = $request->s_name;
    	$data['s_code'] = $request->s_code;
    	$data['s_contact'] = $request->s_contact;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('suppliers')->insert($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Supplier Created Successfully',
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
		$product = DB::table('suppliers')->where($where)->first();
		return Response::json($product);
	}

	public function updateSupplier(Request $request)
    {

    	$validatedData = $request->validate([
        's_name' => 'required|max:255',
        's_code' => 'required',
        's_contact' => 'required',
    	]);

		$data = array();
    	$data['s_name'] = $request->s_name;
    	$data['s_code'] = $request->s_code;
    	$data['s_contact'] = $request->s_contact;


        
        $user=DB::table('suppliers')->where('id',$request->id)->update($data);

        if ($user) {
            $notification=array(
                'message'=>'Update Supplier Successful',
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
        $product = DB::table('suppliers')->where('id',$id)->delete();
		return Response::json($product);
	}
    //--------------------------------------------------------------------------------------
}
