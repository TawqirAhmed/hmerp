@extends('modals')
{{-- @extends('buttons')
@section('button_content') --}}
@extends('home.home')
@section('content')


@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $auth_role = $Sessionuser->role;
@endphp

  <h1 style="text-align: center;">SUPPLY</h1>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>


<section class="content">

	<div class="content-page">
<!-- Start content -->
<div class="content-header">

	<h1 style="text-align:center">Records of {{ $getName->supplies_name }}</h1>
  {{-- <h1 style="text-align:center; color: #d4af37;">Total profit: {{ $Totalprofit }}</h1> --}}
		<br>

	<div class="container">
	        
        <div class="card card-info">
        	 <div class="card-header">
        	 	<div class="row">
        	 		<div class="col-sm-4">
        	 			<h3 class="card-title text-white">Pick A Date Range</h3>
        	 		</div>
        	 		<div class="col-sm-8" style="text-align: right">
		    	 		<form form action="customsuppliesview" method="POST" enctype="multipart/form-data">
		            	@csrf
			            	<input type="hidden" name="id" value="{{ $getName->id }}">
			                <input type="hidden" name="supplies_id" value="{{ $getName->supplies_id }}">
			                <input type="hidden" name="from" value="0">
			                <input type="hidden" name="to" value="0">
			                <button type="submit" class="btn btn-secondary btn-sm" name="viewReport" >View All Reports</button>
			            </form>		
        	 		</div>
        	 		{{-- <div class="col-sm-2" style="text-align: right">
        	 			<a style="color:white; background-color: #28a745;margin-bottom: 5px;" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaloccpayment">Make Payment</a>
        	 		</div> --}}
        	 	</div>
        	 </div>
	        <div class="card-body">
	            <form action="customsuppliesview" method="POST" enctype="multipart/form-data">
	                @csrf

	                <input type="hidden" name="id" value="{{ $getName->id }}">
	                <input type="hidden" name="supplies_id" value="{{ $getName->supplies_id }}">
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
		                        <button type="submit" class="btn btn-success btn-md" name="viewReport" >View</button>
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

        <table  id="datatable" class="table table-bordered table-striped dt-responsive tables table-head-fixed" width="100%">
          
          <thead>
            <tr>
	            <th rowspan="2" style="text-align: center;">S/N</th>
              <th rowspan="2" style="text-align: center;">Name</th>
	            <th rowspan="2" style="text-align: center;">Particulars</th>
	            <th rowspan="2" style="text-align: center;">supply ID</th>
	            <th rowspan="2" style="text-align: center;">Folio</th>
              <th rowspan="2" style="text-align: center;">User</th>
	            <th colspan="3" style="text-align: center;">Amount</th>
	            <th rowspan="2" style="text-align: center;">Note</th>
	            <th colspan="3" style="text-align: center;">Date</th>
              @if($auth_role != 4)
	            <th rowspan="2" style="text-align: center;">Action</th>
              @endif
	        </tr>
            <tr>
              <th style="text-align: center;">Debit</th>
              <th style="text-align: center;">Credit</th>
              <th style="text-align: center;">Balance</th>
              <th style="text-align: center;">Created</th>
  	          <th style="text-align: center;">Disburse</th>
  	          <th style="text-align: center;">Modified</th>
            </tr>
            </thead>

          <tbody>
          	@foreach($supplies as $row)
                <tr>
                	<td class="text-center">{{ $row->id }}</td>
                  <td class="text-center">{{ $row->suppliesview_name }}</td>
                    <td class="text-center">{{ $row->suppliesview_particulars }}</td>
                    <td class="text-center">{{ $row->suppliesview_id }}</td>
                    <td class="text-center">{{ $row->suppliesview_folio }}</td>
                    <td class="text-center">{{ $row->suppliesview_user }}</td>
                    <td class="text-right">{{ $row->suppliesview_credit }}</td>
                    <td class="text-right">{{ $row->suppliesview_debit }}</td>
                    <td class="text-right">{{ $row->suppliesview_balance }}</td>
                    <td class="text-center">{{ $row->suppliesview_note }}</td>
                    <td class="text-center">{{ $row->created_at }}</td>
                    <td class="text-center">{{ $row->suppliesview_disburse }}</td>
                    <td class="text-center">{{ $row->updated_at }}</td>
                    @if($auth_role != 4)
                    <td class="text-center">
                    	<a class="btn btn-warning btn-sm" id="edit-suppliestransactions" data-toggle="modal" data-id='{{ $row->id }}'>Edit</a>
                    </td>
                    @endif
                </tr>
            @endforeach
          </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->


	{{-- edit Payment of Suppliesview Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for edit Payment of Suppliesview   =
      ===========================-->

    <!-- Modal -->
    <div id="modalsuppliespayment_edit" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/update_suppliespay_pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #3c8dbc; color: white">
                <h4 class="modal-title">Edit Supplies Payment</h4>
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

                <input type="hidden" name="id" id="edit_suppliesmain_id" >
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Particulars:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_particulars" name="suppliesview_particulars" placeholder="Particulars" required readonly>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Name:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_name" name="suppliesview_name" placeholder="Name" required readonly>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Supply ID:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_id" name="suppliesview_id" placeholder="Supply ID" required readonly>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Folio:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_folio" name="suppliesview_folio" placeholder="Folio" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Debit:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_credit" name="suppliesview_credit" placeholder="Debit"  required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Credit:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_debit" name="suppliesview_debit" placeholder="Credit Amount"  required readonly>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Balance:</strong>
                        <input type="text" class="form-control input-lg" id="edit_suppliesview_balance" name="suppliesview_balance" placeholder="Balance Amount"  required readonly>
                      </div>
                    </div>
                  </div>
                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note:</strong>
                        <textarea type="text" class="form-control input-lg" id="edit_suppliesview_note" name="suppliesview_note" placeholder="Purpose" required></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse: (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg"id="edit_suppliesview_disburse" name="suppliesview_disburse" placeholder="Date" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        {{-- <strong>Debit Amount:</strong> --}}
                        <input type="hidden" class="form-control input-lg" id="edit_suppliesview_paying" name="suppliesview_paying" placeholder="Debit Amount" value="0"  required>
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
        </div>
      </div>
    </div>

    <!--====  End of module Modal window for Add To MH  ====-->
        {{-- edit Payment of project Table-------------------------------------------------------------------------------------------- --}}



 


</div>


	



</div>

</section>

<script type="text/javascript">

$(document).ready(function () {



/* Edit product */
var table = $('body').on('click', '#edit-suppliestransactions', function () {
var supplies_id = $(this).data('id');
$.get('supplies_view_info/'+supplies_id+'/edit', function (data) {
$('#modalsuppliespayment_edit').modal('show');
$('#edit_suppliesmain_id').val(data.id);
$('#edit_suppliesview_particulars').val(data.suppliesview_particulars);
$('#edit_suppliesview_name').val(data.suppliesview_name);
$('#edit_suppliesview_id').val(data.suppliesview_id);
$('#edit_suppliesview_folio').val(data.suppliesview_folio);
$('#edit_suppliesview_credit').val(data.suppliesview_credit);
$('#edit_suppliesview_debit').val(data.suppliesview_debit);
$('#edit_suppliesview_balance').val(data.suppliesview_balance);
$('#edit_suppliesview_note').val(data.suppliesview_note);

var date = data.suppliesview_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_suppliesview_disburse').val(D);

})
});







});

</script>
  @endsection