<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>ERP Barcodes</title>
    <style>
		div.b128{
		 border-left: 1px black solid;
		 height: 30px;
		} 
	</style>

    {{-- <h1>{{ $ProductName }}</h1> --}}

   </head>
<body onload="window.print();">

	{{-- <h1>{{ $code }}</h1>

	<h1>{{ $length }}</h1> --}}

	{{-- @for ($i = 0; $i <= $amount; $i++)

		{!! $data !!}&nbsp&nbsp&nbsp&nbsp;
	 
	@endfor --}}
	<p>{!! $data !!}</p>


  
</body>
</html>