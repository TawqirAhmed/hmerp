@extends('home.home')
@section('content')

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
        <div class="row">
          <div class="col-sm-8">
        <h3 style="text-align: left;">Suppliers</h3>
        </div>
        <div class="col-sm-4">
        <a style="color:white; background-color: #d4af37;" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modal" data-target="#modalsupplier">Add New Supplier</a>  
        </div>
        </div>
           
      </div> <!-- /.card-body -->
      <div class="card-body">

      	{{-- MH Table-------------------------------------------------------------------------------------------- --}}
      	{{-- <div>
      		<h3 class="card-title">MH Table</h3>
      	</div> --}}
        

        <table class="table table-bordered table-striped data-table-mh" width="100%">
            <thead>
	            <tr id="" style="text-align: center;">
		            <th>S/N</th>
		            <th>Name</th>
	                <th>Code</th>
		            <th>Contact Details</th>
		            <th>Action</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- MH Table-------------------------------------------------------------------------------------------- --}}


         {{-- Add Supplier Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Add Supplier    =
      ===========================-->

    <!-- Modal -->
    <div id="modalsupplier" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/add_supplier') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #d4af37; color: white">
                <h4 class="modal-title">Add New Supplier</h4>
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
                        <input type="text" class="form-control input-lg" name="s_name" placeholder="Name" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- TAKING Amount -->

                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Code:</strong>
                        <input type="text" class="form-control input-lg" name="s_code" placeholder="Code" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Contact Details:</strong>
                        <textarea type="text" class="form-control input-lg" name="s_contact" placeholder="Contact Details" required></textarea>
                      </div>
                    </div>
                  </div>
                  
                 
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
        {{-- Add Supplier Table-------------------------------------------------------------------------------------------- --}}


        {{-- Edit Supplier Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Edit Supplier    =
      ===========================-->

    <!-- Modal -->
    <div id="modalsupplier_edit" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/update_supplier') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: #d4af37; color: white">
                <h4 class="modal-title">Add New Supplier</h4>
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

                  <input type="hidden" name="id" id="s_id" >
                  <!-- TAKING NAME  -->
                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Name:</strong>
                        <input type="text" class="form-control input-lg" id="edit_s_name" name="s_name" placeholder="Name" required>
                      </div>
                    </div>
                  </div>

                  <!-- SELECTING ROLE FOR NEW USER -->             
                  <div class="form-group">
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Code:</strong>
                        <input type="text" class="form-control input-lg" id="edit_s_code" name="s_code" placeholder="Code" required>
                      </div>
                    </div>
                  </div>

                  
                  <!-- TAKING Amount -->
                  
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Contact Details:</strong>
                        <textarea type="text" class="form-control input-lg" id="edit_s_contact" name="s_contact" placeholder="Contact Details" required></textarea>
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
        {{-- Add Supplier Table-------------------------------------------------------------------------------------------- --}}


      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-mh').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('suppliers_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 's_name', name: 's_name'},
{data: 's_code', name: 's_code'},
{data: 's_contact', name: 's_contact'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});


/* Edit product */
$('body').on('click', '#edit-supplier', function () {
var supplier_id = $(this).data('id');
$.get('supplier_info/'+supplier_id+'/edit', function (data) {
$('#modalsupplier_edit').modal('show');
$('#s_id').val(data.id);
$('#edit_s_name').val(data.s_name);
$('#edit_s_code').val(data.s_code);
$('#edit_s_contact').val(data.s_contact);


})
});


/* Delete product */
$('body').on('click', '#delete-supplier', function () {
var supplier_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

console.log(result);
if (result) {

$.ajax({
type: "DELETE",
url: "suppliers_table/"+supplier_id,
data: {
"id": supplier_id,
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



@endsection