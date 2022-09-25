@extends('home.homeTwo')
@section('content')


@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  // if ($role ==3 || $role ==5){

  //   echo "<pre>";
  //   echo '<h1 style="margin: auto; text-align: center; font-size: 70px">"You Shall Not Pass!!!!" &#129497;</h1>';
  //   exit();

  // }
  
@endphp


<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
{{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}

<script>
error=false

function validate()
{
if(document.productForm.product_name.value !='' && document.productForm.category_id.value !='' && document.productForm.supplier_id.value !='' && document.productForm.product_code.value !='' && document.productForm.product_description.value !='' && document.productForm.stock.value !='' && document.productForm.buying_price.value !='' && document.productForm.selling_price.value !='' && document.productForm.sales.value !='')
{
  document.productForm.btnsave.disabled=false
}
else{
    document.productForm.btnsave.disabled=true
  }
}
</script>

{{-- <div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark" style="text-align: right;">Total Balance: 100000</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div> --}}

{{-- <div>
	<br>
</div> --}}

<h1 style="text-align: center;">All Products</h1>	

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
      	<div class="row">
      		<div class="col-sm-8">
      			{{-- <h3 class="card-title">All Products</h3>	 --}}
      		</div>
      		<div class="col-sm-4">
      			<a style="color:white; background-color: #d4af37;" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modal"data-target="#modalproduct">Add New Product</a>  
      		</div>
      		
      	</div>
      </div> <!-- /.card-body -->
      <div class="card-body">

      	{{-- Product Table-------------------------------------------------------------------------------------------- --}}

        <table class="table table-bordered table-striped data-table-products" width="100%">
            <thead>
	            <tr id="" style="text-align: center;">
		            <th rowspan="2" style="overflow-wrap: anywhere;">S/N</th>
		            <th rowspan="2" style="overflow-wrap: anywhere;">Name</th>
		            <th rowspan="2" style="overflow-wrap: anywhere;">SKU</th>
		            <th rowspan="2" style="overflow-wrap: anywhere;">Box</th>
		            <th rowspan="2" style="overflow-wrap: anywhere;">Des</th>
		            @if($role != 5)
		            @if($role == 2)
		            <th colspan="1">Price</th>
		            @else
		            <th colspan="3">Price</th>
		            @endif
		            @endif
		            <th colspan="5">Stock</th>
		            <th colspan="3">Date</th>
		            {{-- @if($role != 5) --}}
		            <th rowspan="2" style="overflow-wrap: anywhere;">Action</th>
		            {{-- @endif --}}
		        </tr>
		        <tr  style="text-align: center;">
		        		@if($role != 5)
		        		@if($role != 2)
		        		<th style="overflow-wrap: anywhere;">Buy</th>
		            <th style="overflow-wrap: anywhere;">Pro %</th>
		            @endif
		            <th style="overflow-wrap: anywhere;">Sell</th>
		            @endif
		            <th style="overflow-wrap: anywhere;">Unit</th>
		            <th style="overflow-wrap: anywhere;">Pre</th>
		            <th style="overflow-wrap: anywhere;">New</th>
		            <th style="overflow-wrap: anywhere;">Out</th>
		            <th style="overflow-wrap: anywhere;">Total</th>
		            <th style="overflow-wrap: anywhere;">Created</th>
		            <th style="overflow-wrap: anywhere;">Purchase</th>
		            <th style="overflow-wrap: anywhere;">Modified</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- Product Table-------------------------------------------------------------------------------------------- --}}

		</div>
	</div>
</div>        

	 {{-- Add Product Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Add Product    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalproduct" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/add_product') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: #d4af37; color: white">
		          	<h4 class="modal-title">Add New Product</h4>
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
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Name:</strong>
		                  	<input type="text" class="form-control input-lg" name="p_name" placeholder="Product Name" required>
		                  </div>
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>SKU:</strong>
		                  	<input type="text" class="form-control input-lg" name="p_sku" placeholder="SKU"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Box:</strong>
		                  	<input type="text" class="form-control input-lg" name="p_box" placeholder="Box"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Unit Name:</strong>
		                  	<input type="text" class="form-control input-lg" name="p_unit" placeholder="Unit Name"  required>
		                  </div>
		                </div>
		              </div>
		              <!-- TAKING purpose -->
		              
		              <div class="form-group">
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Description:</strong>
		                  	<textarea type="text" class="form-control input-lg" name="p_description" placeholder="Description" required></textarea>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Buying Price:</strong>
		                  	<input type="number" class="form-control input-lg" name="p_buy" placeholder="Buying Price"  required>
		                  </div>
		                </div>
		              </div>
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Profit %:</strong>
		                  	<input type="number" class="form-control input-lg" name="p_profit" placeholder="Profit %"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>New Product Quantity:</strong>
		                  	<input type="number" class="form-control input-lg" name="p_new" placeholder="New Product Quantity"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Purchase Date (M/D/Y):</strong>
		                  	<input type="date" class="form-control input-lg" name="p_disburse" placeholder="Purchase Date"  required>
		                  </div>
		                </div>
		              </div>
		             
		              <!-- SELECTING ROLE FOR NEW USER -->             
		              
		             
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- Add Product Table-------------------------------------------------------------------------------------------- --}}


        {{-- Edit Product Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Edit Product    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalproduct_edit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/update_product') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: #d4af37; color: white">
		          	<h4 class="modal-title">Edit Product</h4>
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

						<input type="hidden" name="id" id="p_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Name:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_p_name" name="p_name" placeholder="Product Name" required>
		                  </div>
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>SKU:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_p_sku" name="p_sku" placeholder="SKU"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Box:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_p_box" name="p_box" placeholder="Box"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Unit Name:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_p_unit" name="p_unit" placeholder="Unit Name"  required>
		                  </div>
		                </div>
		              </div>
		              <!-- TAKING purpose -->

		              <div class="form-group">
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Description:</strong>
		                  	<textarea type="text" class="form-control input-lg" id="edit_p_description" name="p_description" placeholder="Description" required></textarea>
		                  </div>
		                </div>
		              </div>
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Buying Price:</strong>
		                  	<input type="number" class="form-control input-lg" id="edit_p_buy" name="p_buy" placeholder="Buying Price"  required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Profit %:</strong>
		                  	<input type="number" class="form-control input-lg" id="edit_p_profit" name="p_profit" placeholder="Profit %"  required>
		                  </div>
		                </div>
		              </div>
		             
		              <!-- SELECTING ROLE FOR NEW USER -->  

		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Purchase Date (M/D/Y):</strong>
		                  	<input type="date" class="form-control input-lg" id="edit_p_disburse" name="p_disburse" placeholder="Purchase Date"  required>
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
        {{-- Edit Product Table-------------------------------------------------------------------------------------------- --}}


        {{-- Edit Stock Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Edit Stock    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalproductstock_edit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/update_stock') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: #d4af37; color: white">
		          	<h4 class="modal-title">Restock Product</h4>
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

						<input type="hidden" name="id" id="ups_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>New Quantity:</strong>
		                  	<input type="number" class="form-control input-lg" id="edit_p_newStock" name="p_new" placeholder="New Quantity" required>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Purchase Date:</strong>
		                  	<input type="date" class="form-control input-lg" id="edit_p_disburseStock" name="p_disburse" placeholder="Purchase Date" required>
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
        {{-- Edit Stock Table-------------------------------------------------------------------------------------------- --}}


</section>


        {{-- Print Barcode Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Print Barcode    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalproductbar_edit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('print-barcode') }}" method="post" enctype="multipart/form-data" target="_blank">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: #d4af37; color: white">
		          	<h4 class="modal-title">Print Barcode</h4>
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

						<input type="hidden" name="id" id="bar_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Product Name:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_bar_name" name="bar_name" placeholder="Name" required readonly>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Barcode Amount:</strong>
		                  	<input type="number" class="form-control input-lg" id="edit_bar_new" name="bar_new" placeholder="Amount" required>
		                </div>
		              </div>
		              
		              
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light">Print</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- Print BarcodeTable-------------------------------------------------------------------------------------------- --}}

@if( $role == 5)
	<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-products').DataTable({

columnDefs: [
  {"className": "dt-right", "targets": [5,6,7,9,10,11,12]}
],

processing: true,
serverSide: true,
ajax: "{{ route('stockin_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'p_name', name: 'p_name'},
{data: 'p_sku', name: 'p_sku'},
{data: 'p_box', name: 'p_box'},
{data: 'p_description', name: 'p_description'},
{data: 'p_unit', name: 'p_unit'},
{data: 'p_previous', name: 'p_previous'},
{data: 'p_new', name: 'p_new'},
{data: 'p_out', name: 'p_out'},
{data: 'p_total', name: 'p_total'},
{data: 'created_at', name: 'created_at'},
{data: 'p_disburse', name: 'p_disburse'},
{data: 'updated_at', name: 'updated_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});


/* Edit product */
$('body').on('click', '#edit-products', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproduct_edit').modal('show');
$('#p_id').val(data.id);
$('#edit_p_name').val(data.p_name);
$('#edit_p_sku').val(data.p_sku);
$('#edit_p_box').val(data.p_box);
$('#edit_p_unit').val(data.p_unit);
$('#edit_p_buy').val(data.p_buy);
$('#edit_p_profit').val(data.p_profit);
$('#edit_p_description').val(data.p_description);

var date = data.p_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_p_disburse').val(D);

})
});

/* Edit stock */
$('body').on('click', '#edit-stock', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproductstock_edit').modal('show');
$('#ups_id').val(data.id);
// $('#edit_p_newStock').val(data.p_new);

var date = data.p_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_p_disburseStock').val(D);

})
});

/* Edit barcode */
$('body').on('click', '#edit-barcode', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproductbar_edit').modal('show');
$('#bar_id').val(data.id);
$('#edit_bar_name').val(data.p_name);
$('#edit_bar_new').val(data.p_new);
// console.log(data);
})
});







});

</script>

<style type="text/css">
  td.dt-right { text-align: right; }
</style>

<style type="text/css">
	table {
	  font-size: .75rem;
	}
</style>

@elseif( $role == 2)

<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-products').DataTable({

columnDefs: [
  {"className": "dt-right", "targets": [5,6,7,9,10,11,12]}
],

processing: true,
serverSide: true,
ajax: "{{ route('stockin_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'p_name', name: 'p_name'},
{data: 'p_sku', name: 'p_sku'},
{data: 'p_box', name: 'p_box'},
{data: 'p_description', name: 'p_description'},
{data: 'p_sell', name: 'p_sell'},
{data: 'p_unit', name: 'p_unit'},
{data: 'p_previous', name: 'p_previous'},
{data: 'p_new', name: 'p_new'},
{data: 'p_out', name: 'p_out'},
{data: 'p_total', name: 'p_total'},
{data: 'created_at', name: 'created_at'},
{data: 'p_disburse', name: 'p_disburse'},
{data: 'updated_at', name: 'updated_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});


/* Edit product */
$('body').on('click', '#edit-products', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproduct_edit').modal('show');
$('#p_id').val(data.id);
$('#edit_p_name').val(data.p_name);
$('#edit_p_sku').val(data.p_sku);
$('#edit_p_box').val(data.p_box);
$('#edit_p_unit').val(data.p_unit);
$('#edit_p_buy').val(data.p_buy);
$('#edit_p_profit').val(data.p_profit);
$('#edit_p_description').val(data.p_description);

var date = data.p_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_p_disburse').val(D);

})
});

/* Edit stock */
$('body').on('click', '#edit-stock', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproductstock_edit').modal('show');
$('#ups_id').val(data.id);
// $('#edit_p_newStock').val(data.p_new);

var date = data.p_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_p_disburseStock').val(D);

})
});

/* Edit barcode */
$('body').on('click', '#edit-barcode', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproductbar_edit').modal('show');
$('#bar_id').val(data.id);
$('#edit_bar_name').val(data.p_name);
$('#edit_bar_new').val(data.p_new);
// console.log(data);
})
});







});

</script>

<style type="text/css">
  td.dt-right { text-align: right; }
</style>

<style type="text/css">
	table {
	  font-size: .75rem;
	}
</style>


@else

<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-products').DataTable({

columnDefs: [
  {"className": "dt-right", "targets": [5,6,7,9,10,11,12]}
],

processing: true,
serverSide: true,
ajax: "{{ route('stockin_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'p_name', name: 'p_name'},
{data: 'p_sku', name: 'p_sku'},
{data: 'p_box', name: 'p_box'},
{data: 'p_description', name: 'p_description'},
{data: 'p_buy', name: 'p_buy'},
{data: 'p_profit', name: 'p_profit'},
{data: 'p_sell', name: 'p_sell'},
{data: 'p_unit', name: 'p_unit'},
{data: 'p_previous', name: 'p_previous'},
{data: 'p_new', name: 'p_new'},
{data: 'p_out', name: 'p_out'},
{data: 'p_total', name: 'p_total'},
{data: 'created_at', name: 'created_at'},
{data: 'p_disburse', name: 'p_disburse'},
{data: 'updated_at', name: 'updated_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});


/* Edit product */
$('body').on('click', '#edit-products', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproduct_edit').modal('show');
$('#p_id').val(data.id);
$('#edit_p_name').val(data.p_name);
$('#edit_p_sku').val(data.p_sku);
$('#edit_p_box').val(data.p_box);
$('#edit_p_unit').val(data.p_unit);
$('#edit_p_buy').val(data.p_buy);
$('#edit_p_profit').val(data.p_profit);
$('#edit_p_description').val(data.p_description);

var date = data.p_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_p_disburse').val(D);

})
});

/* Edit stock */
$('body').on('click', '#edit-stock', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproductstock_edit').modal('show');
$('#ups_id').val(data.id);
// $('#edit_p_newStock').val(data.p_new);

var date = data.p_disburse;
var D = date.substr(0,10);
console.log(D);

$('#edit_p_disburseStock').val(D);

})
});

/* Edit barcode */
$('body').on('click', '#edit-barcode', function () {
var p_id = $(this).data('id');
$.get('product_info/'+p_id+'/edit', function (data) {
$('#modalproductbar_edit').modal('show');
$('#bar_id').val(data.id);
$('#edit_bar_name').val(data.p_name);
$('#edit_bar_new').val(data.p_new);
// console.log(data);
})
});



/* Delete product */
$('body').on('click', '#delete-product', function () {
var products_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

console.log(result);
if (result) {

$.ajax({
type: "DELETE",
url: "stockin_table/"+products_id,
data: {
"id": products_id,
"_token": token,
},
success: function (data) {
console.log(data);
location.reload();
//$('#msg').html('Customer entry deleted successfully');
//$("#customer_id_" + user_id).remove();
// table.ajax.reload();
},
error: function (data) {
console.log('Error:', data);

location.reload();
}
});
}

});





});

</script>

<style type="text/css">
  td.dt-right { text-align: right; }
</style>

<style type="text/css">
	table {
	  font-size: .75rem;
	}
</style>

@endif

@endsection