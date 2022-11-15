<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     {{-- CSRF Token --}}
    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="{{asset('asset/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{asset('asset/plugins/node-waves/waves.css')}}" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="{{asset('asset/plugins/animate-css/animate.css')}}" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <link href="{{asset('asset/plugins/morrisjs/morris.css')}}}" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
   <link href="{{asset('asset/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('asset/css/themes/all-themes.css')}}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"crossorigin="anonymous"></script>
    <style type="text/css">

.sidebar li .submenu{ 
	list-style: none; 
	margin: 0; 
	padding: 0; 
	padding-left: 1rem; 
	padding-right: 1rem;
}

.sidebar .nav-link {
    font-weight: 500;
    color: var(--bs-dark);
}
.sidebar .nav-link:hover {
    color: var(--bs-primary);
}

</style>


<script type="text/javascript">

	document.addEventListener("DOMContentLoaded", function(){

		document.querySelectorAll('.sidebar .nav-link').forEach(function(element){

			element.addEventListener('click', function (e) {

				let nextEl = element.nextElementSibling;
				let parentEl  = element.parentElement;	

				if(nextEl) {
					e.preventDefault();	
					let mycollapse = new bootstrap.Collapse(nextEl);

			  		if(nextEl.classList.contains('show')){
			  			mycollapse.hide();
			  		} else {
			  			mycollapse.show();
			  			// find other submenus with class=show
			  			var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
			  			// if it exists, then close all of them
						if(opened_submenu){
							new bootstrap.Collapse(opened_submenu);
						}

			  		}
		  		}

			});
		})

	}); 
	// DOMContentLoaded  end
</script>
</head>
<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
       
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar" style="background: none !important;>
        <div class="container-fluid">
            <div class="navbar-header">
                @php($role=Auth::id())
                @php($userr=App\Models\User::where('id','=',$role)->get()->first())

                @php($branch=App\Models\Branch::where('id','=',$userr->branch_id)->get()->first())
                @if(!empty($branch))
               @php($segment=App\Models\Vehicle::where('id','=',$branch->vehicle_id)->get()->first())
		@endif
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#"> </a><img src="{{asset('asset/images/CAI_png.png')}}" style="height: 54px;"> @if(!empty($branch)) {{$branch->branch}} @endif @if(!empty($segment)){{$segment->vehicle}} @endif
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                   
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                   
                  
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{asset('asset/images/user.png')}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     @php($role=Auth::id())
                        @php($userr=App\Models\User::where('id','=',$role)->get()->first())
                        @if($userr->role=="")
                        {{$userr->name}}
                   @else
                   {{$userr->name}}
                   @endif
                    </div>
                    
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{url('admin/reset')}}"><i class="material-icons">person</i>Reset Password</a></li>
                           
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li @if($request->is('admin/welcome')) class="active" @endif>
                <a href="{{route('admin.welcome')}}">
                 <i class="material-icons">home</i>
                 <span>Welcome</span>
                </a>
            </li>
            <li @if($request->is('admin/thankyou')) class="active" @endif>
                <a href="{{route('admin.thankyou')}}">
                 <i class="material-icons">home</i>
                 <span>Thank You</span>
                </a>
            </li>
                    <li class="nav-item has-submenu @if(($request->is('admin/vehicle-segment'))||($request->is('admin/branch'))||($request->is('admin/desigination'))||($request->is('admin/employee'))||($request->is('admin/model'))||($request->is('admin/varient'))||($request->is('admin/place')))active @endif">
		            <a class="nav-link" href="#">  
                   <i class="material-icons">home</i>
                   <span>Master</span>
                  </a>
		    <ul class="submenu collapse">
			
           
            @php($id=Auth::id())
            @php($user=App\Models\User::where('id','=',$id)->get()->first())
            @if(($user->desigination_id==3)||($user->desigination_id==4))
            <li><a class="nav-link" href="{{route('admin.vehicle-segment')}}">Vehicle Segment</a></li>
            <li><a class="nav-link" href="{{route('admin.model')}}">Model</a></li>
            <li><a class="nav-link" href="{{route('admin.varient')}}">Varient</a></li>
            <li><a class="nav-link" href="{{route('admin.desigination')}}">Designation</a></li>
            <li><a class="nav-link" href="{{route('admin.branch')}}">Branch</a></li>
            <li><a class="nav-link" href="{{route('admin.employee')}}">Employee</a></li>
            <li><a class="nav-link" href="{{route('admin.place')}}">Place</a></li>

            @elseif($user->desigination_id==1)
            <li><a class="nav-link" href="{{route('admin.vehicle-segment')}}">Vehicle Segment</a></li>
            <li><a class="nav-link" href="{{route('admin.model')}}">Model</a></li>
            <li><a class="nav-link" href="{{route('admin.varient')}}">Varient</a></li>
            <li><a class="nav-link" href="{{route('admin.place')}}">Place</a></li>
           
            @else
             <li><a class="nav-link" href="{{route('admin.place')}}">Place</a></li>
            @endif 
            </ul>
	        </li>
            
            
               <li class="nav-item has-submenu @if(($request->is('admin/welcome-report')))active @endif">
                    <a class="nav-link" href="#">  
                   <i class="material-icons">home</i>
                   <span>Reports</span>
                  </a>
            <ul class="submenu collapse">
            <li><a class="nav-link" href="{{route('admin.welcome-report')}}">Welcome SMS Sent</a></li>
            <li><a class="nav-link" href="{{route('admin.thankyou-report')}}">Thankyou SMS Sent</a></li>
            <li><a class="nav-link" href="{{route('admin.thankyou-pending-report')}}">Thankyou SMS Pending</a></li>
            
            </ul>
            </li>
            <li @if($request->is('admin/smscampaign')) class="active" @endif>
                <a href="{{route('admin.smscampaign')}}">
                 <i class="material-icons">home</i>
                 <span>SMS Campaign</span>
                </a>
            </li>
            </ul>
            </div>

            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; {{date('Y')}} <a href="javascript:void(0);">Kambaa Inc</a>.
                </div>
                
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>
