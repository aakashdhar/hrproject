<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> .: Siimteq HR |
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 2'))
        @yield('title_postfix', config('adminlte.title_postfix', '')):.
    </title>


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    <!--toast css-->
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">


    <!-- stop watch starts here -->
    <link href="{{asset('time/TimeCircles.css')}}" rel="stylesheet" type="text/css">
    <!-- stop watch ends here -->

    <!--start of validateTaskBeforeAssignment.js-->
        <script src="{{ asset("task/validateTaskBeforeAssignment.js") }}"></script>
    <!--end of validateTaskBeforeAssignment.js-->

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

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!--toast js-->
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

<?php
    $data = null;
    if(!empty(Session::get("usertaskdata")))
    {
        $data = Session::get("usertaskdata");
    }
?>
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
            @if(!empty($data))
            var cookieDate =  "<?=$data[0]['date']?>";
            @endif
            @if(!empty($data))
            var cookieTime =  "<?=$data[0]['time']?>";
            @endif

            $("#DateCountdown").TimeCircles().stop();
            if(d.getDate()<10)
                digitsOfDate = "0"+d.getDate();
            if(d.getHours()<10)
                digitsofHours = "0"+d.getHours();
            if(d.getMinutes()<10)
                digitsofMinutes = "0"+d.getMinutes();
            <!--start watch-->
            $(".startTimer").click(function() {
                if(cookieDate!="")
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
            <!--stop or pause watch-->

            $(".stopTimer,.pauseTimer").click(function() {
                $("#DateCountdown").TimeCircles().stop();
            });
 </script>

        <script>

    $(document).ready(function(){
                var sysdate = new Date();
                day = sysdate.getDate();
                month = sysdate.getMonth() + 1;
                year = sysdate.getFullYear();
                var regrex = new RegExp("[^A-z.]","g");
                var regrex2 = new RegExp("[^A-z.,@%&]","gm");
                var startdate;
                var enddate;
                var subject;
                var reason;
                var result;

                $('.button').click(function(){
                    startdate = new Date($('#startdate').val());
                    enddate = new Date($('#enddate').val());
                    subject = $("#subject").val();
                    reason = $("#reason").val();
                    if(startdate < sysdate)
                    {
                        $(".startdate").html("Date should be tomorrow or after it");
                    }
                    if(enddate<=startdate)
                    {
                        $(".enddate").html("Date must be of future");
                    }

                    while((result = regrex.exec(subject)) !=null)
                    {
                        $(".subject").html("Only alphabtes and .");
                    }

                    while((result = regrex2.exec(reason)) !=null)
                    {
                        $(".reason").html("Only alphabtes, numbers and .,@%&");
                    }
//                      setTimeout(location.reload.bind(location), 5000);
                });
                $("#startdate").blur(function (){

                    startdate = new Date($('#startdate').val());
                    if(startdate => sysdate)
                    {
                        $(".startdate").html("");
                    }
                    });
                $("#enddate").blur(function (){
                       enddate = new Date($('#enddate').val());
                       if(enddate>startdate)
                        {
                            $(".enddate").html("");
                        }
                    });
                $("#subject").blur(function (){
                        while((result = regrex.exec(subject)) !=null)
                        {
                            $(".subject").html("");
                        }
                    });
                $("#reason").blur(function (){
                        while((result = regrex2.exec(reason)) !=null)
                        {
                            $(".reason").html("");
                        }
                    });


                $("#startbu").blur(function (){
                        while((result = regrex2.exec(reason)) !=null)
                        {
                            $(".reason").html("");
                        }
                    });
                $("#starttask").click()
                {
                    $("#stopbutton").attr("style","");
                }
    });

        </script>

<!--end of Stop watch JS-->
 <!--start message box
 {{-- <script src="{{ asset("massage_box/jquery.bs.msgbox.js") }}"></script> --}}
 <script>
    $(document).ready(function(event){
        $( "#assign" ).click(function() {
        var task = $("#task").val();
        if(task!='')
        {
            $('body').bsMsgBox({
                title: "Task",
                text: "Task is assigned",
                icon: 'ok'
            });
        }
        });
    });

</script>

 <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>-->
 <!--end message box-->

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
<script>
    $(document).ready(function() {
        $('tr.data-list').hide();
    });
    var data_details = function(cls) {
        $('tr'+cls).toggle();
    }
</script>
</body>
</html>
