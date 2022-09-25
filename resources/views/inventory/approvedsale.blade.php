@extends('home.homeTwo')
@section('content')
<h1 style="text-align: center;">Approved Sales</h1>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

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
        {{-- <h3 class="card-title">Approved Sales</h3> --}}
           
      </div> <!-- /.card-body -->
      <div class="card-body">

      	{{-- MH Table-------------------------------------------------------------------------------------------- --}}
      	{{-- <div>
      		<h3 class="card-title">MH Table</h3>
      	</div> --}}
        

        <table class="table table-bordered table-striped data-table-as" width="100%">
            <thead>
	            <tr id="" style="text-align: center;">
		            <th>S/N</th>
		            <th>Bill Code</th>
		            <th>Customer</th>
		            <th>Customer Code</th>
		            <th>Total</th>
		            <th>Method</th>
		            <th>Payment Description</th>
		            <th>Paid</th>
		            <th>Due</th>
		            {{-- <th>profit %</th> --}}
		            {{-- <th>Profit</th> --}}
		            <th>Date</th>
		            <th>Action</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- MH Table-------------------------------------------------------------------------------------------- --}}


        {{--Edit Approved Sales Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Edit Approved Sales   =
		  ===========================-->

		<!-- Modal -->
		<div id="modalas_edit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/update_as') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: #d4af37; color: white">
		          	<h4 class="modal-title">Edit Sale</h4>
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

						<input type="hidden" name="id" id="as_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Name:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_bill_code" name="bill_code" placeholder="Name" required readonly>
		                  </div>
		                </div>
		              </div>
		              
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Total Price:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_total_price" name="total_price" placeholder="Total Price" required readonly>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Paid Amount:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_amount_paid" name="amount_paid" placeholder="Paid Amount" required readonly>
		                  </div>
		                </div>
		              </div>
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Due Amount:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_amount_due" name="amount_due" placeholder="Due Amount" required readonly>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Amount Paying:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_amount_paying" name="amount_paying" placeholder="Amount Paying" required>
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
        {{-- Edit Approved Sales Table-------------------------------------------------------------------------------------------- --}}




        {{-- Print ST Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Print ST    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalas_view" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/print-as') }}" method="post" enctype="multipart/form-data"target="_blank">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">View Approved Sale</h4>
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

						<input type="hidden" name="id" id="asv_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Bill Code:</strong>
		                  	<input type="text" class="form-control input-lg" id="view_bill_code" name="bill_code" placeholder="Bill Code" required readonly>
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
        {{-- view sale Table-------------------------------------------------------------------------------------------- --}}




      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->



  {{-- Print ST Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Print ST    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalaspay_view" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/update-as-payment') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Edit Payment Info</h4>
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

						<input type="hidden" name="id" id="aspay_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Bill Code:</strong>
		                  	<input type="text" class="form-control input-lg" id="pay_bill_code" name="bill_code" placeholder="Bill Code" required readonly>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Cash Details:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_cash_description" name="cash_description" placeholder="Cash Details" required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Card Details:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_card_description" name="card_description" placeholder="Card Details" required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Cheque Details:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_cheque_description" name="cheque_description" placeholder="Cheque Details" required>
		                  </div>
		                </div>
		              </div>

		              
		              

		             
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light" >Update</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- view sale Table-------------------------------------------------------------------------------------------- --}}



</section>


<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-as').DataTable({

columnDefs: [
  {"className": "dt-right", "targets": [4,7,8]}
],

processing: true,
serverSide: true,
ajax: "{{ route('as_table.index') }}",
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
// {data: 'profit_percentage', name: 'profit_percentage'},
// {data: 'profits', name: 'profits'},
{data: 'created_at', name: 'created_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});


/* Edit Sale */
$('body').on('click', '#edit-as', function () {
var as_id = $(this).data('id');
$.get('as_info/'+as_id+'/edit', function (data) {
$('#modalas_edit').modal('show');
$('#as_id').val(data.id);
$('#edit_bill_code').val(data.bill_code);
$('#edit_total_price').val(data.total_price);
$('#edit_amount_paid').val(data.amount_paid);
$('#edit_amount_due').val(data.amount_due);

})
});


/* View Sale */
$('body').on('click', '#print-as', function () {
var as_id = $(this).data('id');
$.get('as_info/'+as_id+'/edit', function (data) {
$('#modalas_view').modal('show');
$('#asv_id').val(data.id);
$('#view_bill_code').val(data.bill_code);

})
});

/* Payment Details */
$('body').on('click', '#edit-as-payment', function () {
var as_id = $(this).data('id');
$.get('as_info/'+as_id+'/edit', function (data) {
$('#modalaspay_view').modal('show');
$('#aspay_id').val(data.id);
$('#pay_bill_code').val(data.bill_code);

var con = data.payment_description;
var conArray = JSON.parse(con);


$('#edit_cash_description').val(conArray[0]);
$('#edit_card_description').val(conArray[1]);
$('#edit_cheque_description').val(conArray[2]);


})
});




/* Delete product */
$('body').on('click', '#delete-as', function () {
var as_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

console.log(result);
if (result) {

$.ajax({
type: "DELETE",
url: "as_table/"+as_id,
data: {
"id": as_id,
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