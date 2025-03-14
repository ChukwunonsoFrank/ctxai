<!DOCTYPE html>

<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Nxcai </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="/homeassets/img/Ctxailogo.png">
    <link href="{{ url('userassets/vendor/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link href="{{ url('userassets/vendor/chartist/css/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ url('userassets/css/style.css') }}" rel="stylesheet">

    <link href="{{ url('userassets/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" rel="stylesheet">

    <style>
        #myTable{
            width:100%!important;
        }
    </style>
</head>

<body>
  <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        @include('admin.layout.header')

        @include('admin.layout.sidebar')

        @yield('content')


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © {{ env('APP_NAME') }}</p>
                <p>Designed by delicon</a></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
 
    <script src="{{ url('userassets/vendor/global/global.min.js') }}"></script>
    <script src="{{ url('userassets/js/quixnav-init.js') }}"></script>
    <script src="{{ url('userassets/js/custom.min.js') }}"></script>

    <script src="{{ url('userassets/vendor/chartist/js/chartist.min.js') }}"></script>

    <script src="{{ url('userassets/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ url('userassets/vendor/pg-calendar/js/pignose.calendar.min.js') }}"></script>


    <script src="{{ url('userassets/js/dashboard/dashboard-2.js') }}"></script>
    <!-- Circle progress -->

    <script src="{{ url('userassets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

    <script type="text/javascript">
 
//      $('.show_confirm').click(function(event) {
//           event.preventDefault();
//           Swal.fire(
//   'Good job!',
//   'You clicked the button!',
//   'success'
// )
//       });
  
</script>

    @yield('footer')

</body>

</html>


