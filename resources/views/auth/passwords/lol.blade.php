@extends('home.homeTwo')
@section('content')

@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  // echo "<pre>";
  // print_r($role);
  // exit();

  if ($role !=1){

    echo "<pre>";
    echo '<h1 style="margin: auto; text-align: center; font-size: 70px">"You Shall Not Pass!!!!" &#129497;</h1>';
    // echo '<a href="{{ route('.'home'.') }}" class="btn btn-success btn-sm">Home</a>';
    exit();

  }
  
@endphp
<div style="text-align: center; margin: auto;">
	{{-- <a href="{{ route('backupdb') }}" class="btn btn-success">Backup</a> --}}

	<a href="{{ route('download') }}" class="btn btn-sm btn-primary"><i class="fa fa-download"></i>Download Backup</a>
</div>


@endsection