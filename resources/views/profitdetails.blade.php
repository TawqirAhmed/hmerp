@extends('home.homeTwo')
@section('content')

<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profits</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!--/table starts-->
<div class="card">
	<div class="card-header">
		<h3 class="card-title" style="color: red;">Profit Of Sale Reference No: {{ $profit_single->p_bill_code  }} is = {{ $profit_single->p_total  }}</h3>
		              
	</div>
  <!-- /.card-header -->
  <div class="card-body">
  	 <div class="box-body">

        <!--==========================
          =  Table for  Users    =
          ===========================-->
          @php
            $Sessionid=Auth::id();
            $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
            $sessionRole = $Sessionuser->role;
          @endphp
        <table id="datatable" class="table table-bordered table-striped dt-responsive tables" width="100%">
          
          <thead>
            
            <tr>
              
              <th class="text-center" style="width:10px">S/N</th>
              <th class="text-center">Name</th>
              <th class="text-center">Bought At</th>
              <th class="text-center">Sold At</th>
              <th class="text-center">QTY</th>
              <th class="text-center">Discount</th>
              <th class="text-center">Discount %</th>
              <th class="text-center">Profit</th>

            </tr>

          </thead>

          <tbody>
          	@foreach($all_sale_data as $row)
                <tr>
                	<td>{{ $row->id }}</td>
                    <td>{{ $row->pro_name }}</td>
                    {{-- <td>{{ $row->pro_photo }}</td> --}}
                    {{-- <td><img src="{{ $row->pro_photo }}" style="height: 40px; width: 40px"></td> --}}
                    <td>{{ $row->p_buy }}</td>
                    <td>{{ $row->selling_price }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->p_discount }}</td>
                    <td>{{ $row->p_discount_per * -1 }}</td>
                    <td>{{ $row->profit_total }}</td>
                </tr>
            @endforeach
          </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->


{{-- <script type="text/javascript">
	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#image')
					.attr('src', e.target.result)
					.width(80)
					.hight(80)
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script> --}}
@endsection