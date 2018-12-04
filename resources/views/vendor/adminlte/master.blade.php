<!DOCTYPE html>
<html>
<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
    @yield('title', config('adminlte.title', 'AdminLTE 2'))
    @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">
    
    <!-- stop watch starts here -->
    <link href="{{asset('time/TimeCircles.css')}}" rel="stylesheet" type="text/css">
    
    <!-- stop watch ends here -->
    
    
    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css">
    @endif

    @yield('adminlte_css')
        
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('body_class')">
    
@yield('body')
<!-- start of fetch cookie value -->
<input type="hidden" id="dateCookie" value="{{Cookie::get('date')}}" name="cookie" />
<input type="hidden" id="timeCookie" value="{{Cookie::get('time')}}" name="cookie" />
<!--end-->
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!--start of Stop watch JS-->
<script src="{{ asset('time/TimeCircles.js')}}"></script>
 <script>
     
            
            
            
            var date;
            var time;
            var datetime;
            var digitsOfDate;
            var digitsofHours;
            var digitsofMinutes;
            var d = new Date();
            var cookieDate = $('#dateCookie').val();
            var cookieTime = $('#timeCookie').val();
            
             
             
    
            @if(\Session::has('pause'))
                
                $("#DateCountdown").TimeCircles({start: false});               
                 @php
              \Session::forget('pause');
              @endphp
            
            @else    
                $("#DateCountdown").TimeCircles();
            @endif
            if(d.getDate()<10)
                digitsOfDate = "0"+d.getDate();
            if(d.getHours()<10)
                digitsofHours = "0"+d.getHours();
            if(d.getMinutes()<10)
                digitsofMinutes = "0"+d.getMinutes();
                
            $(".startTimer").click(function() {
                if(cookieDate != null)
                {
                    date = cookieDate;
                    time = cookieTime;
                }
                else
                {
                    date = d.getFullYear()+"-"+d.getMonth()+"-"+d.getDate();
                    time = d.getHours()+":"+d.getMinutes();
                }
                     
                datetime = date + ' ' + time + ':00';
               
                $("#DateCountdown").TimeCircles().start();
            });
            $(".stopTimer").click(function() {
                $("#DateCountdown").TimeCircles().stop();
            });
 </script>      
<!--end of Stop watch JS-->
@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif

@yield('adminlte_js')

</body>
</html>
