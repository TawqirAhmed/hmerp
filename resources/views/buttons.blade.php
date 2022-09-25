@extends('home.home')
@extends('modals')
@section('content')

<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-9">
            
            
          </div>
          <div class="btn-group col-sm-3">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute; right: 0; margin-right: 20px;">
          Add/Make
        </button>
        <div class="dropdown-menu" style="background-color: gray;">
        	<a style="color:white; background-color: #d4af37;margin-bottom: 5px;" class="dropdown-item btn" data-toggle="modal" data-target="#modalmhadd">Add To MH</a>
        	<a style="color:white; background-color: #28a745;margin-bottom: 5px;" class="dropdown-item btn" data-toggle="modal" data-target="#modaloccpayment">OCC Payment</a>
          <a style="color:white; background-color: #28a745;margin-bottom: 5px;" class="dropdown-item btn" data-toggle="modal" data-target="#modalsupplypayment">Supply Payment</a>
          <a style="color:white; background-color: #28a745;margin-bottom: 5px;" class="dropdown-item btn" data-toggle="modal" data-target="#modalcivilpayment">Civil Payment</a>
          <a style="color:white; background-color: #28a745;margin-bottom: 5px;" class="dropdown-item btn" data-toggle="modal" data-target="#modalictpayment">ICT Payment</a>
          <a style="color:white; background-color: #28a745;margin-bottom: 5px;" class="dropdown-item btn" data-toggle="modal" data-target="#modalotherspayment">Others Payment</a>
         
          {{-- 
          <a class="dropdown-item" href="#">Something else here</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a> --}}
        </div>
      </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

	@yield('button_content')

@endsection