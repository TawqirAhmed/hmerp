@extends('home.home')
@section('content')


@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  if ($role !=1){

    echo "<pre>";
    echo '<h1 style="margin: auto; text-align: center; font-size: 70px">"You Shall Not Pass!!!!" &#129497;</h1>';
    exit();

  }
  
@endphp

<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<div class="content-page">
<!-- Start content -->
<div class="content">
    <div class="container">

        
	        <div class="row">

	        <!-- Add Category Form start-->
	        <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">Edit User Information</h3></div>
                        	@if ($errors->any())
          							    <div class="alert alert-danger">
          							        <ul>
          							            @foreach ($errors->all() as $error)
          							                <li>{{ $error }}</li>
          							            @endforeach
          							        </ul>
          							    </div>
          							@endif
                        <div class="panel-body">
                            <form class="form-horizontal" role="form"action="{{ url('/update-user/'.$editUser->id ) }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="name" value="{{ $editUser->name }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">User Code</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="code" value="{{ $editUser->code }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="email" value="{{ $editUser->email }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="password" value="" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">User Role</label>
                                    @php
                                    $roles=DB::table('user_roles')->get();
                                    @endphp
                                    <div class="col-sm-9">
                                    	<select name="role" class="form-control">
    	                                	<option value="" readonly>Select Role</option>
                                        	@foreach($roles as $row)
                                        		<option value="{{ $row->id }}" <?php if($editUser->role==$row->id){echo "selected";}?> >{{ $row->role_name }}</option>
                                        	@endforeach
                                      	</select>
                                    </div>
                                </div>
                                
                                <div class="form-group m-b-0">
                                    <div class="col-sm-offset-3 col-sm-9">
                                      <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col-->
            <!-- Add Category Form End -->

	        </div> 

    	</div> <!-- container -->
               
	</div> <!-- content -->
</div>

@endsection