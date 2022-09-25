<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

class EmployeesController extends Controller
{
	public function index(Request $request)
    {
    	// $data = MH::latest()->get();
  //   	$data =DB::table('mh_info')->get();
  //   	echo "<pre>";
		// print_r($data);
		// exit();

    	if ($request->ajax()) {
		$data = DB::table('employees')->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-employees" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-employees" data-id='.$row->id.' class="btn btn-danger delete-employees btn-sm"><i class="fas fa-trash"></i></a>';

		

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('employees');
    }

    public function StoreEmployees(Request $request)
    {
    	$validatedData = $request->validate([
        'e_name' => 'required|max:255',
        'e_code' => 'required|unique:employees',
    	]);

    	$data = array();
    	$data['e_name'] = $request->e_name;
    	$data['e_code'] = $request->e_code;
        $data['e_contact'] = $request->e_contact;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('employees')->insert($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'Employee Created Successfully',
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
		$product = DB::table('employees')->where($where)->first();
		return Response::json($product);
	}

	public function updateEmployees(Request $request)
    {

    	$validatedData = $request->validate([
        'e_name' => 'required|max:255',
        'e_code' => 'required',
        ]);

		$data = array();
    	$data['e_name'] = $request->e_name;
    	$data['e_code'] = $request->e_code;
        $data['e_contact'] = $request->e_contact;


        
        $user=DB::table('employees')->where('id',$request->id)->update($data);

        if ($user) {
            $notification=array(
                'message'=>'Update Employee Successful',
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
        $product = DB::table('employees')->where('id',$id)->delete();
		return Response::json($product);
	}
    //------------------------------------------------------------------------------------------
}
