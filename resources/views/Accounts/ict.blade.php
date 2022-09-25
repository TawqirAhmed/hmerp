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

<h1 style="text-align: center;">ICT LIST</h1>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
      			{{-- <h3 class="card-title">ICT</h3>	 --}}
      		</div>
      		<div class="col-sm-4">
      			<a style="color:white; background-color: #d4af37;" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modal"data-target="#modalict">Add New ICT</a>  
      		</div>
      		
      	</div>
           
      </div> <!-- /.card-body -->
      <div class="card-body">

      	{{-- ict Table-------------------------------------------------------------------------------------------- --}}
      	{{-- <div>
      		<h3 class="card-title">MH Table</h3>
      	</div> --}}
        

        <table class="table table-bordered table-striped data-table-ict table-head-fixed" width="100%">
            <thead>
	            <tr id="">
		            <th>S/N</th>
		            <th>Head</th>
		            <th>ICT ID</th>
		            <th>Note</th>
		            <th>Action</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- ICT Table-------------------------------------------------------------------------------------------- --}}

        {{-- Add ICT Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Add ICT    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalict" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/add_ict') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Add ICT</h4>
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
                        	<strong>Head :</strong>
		                  	<input type="text" class="form-control input-lg" name="ict_name" placeholder="Head" required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>ICT ID :</strong>
		                  	<input type="text" class="form-control input-lg" name="ict_id" placeholder="ICT ID" required>
		                  </div>
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Note :</strong>
		                   	<textarea type="text" class="form-control input-lg" name="ict_note" placeholder="Note" required></textarea>
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
        {{-- Add ICT Table-------------------------------------------------------------------------------------------- --}}


        {{-- Edit ICT Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Edit ICT    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalict_edit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/update_ict') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Edit ICT</h4>
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

						<input type="hidden" name="id" id="ict_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Head :</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_ict_name" name="ict_name" placeholder="Head" required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>ICT ID :</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_ict_id" name="ict_id" placeholder="ICT ID" required>
		                  </div>
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Note :</strong>
		                   	<textarea type="text" class="form-control input-lg" id="edit_ict_note" name="ict_note" placeholder="Note" required></textarea>
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
        {{-- Edit ICT Table-------------------------------------------------------------------------------------------- --}}


        {{-- View ICT Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for View ICT    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalict_view" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ route('ictview') }}" method="post" enctype="multipart/form-data" target="_blank">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">View ICT</h4>
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

						<input type="hidden" name="id" id="ict_view_id" >
						<input type="hidden" name="from" value="0">
						<input type="hidden" name="to" value="0" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Head :</strong>
		                  	<input type="text" class="form-control input-lg" id="view_ict_name" name="ict_name" placeholder="Head" required readonly>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>ICT ID :</strong>
		                  	<input type="text" class="form-control input-lg" id="view_ict_id" name="ict_id" placeholder="ICT ID" required readonly>
		                  </div>
		                </div>
		              </div>
		              
		             
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-primary waves-effect waves-light">View</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		          </div>
		    </form>
		    </div>
		  </div>
		</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- View ICT Table-------------------------------------------------------------------------------------------- --}}




      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-ict').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('ict_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'ict_name', name: 'ict_name'},
{data: 'ict_id', name: 'ict_id'},
{data: 'ict_note', name: 'ict_note'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* Edit product */
$('body').on('click', '#edit-ict', function () {
var ict_id = $(this).data('id');
$.get('ict_info/'+ict_id+'/edit', function (data) {
$('#modalict_edit').modal('show');
$('#ict_id').val(data.id);
$('#edit_ict_name').val(data.ict_name);
$('#edit_ict_id').val(data.ict_id);
$('#edit_ict_note').val(data.ict_note);

})
});

/* view ict */
$('body').on('click', '#view-ict', function () {
var ict_id = $(this).data('id');
$.get('ict_info/'+ict_id+'/edit', function (data) {
$('#modalict_view').modal('show');
$('#ict_view_id').val(data.id);
$('#view_ict_name').val(data.ict_name);
$('#view_ict_id').val(data.ict_id);

})
});









});

</script>



@endsection
