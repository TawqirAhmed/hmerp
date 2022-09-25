{{-- @extends('home.home')
@section('content') --}}

@extends('buttons')
@section('button_content')

@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  if ($role ==3 || $role ==5){

    echo "<pre>";
    echo '<h1 style="margin: auto; text-align: center; font-size: 70px">"You Shall Not Pass!!!!" &#129497;</h1>';
    exit();

  }
  
@endphp


  <h1 style="text-align: center;">MH ACCOUNTS</h1>
@php
  
  $allTotal = DB::table('alltotals')->where('id',1)->first();
  $mhTotal = $allTotal->mhin_total;

@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}
{{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

{{-- <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> --}}

<div class="content-page">
<!-- Start content -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12" style="text-align: center;">
            
            <div class="col-sm-12">
              <a class="btn btn-info" href="{{ 'occ' }}">OCC</a>&nbsp;&nbsp;
              <a class="btn btn-info" href="{{ 'supply' }}">Supply</a>&nbsp;&nbsp;
              <a class="btn btn-info" href="{{ 'civil' }}">Civil</a>&nbsp;&nbsp;
              <a class="btn btn-info" href="{{ 'ict' }}">ICT</a>&nbsp;&nbsp;
              <a class="btn btn-info" href="{{ 'others' }}">Others</a>&nbsp;&nbsp;
            </div>
            
            <br>

          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="col-sm-12">
          <a href="{{ route('mhout') }}" class="btn btn-primary float-right" style="margin-left: 5px">MH Out</a>
          <a href="{{ route('mh') }}" class="btn btn-primary float-right">MH IN</a>
          
          <h3 style="text-align: center;">MH IN</h3>

        </div>
      </div>

      <div class="card-header">
        <div class="col-sm-12">
          <h3 style="text-align: right;">Balance: {{ $mhTotal }}</h3>
        </div>
      </div>

      <div class="card-body">
        <!-- MH IN Table -->
        <table class="table table-bordered table-striped data-table-mhin table-head-fixed" id="example" width="100%">
            <thead>
              <tr id="" style="text-align: center;">
                <th style="width: 2%">S/N</th>
                <th style="width: 28%">Head-Particulars</th>
                <th style="width: 15%;">Amount</th>
                <th style="width: 30%">Note</th>
                <th style="width: 30%">User</th>
                <th style="width: 10%">Date Created</th>
                <th style="width: 5%">Disburse Date</th>
                <th style="width: 5%">Modified Date</th>
                <th style="width: 5%">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- MH IN Table -->
      </div>
    </div>


    {{-- Edit MHin Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Edit MHin    =
      ===========================-->

    <!-- Modal -->
    <div id="modalmhin_edit" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/update_mhin') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #d4af37; color: white">
                <h4 class="modal-title">Update MH</h4>
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

                  <input type="hidden" name="id" id="mhin_id" >
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      {{-- <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp; --}}
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Head-Particulars: </strong>
                        <input type="text" class="form-control input-lg" id="edit_mhin_head" name="mhin_head" placeholder="Head-Particulars" required>  
                      </div>
                      
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      {{-- <span class="input-group-addon"><i class="fa fa-envelope"></i></span>&nbsp;&nbsp; --}}
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Amount:</strong>
                        <input type="number" class="form-control input-lg" id="edit_mhin_amount" name="mhin_amount" placeholder="Amount"  required>
                    </div>
                    </div>
                  </div>
                  <!-- TAKING purpose -->
                  
                  <div class="form-group">
                    <div class="input-group">                 
                      {{-- <span class="input-group-addon"><i class="fa fa-lock"></i></span>&nbsp;&nbsp; --}}
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Note:</strong>
                        <textarea type="text" class="form-control input-lg" id="edit_mhin_note" name="mhin_note" placeholder="Note" required></textarea>
                      </div>
                    </div>
                  </div>
                 
                  <!-- SELECTING ROLE FOR NEW USER -->             
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Disburse: (M/D/Y)</strong>
                        <input type="date" class="form-control input-lg"id="edit_mhin_disburse" name="mhin_disburse" placeholder="Date" required>
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
        {{-- Edit MH Table-------------------------------------------------------------------------------------------- --}}


</div>



<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-mhin').DataTable({
columnDefs: [
  {"className": "dt-right", "targets": [2]}
],

processing: true,
serverSide: true,
ajax: "{{ route('mhin_table.index') }}",

columns: [
{data: 'id', name: 'id'},
{data: 'mhin_head', name: 'mhin_head'},
{data: 'mhin_amount', name: 'mhin_amount'},
{data: 'mhin_note', name: 'mhin_note'},
{data: 'mhin_user', name: 'mhin_user'},
{data: 'created_at', name: 'created_at'},
{data: 'mhin_disburse', name: 'mhin_disburse'},
{data: 'updated_at', name: 'updated_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* Edit product */
$('body').on('click', '#edit-mh', function () {
var mhin_id = $(this).data('id');
$.get('mhin_info/'+mhin_id+'/edit', function (data) {
$('#modalmhin_edit').modal('show');
$('#mhin_id').val(data.id);
$('#edit_mhin_head').val(data.mhin_head);
$('#edit_mhin_amount').val(data.mhin_amount);
$('#edit_mhin_note').val(data.mhin_note);

var date = data.mhin_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_mhin_disburse').val(D);



})
});




});

</script>

<style type="text/css">
  td.dt-right { text-align: right; }
</style>

@endsection
