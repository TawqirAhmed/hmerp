@extends('home.homeTwo')
@section('content')

<div class="row">
<div class="col-lg-2 col-xs-12"></div>
<div class="col-lg-8 col-xs-12">
	<div class="card" style="padding: auto;">
      <div class="card-body">
        <div class="container">
          

              <div><h5>Invoice NO: {{ $salestoapprove->bill_code }}</h5></div>
        
                <div class="price_card text-center">
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                {{-- <th>Percentage</th> --}}
                                {{-- <th>Action</th> --}}
                            </tr>    
                        </thead>
                        @php
                        
                        $customer = DB::table('customers')->where('id',$costomerid)->first();

                        $listproduct = Cart::content()

                        @endphp
                        
                        <tbody>
                            @foreach($listproduct as $pro)
                            <tr>
                                <th>{{ $pro->name }}</th>
                                {{-- <th>{{ $pro->qty }}</th> --}}
                                <th>
	                                <form  action="{{ url('/cart-updatedue/'.$pro->rowId) }}" method="post">
	                                  @csrf
	                                  <input type="hidden" name="idProduct" value="{{ $pro->id }}">
	                                  <input type="hidden" name="selling_price" value="{{ $pro->price }}">
	                                  <input type="hidden" name="bill_code" value="{{ $salestoapprove->bill_code }}">
	                                  <input type="hidden" name="customer_id" value="{{ $costomerid }}">
	                                  <input type="number" name="qty" value="{{ $pro->qty }}" style="width: 80px">
	                                  <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i></button>
	                                </form>
                                </th>
                                <th>{{ $pro->price }}</th>
                                <th>{{ $pro->price*$pro->qty  }}</th>
                                {{-- <th><a href="{{ url('/cart-remove/'.$pro->rowId) }}"><i class="fas fa-trash"></i></a></th> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                <form  method="post" action="{{ route('due.invoice') }}">
                   @csrf

                    <input type="hidden" name="sale_id" value="{{ $salestoapprove->id }}">


                   <div class="row">
                    <div class="col-md-9">
                      <input type="text" list="customer" class="form-control input-sm" name="customer_id" placeholder="Customer" value="{{ $customer->c_name }}" required readonly>
                    </div>     
                </div><br>

                <div class="form-group row">
                      
                  <div class="col-xs-6" style="padding-left: 15px">

                    <div class="input-group">
                      <input type="text" class="form-control" name="payment_method" id="newPaymentMethod" value="{{ $salestoapprove->payment_method }}" required readonly>
                    </div>

                  </div>

                  <div class="paymentMethodBoxes"></div>
                  <div class="col-xs-6" style="padding-left: 15px;" style="margin-top: -4px;">
                    <input class="form-control input-sm" type="text" name="amount_paid" placeholder="Paid Amount" value="{{ $salestoapprove->amount_paid }}" required>
                  </div>
                </div>


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
                    <a href="{{ route('due_clear-cart') }}" class="btn btn-danger">Clear Cart</a>
                    <button type="submit" class="btn btn-info" formaction="" onclick="this.form.submit(); this.disabled=true;">Update</button>   
                </div> <!-- end Pricing_card -->
    

</form>


        </div>
      </div>
    </div>
</div>

</div>








<!-----------------------------------------------POS-------------------------------------------------------------------->

@endsection