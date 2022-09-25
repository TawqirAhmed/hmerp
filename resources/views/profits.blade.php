@extends('home.homeTwo')
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

	<h1 style="text-align:center">Profit Records</h1>
  <h1 style="text-align:center; color: #d4af37;">Total profit: {{ $Totalprofit }}</h1>
		<br>

	<div class="container">
	        
        <div class="card card-info">
        	 <div class="card-header"><h3 class="card-title text-white">Pick A Date Range</h3></div>
	        <div class="card-body">
	            <form action="customHome" method="POST" enctype="multipart/form-data">
	                @csrf
	                <div class="container">
		                <div class="row">
			                <label for="from" class="col-form-label">From</label>
		                    <div class="col-md-3">
			                    <input type="date" class="form-control input-sm" id="from" name="from" required>
		                    </div>
		                    <label for="from" class="col-form-label">To</label>
		                    <div class="col-md-3">
		                        <input type="date" class="form-control input-sm" id="to" name="to" required>
		                    </div>
			                    
		                    <div class="col-md-4">
		                        <button type="submit" class="btn btn-success btn-md" name="viewReport" >View report</button>
		                    </div>
		                </div>
		            </div>
	            </form>
	        </div>
	    </div>
        <br>
	</div>


  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      	@if ($From == 0)
      		<h1 class="m-0 text-dark">All Records</h1>
      	@else
        	<h1 class="m-0 text-dark">Records From Date ({{ $From }}) To ({{ $To }})</h1>
        @endif
      </div><!-- /.col -->
      
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->


  <!--/table starts-->
<div class="card">
	{{-- <div class="card-header">
		<h3 class="card-title">Users</h3>
		<a style="color:white" class="btn btn-success float-right" data-toggle="modal" data-target="#modalAddUser">New User</a>               
	</div> --}}
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
              <th class="text-center">Bill Code</th>
              <th class="text-center">Profit</th>
              <th class="text-center">Date</th>
              <th class="text-center">Action</th>
            </tr>

          </thead>

          <tbody>
          	@foreach($profits as $row)
                <tr>
                	<td class="text-center">{{ $row->id }}</td>
                    <td class="text-center">{{ $row->p_bill_code }}</td>
                    <td class="text-right">{{ $row->p_total }}</td>
                    <td class="text-center">{{ $row->created_at }}</td>
                    <td>
                      <a href="{{ URL::to('profitsdetails/'.$row->p_bill_code) }}" class="btn btn-success btn-sm" target="_blank"><i class="icon ion-cash"></i></a>
                    </td>
                </tr>
            @endforeach
          </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->





@endsection