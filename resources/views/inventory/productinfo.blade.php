@extends('home.homeTwo')
@section('content')

	<div class="content-page">
<!-- Start content -->
<div class="content-header">

	<h1 style="text-align:center">Information of {{ $p_Name }} : {{ $p_sku }}</h1>
  {{-- <h1 style="text-align:center; color: #d4af37;">Total Quantity: {{ $Totalproduct }} </h1> --}}
		<br>

	<div class="container">
	        
        <div class="card card-info">
        	 <div class="card-header"><h3 class="card-title text-white">Select Product Name</h3></div>
	        <div class="card-body">
	             <form action="product_information" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row col-xs-12">
                     {{--  <label for="from" class="col-form-label" style="margin-right: 10px;">From</label>
                        <div class="col-xs-3" style="margin-right: 20px;">
                          <input type="date" class="form-control input-sm" id="from" name="from" required>
                        </div>
                        <label for="from" class="col-form-label" style="margin-right: 10px;">To</label>
                        <div class="col-xs-3" style="margin-right: 20px;">
                            <input type="date" class="form-control input-sm" id="to" name="to" required>
                        </div> --}}
                        
                        @php
                          $products = DB::table('products')->get();
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
                          <input type="hidden" name="product_real_id" list="customer">
                          <input type="text" list="customer" class="form-control input-sm" name="products_id" placeholder="Select Product"  required>
                          <datalist id="customer">
                            @foreach($products as $prod)
                              {{-- <option value="{{ $prod->p_name }}"> {{ $prod->p_name }} : {{ $prod->p_sku }}</option> --}}

                              <option value="{{ $prod->p_name }}:{{ $prod->p_sku }}"> {{ $prod->p_name }} : {{ $prod->p_sku }}</option>

                            @endforeach
                          </datalist>  
                        </div> 
                          
                        <div class="col-xs-3" style="margin-right: 20px;">
                            <button type="submit" class="btn btn-success btn-md" name="exportExcel" >View Info</button>
                            {{-- <a href="{{ route('all_SalesDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
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
      {{-- <div class="col-sm-6">
      	@if ($From == 0)
      		<h1 class="m-0 text-dark">All Records</h1>
      	@else
        	<h1 class="m-0 text-dark">Records From Date ({{ $From }}) To ({{ $To }})</h1>
        @endif
      </div> --}}
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->


  <h1 style="text-align:center;">Total Quantity: {{ $Totalproduct }} </h1>
  <br>

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

        <table  class="table table-bordered table-striped tables" width="100%">
          
          <thead>
              <tr id="" style="text-align: center;">
                {{-- <th rowspan="2" style="width: 2%">S/N</th> --}}
                <th rowspan="2">Name</th>
                <th rowspan="2">SKU</th>
                <th rowspan="2">Box</th>
                <th rowspan="2">Des</th>
                <th colspan="3">Price</th>
                <th colspan="4">Stock</th>
                <th colspan="3">Date</th>
                {{-- <th rowspan="2" style="width: 10%">Action</th> --}}
            </tr>
            <tr  style="text-align: center;">
              <th>Buy</th>
                <th>Profit %</th>
                <th>Sell</th>
                <th>Previous</th>
                <th>New</th>
                <th>Total</th>
                <th>Out</th>
                <th>Created</th>
                <th>Purchase</th>
                <th>Modified</th>
            </tr>
            </thead>
            <tbody>
              @foreach($product as $row)
                <tr>
                  <td class="text-center">{{ $row->p_name }}</td>
                    <td class="text-center">{{ $row->p_sku }}</td>
                    <td class="text-center">{{ $row->p_box }}</td>
                    <td class="text-center">{{ $row->p_description }}</td>
                    <td class="text-right">{{ $row->p_buy }}</td>
                    <td class="text-right">{{ $row->p_profit }}</td>
                    <td class="text-right">{{ $row->p_sell }}</td>
                    <td class="text-right">{{ $row->p_previous }}</td>
                    <td class="text-right">{{ $row->p_new }}</td>
                    <td class="text-right">{{ $row->p_total }}</td>
                    <td class="text-right">{{ $row->p_out }}</td>
                    <td class="text-center">{{ $row->created_at }}</td>
                    <td class="text-center">{{ $row->p_disburse }}</td>
                    <td class="text-center">{{ $row->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->




<style type="text/css">
  table {
    font-size: .75rem;
  }
</style>
@endsection