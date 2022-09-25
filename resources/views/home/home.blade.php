<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HMG ERP</title>
  <!-- Tell the browser to be responsive to screen width -->
  {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('public/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

{{-- <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> --}}
  
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('public/plugins/yajra/Data Tables/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/plugins/yajra/Data Tables/jquery.dataTables.min.css') }}"> --}}

  



  <!-- Toaster -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
</head>
<body class="hold-transition sidebar-collapse sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  {{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> --}}
    <nav class="main-header navbar navbar-expand navbar-dark navbar-light" style="background-color: #d4af37;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

      
    <!-- SEARCH FORM -->
    

    @php
      $sales = DB::table('salestoapprove')->get();
      $advancedSales = DB::table('advancedsalestoapprove')->get();
      $salesCount = count($sales);
      $advancedSalescount = count($advancedSales);

      $totalCount = $salesCount + $advancedSalescount;

    @endphp


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown" style="margin-right: 10px">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>

            @if($totalCount>0)
              <span class="badge badge-danger navbar-badge">{{ $totalCount }}</span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
              <h3 class="dropdown-item-title">
                Sales
                <span class="float-right text-sm text-danger">{{ $salesCount }}</span>
              </h3>
              <p class="text-sm">Approval Pending</p>
              </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
              <h3 class="dropdown-item-title">
                Advanced Sales
                <span class="float-right text-sm text-muted">{{ $advancedSalescount }}</span>
              </h3>
              <p class="text-sm">Approval Pending</p>
              </div>
            </div>
            <!-- Message End -->
            </a>
            
          </div>
          </li>
      <!-- User Dropdown Menu -->

      @php

        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
        $role = $Sessionuser->role;
      @endphp


      <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        {{-- <img class="img-circle" alt="kishorami" src="{{ asset($Sessionuser->photo) }}" width="50" style="opacity: .8"> --}}
        <span class="hidden-xs">{{ $Sessionuser->name }}</span> </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            {{-- <img class="img-circle" alt="kishorami" src="{{ asset($Sessionuser->photo) }}"> --}}
            <p>{{ $Sessionuser->name }}</p>
          </li>
          <!-- Menu Body -->
                          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-right"> <a href="{{ route('logout') }}"  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign Out</a> </div>
          </li>
        </ul>
      </li>

      <!-- User Dropdown Menu -->

      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  {{-- <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000080;"> --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #3c8dbc;">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{ asset('public/images/default/ProPic.jpg') }}"  class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ERP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          


        {{-- -------------------------------------------------------------------------------------------- --}}

            @if($role !=3) 
              @if($role !=5)
                <li class="nav-item">
                  <a href="{{route('mh')}}" class="nav-link active" style="background-color: #d4af37;">
                    {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                    <i class="nav-icon fas fa-file-invoice"></i>
                    <p>
                      Accounts
                    </p>
                  </a>
                </li>
              @endif 
           @endif 
              

        @if($role !=4)

        <li class="nav-item has-treeview">
              <a href="#" class="nav-link active" style="background-color: #d4af37;">
                {{-- <i class="nav-icon fa fa-archive"></i> --}}
                <i class="nav-icon fas fa-warehouse"></i>
                <p>
                  Inventory
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{route('stockin_barcode')}}" class="nav-link" >
                     {{-- <i class="nav-icon fas fa-shopping-cart"></i> --}}
                     <i class="nav-icon fas fa-box-open"></i>
                    <p>
                      Add Products
                    </p>
                  </a>
                </li>

                @if($role !=3) 
                <li class="nav-item">
                  <a href="{{route('stockin')}}" class="nav-link" >
                     {{-- <i class="nav-icon fas fa-shopping-cart"></i> --}}
                     <i class="nav-icon fas fa-boxes"></i>
                    <p>
                      Stock In
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{route('productinfo')}}" class="nav-link" >
                     {{-- <i class="nav-icon fas fa-shopping-cart"></i> --}}
                     <i class="nav-icon fas fa-boxes"></i>
                    <p>
                      Product Information
                    </p>
                  </a>
                </li>

                @endif

                <li class="nav-item">
                  <a href="{{route('stockout')}}" class="nav-link" >
                     {{-- &nbsp;&nbsp; --}}<i class="nav-icon fas fa-dolly-flatbed"></i>
                     {{-- <i class="fas fa-dolly-flatbed"></i> --}}
                    <p>
                      Stock Out
                    </p>
                  </a>
                </li>

                @if($role !=3) 

                <li class="nav-item">
                  <a href="{{route('stockoutrecords')}}" class="nav-link" >
                     {{-- &nbsp;&nbsp; --}}<i class="nav-icon fas fa-clipboard"></i>
                     {{-- <i class="far fa-clipboard"></i> --}}
                    <p>
                      Stock Out Records
                    </p>
                  </a>
                </li>

                @endif

                <li class="nav-item">
                  <a href="{{route('makesales')}}" class="nav-link text-white" style="background-color: #3C1053FF;">
                     {{-- &nbsp;&nbsp ;--}}<i class="nav-icon fas fa-cart-arrow-down"></i>
                     {{-- <i class="fas fa-cart-arrow-down"></i> --}}
                    <p>
                      Make Sales
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{route('advancedsales')}}" class="nav-link text-white" style="background-color: #3C1053FF;">
                     {{-- &nbsp;&nbsp; --}}<i class="nav-icon fas fa-cart-plus"></i>
                    <p>
                      Make Advance Sell
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{route('makequotation')}}" class="nav-link text-white" style="background-color: #3C1053FF;">
                     {{-- &nbsp;&nbsp; --}}<i class="nav-icon fas fa-cart-plus"></i>
                    <p>
                      Make Quotation
                    </p>
                  </a>
                </li>

                 @if($role !=3) 
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link active text-white" style="background-color: #2C5F2D;">
            <i class="nav-icon fa fa-check-double"></i>
            {{-- <i class="fas fa-check-double"></i> --}}
            <p>
              Approval
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item text-white" style="background-color: #B1624EFF;">
              <a href="{{route('salesto')}}" class="nav-link" >
                <i class="nav-icon fas fa-cart-arrow-down"></i>
                <p>
                  Sales to be Approved
                </p>
              </a>
            </li>

            <li class="nav-item text-white" style="background-color: #B1624EFF;">
              <a href="{{route('ad_salesto')}}" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                  Advanced Sales to be Approved
                </p>
              </a>
            </li>

            <li class="nav-item text-white" style="background-color: #B1624EFF;">
              <a href="{{route('qu_salesto')}}" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                  Quotation to be Approved
                </p>
              </a>
            </li>

          
          
          </ul>
        </li>
        @endif

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link active text-white" style="background-color: #990011FF;">
            <i class="nav-icon fa fa-check"></i>
            <p>
              Approved
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item text-white" style="background-color: #76528BFF;">
              <a href="{{route('approved_sales')}}" class="nav-link">
                <i class="nav-icon fas fa-cart-arrow-down"></i>
                <p>
                  Approved Sales
                </p>
              </a>
            </li>

            <li class="nav-item text-white" style="background-color: #76528BFF;">
              <a href="{{route('ad_approved_sales')}}" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                  Approved Advanced Sales
                </p>
              </a>
            </li>

            <li class="nav-item text-white" style="background-color: #76528BFF;">
              <a href="{{route('due_sales')}}" class="nav-link">
                <i class="nav-icon fas fa-exclamation-circle"></i>
                <p>
                  Dues
                </p>
              </a>
            </li>

            <li class="nav-item text-white" style="background-color: #76528BFF;">
              <a href="{{route('dueinfo')}}" class="nav-link">
                <i class="nav-icon fas fa-exclamation-circle"></i>
                <p>
                  Dues Information
                </p>
              </a>
            </li>

            <li class="nav-item text-white" style="background-color: #76528BFF;">
              <a href="{{route('qu_approved_sales')}}" class="nav-link">
                <i class="nav-icon fas fa-exclamation-circle"></i>
                <p>
                  Approved Quotation
                </p>
              </a>
            </li>
          
          
          </ul>
        </li>





          </ul>
        </li>

       

        
        @if($role !=3) 
        

        @if($role !=2) 
        <li class="nav-item">
          <a href="{{route('reports')}}" class="nav-link active" style="background-color: #d4af37;">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>
              Reports
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('profits')}}" class="nav-link active" style="background-color: #d4af37;">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Profits
            </p>
          </a>
        </li>

        @endif
     
        <li class="nav-item">
          <a href="{{route('customers')}}" class="nav-link active" style="background-color: #d4af37;">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Customers
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('suppliers')}}" class="nav-link active" style="background-color: #d4af37;">
            <i class="nav-icon fas fa-truck-moving"></i>
            <p>
              Suppliers
            </p>
          </a>
        </li>
        {{-- -------------------------------------------------------------------------------------------- --}}
            @if($role !=2)
            <li class="nav-item">
              <a href="{{route('users')}}" class="nav-link active" style="background-color: #d4af37;">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a href="{{route('employees')}}" class="nav-link active" style="background-color: #d4af37;">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>
                  Employees
                </p>
              </a>
            </li>



         @endif   
        {{-- -------------------------------------------------------------------------------------------- --}}
        @endif

        {{-- <li class="nav-item">
          <a href="{{route('our_backup_database')}}" class="nav-link active" style="background-color: #d4af37;">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Backup
            </p>
          </a>
        </li> --}}

          @php

            $authID = Auth::id();
            $authInfo  = DB::table('users')->where('id',$authID)->first();
            $authEmail  = $authInfo->email;

          @endphp

          <li class="nav-item">
              <a href="http://127.0.0.1:8000/autologin?id={{ Auth::id() }}&email={{ $authEmail }}&api_token=token" class="nav-link active" style="background-color: #d4af37;" target="_blank">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>
                  HRM
                </p>
              </a>
            </li>


          

          <li class="nav-item">
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fa fa-arrow-left"></i> 
            <p>
              Logout
            </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
            </form>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div> -->
    <!-- /.content-header -->

    <!-- Main content -->
      <main class="py-1">
            {{-- <h1 style="text-align: center;">MH ACCOUNTS</h1> --}}
            @yield('content')
      </main>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('public/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('public/dist/js/pages/dashboard.js') }}"></script> --}}
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/dist/js/demo.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}

{{-- <script src="{{ asset('public/plugins/yajra/Data Tables/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/jquery.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/jquery.validate.js') }}"></script> --}}




<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').dataTable();
    } );
</script>
<!-- SweetAlert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Toaster -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<script>
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('message') }}");
                        break;

                    case 'warning':
                        toastr.warning("{{ Session::get('message') }}");
                        break;

                    case 'success':
                        toastr.success("{{ Session::get('message') }}");
                        break;

                    case 'error':
                        toastr.error("{{ Session::get('message') }}");
                        break;
                }
              @endif
        </script>


        <script>
            $(document).on("click", "#login", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                  title: "Good job!",
                  text: "You are now logedin!",
                  icon: "success",
                });
            });
        </script>

        <script>
            $(document).on("click", "#delete", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                  title: "Are you want to delete?",
                  text: "Once deleted, you will never get it again!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal({title:"Poof! Your file has been deleted!", 
                      icon: "success",}).then(okay=>{
                      if(okay){
                            window.location.href = link;
                        }
                    });
                  } else {
                    swal("Your file is safe!");
                  }
                });
            });
            
        </script>

        <script>
            $(document).on("click", "#delete2", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                  title: "Are You Relesing This Hold Order",
                  text: "This Record will Moved To Sales",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal({title:"Your record Moved to Sales!", 
                      icon: "success",}).then(okay=>{
                      if(okay){
                            window.location.href = link;
                        }
                    });
                  } else {
                    swal("Your file is safe!");
                  }
                });
            });
            
        </script>



</body>
</html>

