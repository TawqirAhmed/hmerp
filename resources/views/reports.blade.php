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
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark" style="text-align: center;">REPORTS</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<div>
	<br>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">MH Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="mh_reports" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">MH In Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

      	<form action="mhin_reports" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">MH Out Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

      	<form action="mhout_reports" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">OCC Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

      	<form action="occ_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
	                <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
	                    <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $occs = DB::table('occs')->get();
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="occ_id" id="newOCC">
                          <option value="-113920" selected>Select OCC</option>
                            @foreach($occs as $occ)
                              <option value="{{ $occ->occ_id }}"> {{ $occ->occ_name }} : {{ $occ->occ_id }}</option>
                            @endforeach
                          </select>
                    </div> --}}

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="occs" class="form-control input-sm" name="occ_id" placeholder="Select OCC">
                      <datalist id="occs">
                        @foreach($occs as $occ)
                          <option value="{{ $occ->occ_id }}"> {{ $occ->occ_name }} : {{ $occ->occ_id }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
	                    
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Supply Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="supply_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $Supplies = DB::table('supplies')->get();
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="supplies_id" id="newOCC">
                          <option value="-113920" selected>Select Supply</option>
                            @foreach($Supplies as $supp)
                              <option value="{{ $supp->supplies_id }}"> {{ $supp->supplies_name }} : {{ $supp->supplies_id }}</option>
                            @endforeach
                          </select>
                    </div> --}}

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="supplies" class="form-control input-sm" name="supplies_id" placeholder="Select Supply">
                      <datalist id="supplies">
                        @foreach($Supplies as $supp)
                          <option value="{{ $supp->supplies_id }}"> {{ $supp->supplies_name }} : {{ $supp->supplies_id }}</option>
                        @endforeach
                      </datalist>  
                    </div>
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Civil Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="civil_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $civils = DB::table('civils')->get();
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="civil_id" id="newOCC">
                          <option value="-113920" selected>Select Civil</option>
                            @foreach($civils as $civil)
                              <option value="{{ $civil->civil_id }}"> {{ $civil->civil_name }} : {{ $civil->civil_id }}</option>
                            @endforeach
                          </select>
                    </div> --}}

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="civils" class="form-control input-sm" name="civil_id" placeholder="Select Civil">
                      <datalist id="civils">
                        @foreach($civils as $civil)
                          <option value="{{ $civil->civil_id }}"> {{ $civil->civil_name }} : {{ $civil->civil_id }}</option>
                        @endforeach
                      </datalist>  
                    </div>
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>



<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">ICT Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="ict_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $icts = DB::table('icts')->get();
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="ict_id" id="newOCC">
                          <option value="-113920" selected>Select ICT</option>
                            @foreach($icts as $ict)
                              <option value="{{ $ict->ict_id }}"> {{ $ict->ict_name }} : {{ $ict->ict_id }}</option>
                            @endforeach
                          </select>
                    </div> --}}

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="icts" class="form-control input-sm" name="ict_id" placeholder="Select ICT">
                      <datalist id="icts">
                        @foreach($icts as $ict)
                          <option value="{{ $ict->ict_id }}"> {{ $ict->ict_name }} : {{ $ict->ict_id }}</option>
                        @endforeach
                      </datalist>  
                    </div>
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Others Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="others_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $others = DB::table('others')->get();
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="others_id" id="newOCC">
                          <option value="-113920" selected>Select Others</option>
                            @foreach($others as $other)
                              <option value="{{ $other->others_id }}"> {{ $other->others_name }} : {{ $other->others_id }}</option>
                            @endforeach
                          </select>
                    </div> --}}

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="others" class="form-control input-sm" name="others_id" placeholder="Select Others">
                      <datalist id="others">
                        @foreach($others as $other)
                          <option value="{{ $other->others_id }}"> {{ $other->others_name }} : {{ $other->others_id }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Products In Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="products_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $products = DB::table('products')->get()->unique('p_name');
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="products_id" id="newOCC" required>
                          <option value="-113920" disable selected>Select Product</option>
                            @foreach($products as $prod)
                              <option value="{{ $prod->p_name }}"> {{ $prod->p_name }} : {{ $prod->p_sku }}</option>
                            @endforeach
                          </select>
                    </div> --}}

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="prosuctin" class="form-control input-sm" name="products_id" placeholder="Select Product"  required>
                      <datalist id="prosuctin">
                        @foreach($products as $prod)
                          <option value="{{ $prod->p_name }}"> {{ $prod->p_name }} : {{ $prod->p_sku }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Products Out Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="productsout_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $productsout = DB::table('products')->get()->unique('p_name');
                    @endphp

                    {{-- <div class="col-xs-3" style="margin-right: 20px;">
                        <select class="form-control" name="products_id" id="newOCC" required>
                          <option value="-113920" disable selected>Select Product</option>
                            @foreach($products as $prod)
                              <option value="{{ $prod->p_name }}"> {{ $prod->p_name }} : {{ $prod->p_sku }}</option>
                            @endforeach
                          </select>
                    </div> --}}
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="productsout" class="form-control input-sm" name="products_id" placeholder="Select Product"  required>
                      <datalist id="productsout">
                        @foreach($productsout as $prod)
                          <option value="{{ $prod->p_name }}"> {{ $prod->p_name }} : {{ $prod->p_sku }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Stock Out Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="stockout_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                  <label for="from" class="col-form-label">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $custdue = DB::table('customers')->get();
                    @endphp

                    

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="custdue" class="form-control input-sm" name="custdue_id" placeholder="Select Customer">
                      <datalist id="custdue">
                        @foreach($custdue as $cus)
                          <option>{{ $cus->id }} : {{ $cus->c_name }} : {{ $cus->c_code }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>



<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Approved Sales Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="Approvedsales_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                  <label for="from" class="col-form-label">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $custdue = DB::table('customers')->get();
                    @endphp

                    

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="custdue" class="form-control input-sm" name="custdue_id" placeholder="Select Customer">
                      <datalist id="custdue">
                        @foreach($custdue as $cus)
                          <option>{{ $cus->id }} : {{ $cus->c_name }} : {{ $cus->c_code }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Advanced Sales Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="Advancedsales_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                  <label for="from" class="col-form-label">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $custdue = DB::table('customers')->get();
                    @endphp

                    

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="custdue" class="form-control input-sm" name="custdue_id" placeholder="Select Customer">
                      <datalist id="custdue">
                        @foreach($custdue as $cus)
                          <option>{{ $cus->id }} : {{ $cus->c_name }} : {{ $cus->c_code }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Due Sales Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="duesales_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                  <label for="from" class="col-form-label">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $custdue = DB::table('customers')->get();
                    @endphp

                    

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="custdue" class="form-control input-sm" name="custdue_id" placeholder="Select Customer">
                      <datalist id="custdue">
                        @foreach($custdue as $cus)
                          <option>{{ $cus->id }} : {{ $cus->c_name }} : {{ $cus->c_code }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                      
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Customer Purchase Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="customerpurchase_reports" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row col-xs-12">
                  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="date" class="form-control input-sm" id="from" name="from" required>
                    </div>
                    <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <input type="date" class="form-control input-sm" id="to" name="to" required>
                    </div>

                    @php
                      $cust = DB::table('customers')->get();
                    @endphp

                    

                    <div class="col-xs-3" style="margin-right: 20px;">
                      <input type="text" list="cust" class="form-control input-sm" name="cust_id" placeholder="Select Customer" required>
                      <datalist id="cust">
                        @foreach($cust as $cus)
                          <option value="{{ $cus->c_name }}"> {{ $cus->c_name }} : {{ $cus->c_code }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                      
                    <div class="col-xs-3" style="margin-right: 20px;">
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Profit Report</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <form action="profit_reports" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
                        {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                    </div>
                </div>
            </div>
        </form>


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Lists</h4>
      </div> <!-- /.card-body -->
      <div class="card-body">

        <a href="{{ route('all_customers') }}" class="btn btn-success">All Customers</a>

        <a href="{{ route('all_products') }}" class="btn btn-success" style="margin-left: auto;">All Products</a>
      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


@endsection