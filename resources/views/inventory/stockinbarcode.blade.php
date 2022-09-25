@extends('home.homeTwo')
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
{{-- <div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark" style="text-align: center;">Add Product with Barcode</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div> --}}


<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4  style="text-align: center;">Add Product with Barcode</h4>
      </div> <!-- /.card-body -->
      <br>
      <div style="margin-left: 20px">
        <form action="{{ url('barcodecart-add_barcode') }}" id="barcodeForm" method="post">
          @csrf
           <div class="row">  
           <strong>&nbsp;&nbsp;&nbsp;Barcode:&nbsp;&nbsp;</strong>     
          <input type="text" name="barcode_input" placeholder="Barcode" autofocus>
          </div>
        </form>
       </div>
      <div class="card-body">

      	<hr>
      	<table class="table text-center" style="width: 100%">
	        <thead>
	            <tr>
	                <th>Name</th>
	                <th>SKU</th>
                  <th>Box</th>
	                <th>Quantity</th>
	                <th>Action</th>
	            </tr>    
	        </thead>
	        @php

	        // $listproduct = Cart::content();
          $listproduct =session('purchaseCart');

	        // echo "<pre>";
	        // print_r($listproduct);
	        // exit();

	        @endphp
	        
	        <tbody>
	           @if(session('purchaseCart'))
                      @foreach(session('purchaseCart') as $id => $details)
                          @php
                            $product = DB::table('products')->where('p_sku',$details['sku'])->first();

                            // echo "<pre>";
                            // print_r($listproduct);
                            // exit();

                          @endphp
                          <tr>
                            <td data-th="Name">
                                  {{ $details['name'] }}
                              </td>
                              <td data-th="SKU">
                                  {{ $details['sku'] }}
                              </td>
                              <td data-th="Box">
                                <input type="text" value="{{ $details['box'] }}" class="form-control box" />
                              </td>
                              <td data-th="Quantity">
                                  <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                              </td>
                              <td class="Action" data-th="">
                                  <button class="btn btn-info btn-sm updatebarcode-cart" data-id="{{ $id }}"><i class="fas fa-check"></i></button>
                                  <button class="btn btn-danger btn-sm removebarcode-from-cart" data-id="{{ $id }}"><i class="fas fa-trash"></i></button>
                              </td>
                          </tr>
                      @endforeach
                  @endif
	        </tbody>
	    </table>

	    <div>
	    	<a href="" class=" btn" disabled> </a>
	    </div>
	    <div class="text-center">
	    	<a href="{{ route('barcodeclear-cart') }}" class="btn btn-danger">Clear Cart</a>
            <a href="{{ route('barcodStockin-cart') }}" class="btn btn-info">Add to Inventory</a> 
	    </div>
      	


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>




<script type="text/javascript">
        $(".updatebarcode-cart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: '{{ url('updatebarcode-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val(), box: ele.parents("tr").find(".box").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
        $(".removebarcode-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('removebarcode-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>

@endsection