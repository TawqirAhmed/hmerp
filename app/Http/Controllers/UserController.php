<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	 public function index()
    {
    	$users=DB::table('users')
		    	->join('user_roles','users.role','user_roles.id')
		    	->select('user_roles.role_name','users.*')
		    	->get();

		$roles=DB::table('user_roles')->get();
		
    	return view('users.users', compact('users','roles'));
    }

    public function StoreUser(Request $request)
    {
    	$validatedData = $request->validate([
        'name' => 'required|max:255',
        'code' => 'required|unique:users',
        'email' => 'required|unique:users',
        'password' => 'required',
    	]);

    	$data = array();
    	$data['name'] = $request->name;
        $data['code'] = $request->code;
    	$data['email'] = $request->email;
    	$data['password'] = Hash::make($request->password);
    	$data['role'] = $request->role;

    	// echo "<pre>";
    	// print_r($data);
    	// exit();
    	$user=DB::table('users')->insert($data);
    	
        if ($user) {
	 		$notification=array(
	 			'message'=>'User Created Successfully',
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


    public function EditUser($id)
    {
    	$editUser = DB::table('users')
                        ->where('id',$id)
                        ->first();
        return view('users.edit_user', compact('editUser'));
    }


    public function UpdateUser(Request $request,$id)
    {
    	$validatedData = $request->validate([
        'name' => 'required|max:255',
        'code' => 'required|max:255',
        'email' => 'required',
        'password' => 'required',
    	]);

		$data = array();
    	$data['name'] = $request->name;
        $data['code'] = $request->code;
    	$data['email'] = $request->email;
    	$data['password'] = Hash::make($request->password);
    	$data['role'] = $request->role;


        $Userinfo = DB::table('users')
                        ->where('id',$id)
                        ->first();
        $user=DB::table('users')->where('id',$id)->update($data);

        if ($user) {
            $notification=array(
                'message'=>'Update User Successful',
                'alert-type'=>'success'
            );
            return Redirect()->route('users')->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
    }
    
    public function DeleteUser($id)
    {
    	 $deleteUser = DB::table('users')
                        ->where('id',$id)
                        ->first();


        $dltUser= DB::table('users')
                        ->where('id',$id)
                        ->delete();

        if ($dltUser) {
                    $notification=array(
                        'message'=>'Successfully User Deleted',
                        'alert-type'=>'success'
                    );
                    return Redirect()->route('users')->with($notification);

                }else{
                    $notification=array(
                        'message'=>'Something Went Wrong',
                        'alert-type'=>'error'
                    );
                    return Redirect()->back()->with($notification);
                }
    }
	
//-----------------------------------------------------------------------------------------------    
}
