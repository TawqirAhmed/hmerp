@extends('buttons')
@section('button_content')

@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  if ($role ==3){

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
          
          <h3 style="text-align: center;">MH OUT</h3>

        </div>
      </div>

      <div class="card-header">
        <div class="col-sm-12">
          <h3 style="text-align: right;">Balance: {{ $mhTotal }}</h3>
        </div>
      </div>

      <div class="card-body">
        <!-- MH IN Table -->
        <table class="table table-bordered table-striped data-table-mhout table-head-fixed" id="example" width="100%">
            <thead>
              <tr id="" style="text-align: center;">
                {{-- <th style="width: 2%">S/N</th> --}}
                <th style="width: 15%">Date Created</th>
                <th style="width: 25%">Head-Particulars</th>
                <th style="width: 10%">Project ID</th>
                <th style="width: 5%">Folio</th>
                <th style="width: 10%">User</th>
                <th style="width: 15%">Debit</th>
                <th style="width: 28%">Note</th>
                {{-- <th style="width: 10%">Date Created</th>
                <th style="width: 5%">Disburse Date</th>
                <th style="width: 5%">Modified Date</th>
                <th style="width: 5%">Action</th> --}}
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- MH IN Table -->
      </div>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function () {

var count =0;

var table = $('.data-table-mhout').DataTable({

columnDefs: [
  {"className": "dt-right", "targets": [4]}
  // { className: "dt-center", targets: [ 0, 1, 2 ] }
],

processing: true,
serverSide: true,
ajax: "{{ route('mhout_table.index') }}",
columns: [
// {data: 'id', name: count},
// {data: 'id', name: 'id'},
{data: 'created_at', name: 'created_at'},
{data: 'suppliesview_particulars', name: 'suppliesview_particulars'},
{data: 'suppliesview_id', name: 'suppliesview_id'},
{data: 'suppliesview_folio', name: 'suppliesview_folio'},
{data: 'suppliesview_user', name: 'suppliesview_user'},
{data: 'suppliesview_credit', name: 'suppliesview_credit'},
{data: 'suppliesview_note', name: 'suppliesview_note'},
// {data: 'created_at', name: 'created_at'},
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