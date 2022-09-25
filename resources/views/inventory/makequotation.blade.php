@extends('home.homeTwo')
@section('content')

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
{{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
<script>
error=false

function validate()
{
if(document.productForm.product_name.value !='' && document.productForm.category_id.value !='' && document.productForm.supplier_id.value !='' && document.productForm.product_code.value !='' && document.productForm.product_description.value !='' && document.productForm.stock.value !='' && document.productForm.buying_price.value !='' && document.productForm.selling_price.value !='' && document.productForm.sales.value !='' && document.productForm.vat.value !='')
{
	document.productForm.btnsave.disabled=false
}
else{
		document.productForm.btnsave.disabled=true
	}
}
</script>


  

    <h3 style="text-align: center;">

      Make Quotation

    </h3>

 <br>


<div class="row">
<!-----------------------------------------------POS-------------------------------------------------------------------->
<div class="col-lg-5 col-xs-12">
	<div class="card">
      <div class="card-body">
        <div class="container">
          

              <div><h5>Invoice</h5></div>
        
                <div class="price_card text-center">
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>    
                        </thead>
                        @php
                        $listproduct = Cart::content()
                        @endphp
                        <tbody>
                            @foreach($listproduct as $pro)
                            <tr>
                                <th>{{ $pro->name }}</th>
                                <th>
                                    <form  action="{{ url('/advancedsalescart-update/'.$pro->rowId) }}" method="post">
                                      @csrf
                                      <input type="hidden" name="idProduct" value="{{ $pro->id }}">
                                      <input type="hidden" name="selling_price" value="{{ $pro->selling_price }}">
                                      <input type="number" name="qty" value="{{ $pro->qty }}" style="width: 80px">
                                      <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i></button>
                                    </form>
                                </th>
                                <th>{{ $pro->price*$pro->qty  }}</th>

                                <th><a href="{{ url('/advancedsalescart-remove/'.$pro->rowId) }}"><i class="fas fa-trash"></i></a></th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                <form  method="post" action="{{ route('makequotation.invoice') }}">
                   @csrf
                   <div class="row">
                    <div class="col-md-9">
                      <input type="text" list="customer" class="form-control input-sm" name="customer_id" placeholder="Customer"  required>
                      <datalist id="customer">
                        @foreach($customer as $cus)
                          <option>{{ $cus->id }} : {{ $cus->c_name }} : {{ $cus->c_code }}</option>
                        @endforeach
                      </datalist>  
                    </div> 

                    {{-- <div class="col-md-9">
                      <select class="form-control" name="customer_id" id="newCustomer" required>
                      <option value="" selected disabled>Select Customer</option>
                        @foreach($customer as $cus)
                          <option value="{{ $cus->id }}"> {{ $cus->c_name }} : {{ $cus->c_contact }}</option>
                        @endforeach
                      </select>  

                    </div>  --}}

                    <div class="col-md-3">
                        <a href="#" class="btn btn-md btn-primary pull-right waves-effect wave-light" data-toggle="modal" data-target="#modalcustomer" >Add New</a>
                    </div>       
                </div><br>

                <div class="form-group row">
                      
                  <div class="col-xs-6" style="padding-left: 15px">

                    <div class="input-group">
                      {{-- <select onchange="yesnoCheck(this);" class="form-control" name="payment_method" id="newPaymentMethod" required>
                        
                          <option value="">Select payment method</option>
                          <option value="cash">Cash</option>
                          <option value="Card">Card</option>
                          <option value="Cheque">Cheque</option>

                      </select> --}}
                      <input class="form-control input-sm" type="text" name="payment_method"placeholder="Payment Method" required>

                    </div>

                  </div>

                  <div class="paymentMethodBoxes"></div>
                  <div class="col-xs-6" style="padding-left: 15px;" style="margin-top: -4px;">
                    <input class="form-control input-sm" type="number" name="amount_paid" placeholder="Paid Amount" required>
                  </div>
                </div>

                <div>
                  <input class="form-control input-sm" type="text" name="cash_description" placeholder="Cash Description" required>
                  <br>
                  <input class="form-control input-sm" type="text" name="card_description" placeholder="Card Description" required>
                  <br>
                  <textarea type="text" class="form-control input-lg" id="cheque_description" name="cheque_description" placeholder="Cheque Description"></textarea>
                </div>

                <br>


                <div class="pricing-header" style="background-color: #d4af37;">
                    
                    <div class="row text-white">
                        <div class="col-md-4"><p>Quantity: {{ Cart::count() }}</p></div>
                        <div class="col-md-4"><p>Sub Total: {{ Cart::subtotal() }}</p></div>
                      </div>
                    <hr>
                    <input type="hidden" name="carttotal" value="{{ Cart::total() }}">     
                    <p><h4 class="text-white">Grand Total:</h4><h3 class="text-white">{{ Cart::total() }}</h3></p>
                </div> 
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <a href="{{ route('quotationclear-cart') }}" class="btn btn-danger">Clear Cart</a>
                    <button type="submit" class="btn btn-info" formaction="" onclick="this.form.submit(); this.disabled=true;">Send for Approval</button>   
                </div> <!-- end Pricing_card -->
    

</form>


        </div>
      </div>
    </div>
</div>










<!-----------------------------------------------POS-------------------------------------------------------------------->

<!-----------------------------------------------Products-------------------------------------------------------------------->
<div class="col-lg-7 col-xs-12">
   <div class="card">
      <div class="card-body">
        <div class="container">
          <div><h5>Product List</h5></div>
            <div>
            <form action="{{ url('advancedsalescart-add_barcode') }}" id="barcodeForm" method="post">
              @csrf
               <div class="row">  
               <strong>&nbsp;&nbsp;&nbsp;Barcode:&nbsp;&nbsp;</strong>     
              <input type="text" name="barcode_input" placeholder="Barcode"  autofocus>
              </div><br>
            </form>
            </div>
            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Stock</th>
                        <th>Selling Price</th>
                        <th>Action</th>
                    </tr>
                </thead>

         
                <tbody>
                    @foreach($product as $row)
                        <tr>
                            <form action="{{ url('advancedsalescart-add') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $row->id }}">
                                <input type="hidden" name="name" value="{{ $row->p_name }}">
                                <input type="hidden" name="qty" value="1">
                                <input type="hidden" name="weight" value="1">
                                <input type="hidden" name="p_sell" value="{{ $row->p_sell }}">
                            <td>{{ $row->p_name }}</td>
                            <td>{{ $row->p_sku }}</td>
                            <td>{{ $row->p_total }}</td>
                            <td>{{ $row->p_sell }}</td>
                            <td>
                                
                                <button type="submit" class="btn btn-info btn-sm">Add</button>
                            </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


      </div>
    </div>
 </div>


</div><!-- /.row -->









<!-------------------------------------------------Products Scripts------------------------------------------------------------------>

 {{-- Add Customer Table-------------------------------------------------------------------------------------------- --}}
        <!--==========================
		  =  Modal window for Add Customer    =
		  ===========================-->

		<!-- Modal -->
		<div id="modalcustomer" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <form role="form" action="{{ url('/add_customer') }}" method="post" enctype="multipart/form-data">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="background: green; color: white">
		          	<h4 class="modal-title">Add Customer</h4>
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
		                    <input type="text" class="form-control input-lg" name="c_name" placeholder="Name" required>
                      </div>
		                </div>
		              </div>

                  <div class="form-group">          
                    <div class="input-group">             
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Customer Code:</strong>
                        <input type="text" class="form-control input-lg" name="c_code" placeholder="Customer Code" required>
                      </div>
                    </div>
                  </div>
		              
		              <!-- TAKING Amount -->
		              
		              {{-- <div class="form-group">      
		                <div class="input-group">                 
		                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Contact:</strong>
		                    <textarea type="text" class="form-control input-lg" name="c_contact" placeholder="Contact" required></textarea>
                      </div>
		                </div>
		              </div> --}}
                  <div class="form-group">      
                    <div class="input-group">                 
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <strong>Contact:</strong>
                        {{-- <textarea type="text" class="form-control input-lg" name="c_contact" placeholder="Contact" required></textarea> --}}
                        <input class="form-control input-lg" type="text" id="fname" name="line_one" placeholder="Address Line 1" maxlength="40" size="40"><br>
                        <input class="form-control input-lg" type="text" id="fname" name="line_two" placeholder="Address Line 2" maxlength="40" size="40"><br>
                        <input class="form-control input-lg" type="text" id="fname" name="line_three" placeholder="Address Line 3" maxlength="40" size="40"><br>
                        <input class="form-control input-lg" type="text" id="fname" name="phone_no" maxlength="40" size="40" placeholder="Phone No.">
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

</div>

		<!--====  End of module Modal window for Add To MH  ====-->
        {{-- Add Customer Table-------------------------------------------------------------------------------------------- --}}









<!-------------------------------------------------Supplies Scripts------------------------------------------------------------------>

<script type="text/javascript">
  function yesnoCheck(that) {
    if (that.value == "Cheque") {
    // alert("check");
          document.getElementById("ifYes").style.display = "block";
      } else {
          document.getElementById("ifYes").style.display = "none";
      }
  }
</script>
@endsection