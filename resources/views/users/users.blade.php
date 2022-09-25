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


  <h1 style="text-align: center;">All Users</h1>
<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1 class="m-0 text-dark">All Users</h1> --}}
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!--/table starts-->
<div class="card">
	<div class="card-header">
		{{-- <h3 class="card-title">Users</h3> --}}
		<a style="color:white" class="btn btn-success float-right" data-toggle="modal" data-target="#modalAddUser">New User</a>               
	</div>
  <!-- /.card-header -->
  <div class="card-body">
  	 <div class="box-body">

        <!--==========================
          =  Table for  Users    =
          ===========================-->

        <table id="datatable" class="table table-bordered table-striped dt-responsive tables" width="100%">
          
          <thead>
            
            <tr>
              
              <th class="text-center" style="width:10px">S/N</th>
              <th class="text-center">Name</th>
              <th class="text-center">Code</th>
              <th class="text-center">Email</th>
              <th class="text-center">Role</th>
              <th class="text-center">Action</th>

            </tr>

          </thead>

          <tbody>
          	@foreach($users as $row)
                <tr>
                	<td class="text-center">{{ $row->id }}</td>
                    <td class="text-center">{{ $row->name }}</td>
                    <td class="text-center">{{ $row->code }}</td>
                    <td class="text-center">{{ $row->email }}</td>
                    <td class="text-center">{{ $row->role_name }}</td>
                    <td class="text-center">
                      <div class="btn-group">
                      	<a href="{{ URL::to('edit-user/'.$row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @if($Sessionid!=$row->id)
                      	<a href="{{ URL::to('/delete-user/'.$row->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
                        @endif
                      </div>
                    </td>
                </tr>
            @endforeach
          </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->




<!--==========================
  =  Modal window for Add Users    =
  ===========================-->

<!-- Modal -->
<div id="modalAddUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" action="{{ url('/add-user') }}" method="post" enctype="multipart/form-data">
      	@csrf
        <!--=====================================
            MODAL HEADER
        ======================================-->  
          <div class="modal-header" style="background: #000080; color: white">
          	<h4 class="modal-title">Registration Form</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <!--=====================================
            MODAL BODY
          ======================================-->
          <div class="modal-body">
            <div class="box-body">
            	@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
              <!-- TAKING NAME FOR NEW USER -->
              <div class="form-group">          
                <div class="input-group">             
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                  <input type="text" class="form-control input-lg" name="name" placeholder="Name" required>
                </div>
              </div>

              <div class="form-group">          
                <div class="input-group">             
                  <span class="input-group-addon"><i class="far fa-id-card"></i></i></i></span>&nbsp;&nbsp;
                  <input type="text" class="form-control input-lg" name="code" placeholder="User Code" required>
                </div>
              </div>
              
              <!-- TAKING USER EMAIL FOR NEW USER -->
              
              <div class="form-group">      
                <div class="input-group">                 
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>&nbsp;&nbsp;
                  <input type="email" class="form-control input-lg" name="email" placeholder="Email" id="newemail" required>
                </div>
              </div>
              <!-- TAKING PASSWORD FOR NEW USER -->
              
              <div class="form-group">
                <div class="input-group">                 
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>&nbsp;&nbsp;
                  <input type="password" class="form-control input-lg" name="password" placeholder="Password" required>
                </div>
              </div>
             
              <!-- SELECTING ROLE FOR NEW USER -->             
              <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>&nbsp;&nbsp;
                    <select class="form-control input-lg" name="role">
                      <option value="" disabled selected>Select profile</option>

                      @foreach($roles as $optadd)
                      	<option value="{{ $optadd->id }}">{{ $optadd->role_name }}</option>
                      @endforeach

                    </select>
                  </div>
                </div>
            </div>
          </div>
          <!--=====================================
            MODAL FOOTER
          ======================================-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
    </form>
    </div>
  </div>
</div>

<!--====  End of module add user  ====-->


<!--==========================
  =  Modal window for Edit Users    =
  ===========================-->



<!--====  End of module edit user  ====-->




@endsection
