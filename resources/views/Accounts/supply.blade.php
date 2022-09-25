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


	<h1 style="text-align: center;">SUPPLY LIST</h1>

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



<style>
  /*the container must be positioned relative:*/
  .autocomplete {
    position: relative;
    /*display: inline-block;*/
  }

  .autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-bottom: none;
    border-top: none;
    z-index: 99;
    /*position the autocomplete items to be the same width as the container:*/
    top: 100%;
    left: 0;
    right: 0;
  }

  .autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #fff; 
    border-bottom: 1px solid #d4d4d4; 
  }

  /*when hovering an item:*/
  .autocomplete-items div:hover {
    background-color: #e9e9e9; 
  }

  /*when navigating through the items using the arrow keys:*/
  .autocomplete-active {
    background-color: DodgerBlue !important; 
    color: #ffffff; 
  }

</style>


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
      			{{-- <h3 class="card-title">Supply</h3>	 --}}
      		</div>
      		<div class="col-sm-4">
      			<a style="color:white; background-color: #d4af37;" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modal"data-target="#modalsupply">Add New Supply</a>  
      		</div>
      		
      	</div>
           
      </div> <!-- /.card-body -->
      <div class="card-body">

      	{{-- supply Table-------------------------------------------------------------------------------------------- --}}
      	{{-- <div>
      		<h3 class="card-title">MH Table</h3>
      	</div> --}}
        

        <table class="table table-bordered table-striped data-table-supply table-head-fixed" width="100%">
            <thead>
	            <tr id="">
		            <th>S/N</th>
		            <th>Head</th>
		            <th>Supply ID</th>
		            <th>Note</th>
		            <th>Action</th>
		        </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        {{-- supply Table-------------------------------------------------------------------------------------------- --}}

        {{-- Add supply Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Add supply    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalsupply" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/add_supply') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Add Supply</h4>
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
		                  	<input type="text" class="form-control input-lg" id="supply_district" name="supplies_name" placeholder="Head" required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Supply ID :</strong>
		                  	<input type="text" class="form-control input-lg" name="supplies_id" placeholder="Supply ID" required>
		                  </div>
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Note :</strong>
		                   	<textarea type="text" class="form-control input-lg" name="supplies_note" placeholder="Note" required></textarea>
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
        {{-- Add supply Table-------------------------------------------------------------------------------------------- --}}


        {{-- Edit supply Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Edit supply    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalsupply_edit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/update_supply') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Edit Sullpy</h4>
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

						<input type="hidden" name="id" id="supplies_id" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Head :</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_supplies_name" name="supplies_name" placeholder="Head" required>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Supply ID:</strong>
		                  	<input type="text" class="form-control input-lg" id="edit_supplies_id" name="supplies_id" placeholder="Supply ID" required>
		                  </div>
		                </div>
		              </div>
		              
		              <!-- TAKING Amount -->
		              
		              <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Note:</strong>
		                   	<textarea type="text" class="form-control input-lg" id="edit_supplies_note" name="supplies_note" placeholder="Note" required></textarea>
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
        {{-- Edit supply Table-------------------------------------------------------------------------------------------- --}}


        {{-- View supply Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for View supply    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalsupply_view" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ route('supplyview') }}" method="post" enctype="multipart/form-data" target="_blank">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">View Supply</h4>
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

						<input type="hidden" name="id" id="supplies_view_id" >
						<input type="hidden" name="from" value="0">
						<input type="hidden" name="to" value="0" >
		              <!-- TAKING NAME  -->
		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Head :</strong>
		                  	<input type="text" class="form-control input-lg" id="view_supplies_name" name="supplies_name" placeholder="Head" required readonly>
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">          
		                <div class="input-group">             
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        	<strong>Supply ID :</strong>
		                  	<input type="text" class="form-control input-lg" id="view_supplies_id" name="supplies_id" placeholder="Supply ID" required readonly>
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
        {{-- View supply Table-------------------------------------------------------------------------------------------- --}}




      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>


<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-supply').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('supply_table.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'supplies_name', name: 'supplies_name'},
{data: 'supplies_id', name: 'supplies_id'},
{data: 'supplies_note', name: 'supplies_note'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* Edit product */
$('body').on('click', '#edit-supply', function () {
var supply_id = $(this).data('id');
$.get('supply_info/'+supply_id+'/edit', function (data) {
$('#modalsupply_edit').modal('show');
$('#supplies_id').val(data.id);
$('#edit_supplies_name').val(data.supplies_name);
$('#edit_supplies_id').val(data.supplies_id);
$('#edit_supplies_note').val(data.supplies_note);

})
});

/* view supply */
$('body').on('click', '#view-supply', function () {
var supply_id = $(this).data('id');
$.get('supply_info/'+supply_id+'/edit', function (data) {
$('#modalsupply_view').modal('show');
$('#supplies_view_id').val(data.id);
$('#view_supplies_name').val(data.supplies_name);
$('#view_supplies_id').val(data.supplies_id);

})
});









});

</script>


<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["Bagerhat","Bandarban","Barguna","Barisal","Bhola","Bogra","Brahmanbaria","Chandpur","Chittagong","Chuadanga","Comilla","Cox’s Bazar","Dhaka","Dinajpur","Faridpur","Feni","Gaibandha","Gazipur","Gopalganj","Habiganj","Jamalpur","Jessore","Jhalokathi","Jhenaidaha","Joypurhat","hagrachhari","Khulna","Kishoreganj","Kurigram","Kushtia","Laksmipur","Lalmonirhat","Madaripur","Magura","Manikganj","Meherpur","Moulvibazar","Munshiganj","Mymensingh","Naogaon","Narail","Narayanganj","Natore","Nawabganj","Netrokona","Nilphamari","Noakhali","Norsingdi","Pabna","Panchgarh","Patuakhali","Pirojpur","Rajbari","Rajshahi","Rangamati","Rangpur","Satkhira","Shariatpur","Sherpur","Sirajganj","Sunamganj","Sylhet","Tangail","Thakurgaon"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
// autocomplete(document.getElementById("supply_district"), countries);
// autocomplete(document.getElementById("edit_supplies_name"), countries);
</script>


@endsection