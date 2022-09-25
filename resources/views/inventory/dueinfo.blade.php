@extends('home.homeTwo')
@section('content')


	<div class="content-page">
<!-- Start content -->
<div class="content-header">

	<h1 style="text-align:center">Due Information of {{ $p_Name }} </h1>
  {{-- <h1 style="text-align:center; color: #d4af37;">Total Quantity: {{ $Totalproduct }} </h1> --}}
		<br>

	<div class="container">
	        
        <div class="card card-info">
        	 <div class="card-header"><h3 class="card-title text-white">Select Customer Name</h3></div>
	        <div class="card-body">
	             <form action="dueinfo_information" method="POST" enctype="multipart/form-data">
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
                          $products = DB::table('customers')->get();
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
                          <input type="text" list="customer" class="form-control input-sm" name="products_id" placeholder="Select Customer"  required>
                          <datalist id="customer">
                            @foreach($products as $prod)
                              <option >{{ $prod->id }} : {{ $prod->c_name }} : {{ $prod->c_code }}</option>
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


  <h1 style="text-align:center;">Total Due Amount: {{ $Totalproduct }} </h1>
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

        <table id="datatable" class="table table-bordered table-striped dt-responsive tables" width="100%">
          
          <thead>
	            <tr id="" style="text-align: center;">
		            <th>S/N</th>
		            <th>Bill Code</th>
		            <th>Customer</th>
		            <th>Customer Code</th>
		            <th>Total</th>
		            <th>Method</th>
		            <th>Paid</th>
		            <th>Due</th>
		            <th>Date</th>
		        </tr>
            </thead>
            <tbody>
              @foreach($product as $row)
                <tr>
                	<td class="text-center">{{ $row->id }}</td>
                  	<td class="text-center">{{ $row->bill_code }}</td>
                    <td class="text-center">{{ $row->c_name }}</td>
                    <td class="text-center">{{ $row->c_code }}</td>
                    <td class="text-right">{{ $row->total_price }}</td>
                    <td class="text-center">{{ $row->payment_method }}</td>
                    <td class="text-right">{{ $row->amount_paid }}</td>
                    <td class="text-right">{{ $row->amount_due }}</td>
                    <td class="text-center">{{ $row->created_at}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->





@endsection