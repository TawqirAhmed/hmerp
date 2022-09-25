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
                                <th>Percentage</th>
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
                                <th>{{ $pro->qty }}</th>
                                <th>{{ $pro->price }}</th>
                                <th>{{ $pro->price*$pro->qty  }}</th>
                                <th>
                                  <form action="{{ url('/cart-updatepercentage/'.$pro->rowId) }}" method="post">
                                  @csrf
                                  <input type="number" name="percentage" value="0" style="width: 80px" onchange="">
                                  <input type="hidden" name="qty" value="{{ $pro->qty }}">
                                  <input type="hidden" name="p_price" value="{{ $pro->price }}">
                                  <input type="hidden" name="pid" value="{{ $pro->id }}">
                                  <input type="hidden" name="sale_id" value="{{ $salestoapprove->id }}">
                                  <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                  <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i></button>
                                  </form>
                                </th>

                                {{-- <th><a href="{{ url('/cart-remove/'.$pro->rowId) }}"><i class="fas fa-trash"></i></a></th> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                <form  method="post" action="{{ route('approve.invoice') }}">
                   @csrf

                    <input type="hidden" name="sale_id" value="{{ $salestoapprove->id }}">


                   <div class="row">
                    <div class="col-md-6">
                      <strong>Customer</strong>
                      
                      <input type="text" list="customer" class="form-control input-sm" name="customer_id" placeholder="Customer" value="{{ $customer->c_name }}" required readonly>
                    
                    </div>  
                    <div class="col-md-6">
                      <strong>VAT %</strong>
                      
                      <input type="number" class="form-control input-sm" name="vat_percent" placeholder="VAT %" required>
                    
                    </div>    
                </div><br>

                <div class="form-group row">
                      
                  <div class="col-md-6" style="padding-left: 15px">
                    <strong>Payment Method</strong>
                    
                      <input type="text" class="form-control" name="payment_method" id="newPaymentMethod" value="{{ $salestoapprove->payment_method }}" required readonly>
                    

                  </div>

                  <div class="paymentMethodBoxes"></div>
                  
                  <div class="col-md-6" style="padding-left: 15px;" style="margin-top: -4px;">
                    <strong>Paid Amount</strong>
                    
                    <input class="form-control input-sm" type="text" name="amount_paid" placeholder="Paid Amount" value="{{ $salestoapprove->amount_paid }}" required>
                    
                  </div>
                </div>

                <div class="form-group row">
                      
                  <div class="col-md-6" style="padding-left: 15px">
                    <strong>Cash Details</strong>
                    
                      <input type="text" class="form-control" name="cash_description" id="newPaymentMethod" placeholder="Cash Details" value="{{ $paymentDescription[0] }}" required>
                    

                  </div>

                  <div class="paymentMethodBoxes"></div>
                  
                  <div class="col-md-6" style="padding-left: 15px;" style="margin-top: -4px;">
                    <strong>Card Details</strong>
                    
                    <input class="form-control input-sm" type="text" name="card_description" placeholder="Card Details" value="{{ $paymentDescription[1] }}" required>
                    
                  </div>
                </div>
                <div class="form-group row">
                      
                  <div class="col-md-12" style="padding-left: 15px">
                    <strong>Cheque Details</strong>
                    
                      <input type="text" class="form-control" name="cheque_description" id="newPaymentMethod" placeholder="Cheque Details" value="{{ $paymentDescription[2] }}" required>
                    
                  </div>
                </div>


                <div class="pricing-header" style="background-color: #d4af37;">
                    
                    <div class="row text-white">
                        <div class="col-md-4"><p>Quantity: {{ Cart::count() }}</p></div>
                        <div class="col-md-4"><p>Sub Total: {{ Cart::subtotal() }}</p></div>
                        <div class="col-md-4"><p>VAT: {{ Cart::tax() }}</p></div>
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
                    <a href="{{ route('percent_clear-cart') }}" class="btn btn-danger">Clear Cart</a>
                    <button type="submit" class="btn btn-info" formaction="" onclick="this.form.submit(); this.disabled=true;">Approve</button>   
                </div> <!-- end Pricing_card -->


</form>


        </div>
      </div>
    </div>
</div>

</div>








<!-----------------------------------------------POS-------------------------------------------------------------------->

@endsection