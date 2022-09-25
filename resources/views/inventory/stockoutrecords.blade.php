@extends('home.homeTwo')
@section('content')


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
        <h3 class="text-center">Stokout Records</h3>
       {{--  <a style="color:white; background-color: #d4af37;" class="btn btn-success float-left mb-2" id="new-product" data-toggle="modalmh">Add To MH</a>  
        <div class="text-center"> 
        <a style="color:white; background-color: #000080;" class="btn btn-success float-center mb-2" id="new-product" data-toggle="modalocc">ADD To OCC</a>  
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modalbio">ADD To Bio</a>
        </div>  --}}
           
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
		            <th>Bill Code</th>
		            <th>Total Price</th>
		            <th>Stockout Date</th>
		            <th>Action</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- MH Table-------------------------------------------------------------------------------------------- --}}



      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

{{-- Print Stockout Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
      =  Modal window for Print Stockout   =
      ===========================-->

    <!-- Modal -->
    <div id="modalst_view" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form role="form" action="{{ url('/print-stockout') }}" method="post" enctype="multipart/form-data"target="_blank">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="background: green; color: white">
                <h4 class="modal-title">View Stockout</h4>
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
        {{-- Print StockoutTable-------------------------------------------------------------------------------------------- --}}







<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-mh').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('stockout_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'bill_code', name: 'bill_code'},
{data: 'total_price', name: 'total_price'},
{data: 'created_at', name: 'created_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});


/* View Sale */
$('body').on('click', '#edit-stokouts', function () {
var st_id = $(this).data('id');
$.get('stockout_info/'+st_id+'/edit', function (data) {
$('#modalst_view').modal('show');
$('#st_id').val(data.id);
$('#view_bill_code').val(data.bill_code);

})
});




});

</script>



@endsection