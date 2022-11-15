@include('partials.adminheader')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>
           <form action="{{ route('searchwelcome') }}" method="POST" id="form">
            @csrf
            <div class="row clearfix">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="from_date" id="from_date" value="{{$from}}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="to_date" id="to_date" value="{{$to}}">
                </div>
                <div class="col-md-2">
                    
                    <select class="form-control" name="branch" id="branch">
                        <option value="All">All</option>
                        @foreach($branches as $branche)
                        <option value="{{$branche->id}}" @if($branch==$branche->id) selected @endif>{{$branche->branch}}</option>
                        @endforeach
                    </select>
                    
                </div>
                
                <div class="col-md-2">
                    <input type="hidden" name="page" value="welcome">
                    <input type="submit" name="search" class="btn btn-primary" value="Search">
                </div>
                
                 <div class="col-md-3"></div>
            </div>
            </form>
            <br><br>
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-purple hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons"></i>
                        </div>
                        <div class="content">
                            <a href="{{url('admin/welcome-report')}}"><div class="text">Welcome</div>
                            <div class="number count-to" data-from="0" data-to="{{$welcome}}" data-speed="1000" data-fresh-interval="20"></div></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons"></i>
                        </div>
                        <div class="content">
                            <a href="{{url('admin/thankyou-report')}}"><div class="text">Thankyou</div>
                            <div class="number count-to" data-from="0" data-to="{{$thank}}" data-speed="1000" data-fresh-interval="20"></div></a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons"></i>
                        </div>
                        <div class="content">
                            <a href="{{url('admin/thankyou-pending-report')}}"><div class="text">Thankyou Pending</div>
                            <div class="number count-to" data-from="0" data-to="{{$pending}}" data-speed="1000" data-fresh-interval="20"></div></a>
                        </div>
                    </div>
                </div>
               
            </div>
            
            <!-- Widgets -->
           
            <!-- #END# Widgets -->
            <!-- Widgets -->
          
        </div>
    </section>
    <!-- Jquery Core Js -->
    <script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{asset('asset/plugins/bootstrap/js/bootstrap.js')}}"></script>
    <!-- Select Plugin Js -->
    <script src="{{asset('asset/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('asset/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('asset/plugins/node-waves/waves.js')}}"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{asset('asset/plugins/jquery-countto/jquery.countTo.js')}}"></script>
    <!-- Morris Plugin Js -->
    <script src="{{asset('asset/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('asset/plugins/morrisjs/morris.js')}}"></script>
    <!-- ChartJs -->
    <script src="{{asset('asset/plugins/chartjs/Chart.bundle.js')}}"></script>
    <!-- Flot Charts Plugin Js -->
    <script src="{{asset('asset/plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{asset('asset/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('asset/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('asset/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{asset('asset/plugins/flot-charts/jquery.flot.time.js')}}"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="{{asset('asset/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{asset('asset/js/admin.js')}}"></script>
    <script src="{{asset('asset/js/pages/index.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('asset/js/demo.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script type="text/javascript">
       $('.datepicker').datepicker({
           dateFormat: 'dd-mm-yy'
       });
   </script>
</body>
</html>
