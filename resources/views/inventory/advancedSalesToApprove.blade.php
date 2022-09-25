@extends('home.homeTwo')
@section('content')
<h1 style="text-align: center;">Advanced Sales To Be Approved</h1>


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


<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            {{-- <h1 class="m-0 text-dark" style="text-align: right;">Total Balance: 100000</h1> --}}
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
        {{-- <h3 class="card-title">Advanced Sales To Be Approved</h3> --}}
           
      </div> <!-- /.card-body -->
      <div class="card-body">

      	{{-- salestoapprove Table-------------------------------------------------------------------------------------------- --}}
      	{{-- <div>
      		<h3 class="card-title">MH Table</h3>
      	</div> --}}
        

        <table class="table table-bordered table-striped data-table-st" width="100%">
            <thead>
	            <tr id="" style="text-align: center;">
		            <th>S/N</th>
		            <th>Bill Code</th>
		            <th>Customer</th>
		            <th>Customer Code</th>
		            <th>Total</th>
		            <th>Method</th>
		            <th style="overflow-wrap: anywhere;">Payment Description</th>
		            <th>Paid</th>
		            <th>Due</th>
		            <th>Profit</th>
		            <th>Date</th>
		            <th>Action</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- salestoapprove Table-------------------------------------------------------------------------------------------- --}}


        {{-- Print ST Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Print ST    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalst_view" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/ad_print-st') }}" method="post" enctype="multipart/form-data"target="_blank">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">View Sale</h4>
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

						<input type="hidden" name="id" id="st_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Bill Code:</strong>
		                  	<input type="text" class="form-control input-lg" id="view_bill_code" name="bill_code" placeholder="Name" required readonly>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Company Name:</strong>
		                  	<input type="text" class="form-control input-lg" id="company_name" name="company_name" placeholder="Company Name" maxlength="25">
		                </div>
		              </div>

		               {{-- @php
                        	$employees = DB::table('employees')->get();
	                    @endphp

	                    

	                    <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
		                  	<strong>Seller Name:</strong>
	                      <input type="text" list="employees" class="form-control input-sm" name="employees_id" placeholder="Select Seller">
	                      <datalist id="employees">
	                        @foreach($employees as $cus)
	                          <option>{{ $cus->id }} : {{ $cus->e_name }} : {{ $cus->e_code }}</option>
	                        @endforeach
	                      </datalist>  
	                    </div> 
		                </div>
		            	</div> --}}
		              

		             
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light" >View</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- Edit Customer Table-------------------------------------------------------------------------------------------- --}}

        	



      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->


  			{{-- Print ST Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Print ST    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalsta_view" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/ad_approve-sta') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Add Percentage</h4>
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

						<input type="hidden" name="id" id="sta_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Bill Code:</strong>
		                  <input type="text" class="form-control input-lg" id="sta_bill_code" name="sta_bill_code" placeholder="Bill Code" required readonly>
		                </div>
		              </div>
		              
		              {{-- <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Percentage:</strong>
		                  	<input type="text" class="form-control input-lg" id="sta_percentage" name="sta_percentage" placeholder="Percentage" required>
		                </div>
		              </div> --}}

		             
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light" >Next</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- Approve Sale Table-------------------------------------------------------------------------------------------- --}}



</section>


<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-st').DataTable({

columnDefs: [
  {"className": "dt-right", "targets": [4,7,8,9]}
],

processing: true,
serverSide: true,
ajax: "{{ route('ad_st_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'bill_code', name: 'bill_code'},
{data: 'c_name', name: 'c_name'},
{data: 'c_code', name: 'c_code'},
{data: 'total_price', name: 'total_price'},
{data: 'payment_method', name: 'payment_method'},
{data: 'payment_description', name: 'payment_description'},
{data: 'amount_paid', name: 'amount_paid'},
{data: 'amount_due', name: 'amount_due'},
{data: 'amount_profit', name: 'amount_profit'},
{data: 'created_at', name: 'created_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* View Sale */
$('body').on('click', '#print-st', function () {
var st_id = $(this).data('id');
$.get('ad_st_info/'+st_id+'/edit', function (data) {
$('#modalst_view').modal('show');
$('#st_id').val(data.id);
$('#view_bill_code').val(data.bill_code);

})
});

/* View Sale */
$('body').on('click', '#approve-sta', function () {
var sta_id = $(this).data('id');
$.get('ad_sta_info/'+sta_id+'/edit', function (data) {
$('#modalsta_view').modal('show');
$('#sta_id').val(data.id);
$('#sta_bill_code').val(data.bill_code);

})
});



/* Delete product */
$('body').on('click', '#delete-st', function () {
var st_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

console.log(result);
if (result) {

$.ajax({
type: "DELETE",
url: "ad_st_table/"+st_id,
data: {
"id": st_id,
"_token": token,
},
success: function (data) {

location.reload();
console.log(data);
//$('#msg').html('Customer entry deleted successfully');
//$("#customer_id_" + user_id).remove();
// table.ajax.reload();
},
error: function (data) {
	location.reload();
console.log('Error:', data);
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

@endsection