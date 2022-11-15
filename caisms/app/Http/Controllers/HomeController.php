<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\Desigination;
use App\Models\Employee;
use App\Models\ModelName;
use App\Models\Varient;
use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $fromdate=Session('from');
        $todate=Session('to');
        $branch=Session('branch');
        if(($fromdate!="")&&($todate!=""))
        {
          $from=$fromdate;
          $to=$todate;
        }
        else
        {
          $from='2021-09-01';
          $to=date('Y-m-d');

        }
        $id=Auth::id();
        $user=User::where('id','=',$id)->get()->first();
        if(($user->desigination_id=="1")||($user->desigination_id=="2"))
        {
          $branches=Branch::where('id','=',$user->branch_id)->where('active','=',1)->get();
          $welcome=Customer::whereBetween('walkin_date',[$from,$to])->where('branches_id','=',$user->branch_id)->count();
          $thank=Customer::whereBetween('walkin_date',[$from,$to])->where('branches_id','=',$user->branch_id)->where('thankyou_sms','=','Sent')->count();
          $pending=Customer::whereBetween('walkin_date',[$from,$to])->where('branches_id','=',$user->branch_id)->where('thankyou_sms','=','Pending')->count();

        }
        else
        {
          $branches=Branch::where('active','=',1)->get();
          $welcome=Customer::whereBetween('walkin_date',[$from,$to])->count();
          $thank=Customer::whereBetween('walkin_date',[$from,$to])->where('thankyou_sms','=','Sent')->count();
          $pending=Customer::whereBetween('walkin_date',[$from,$to])->where('thankyou_sms','=','Pending')->count();
        }
	
        return view('admin.dashboard',compact('request','from','to','branch','welcome','thank','pending','branches'));
    }


    public function vehiclesegmentmasterPage(Request $request)
 {
        return view('admin.vehicle-segment',compact('request'));
 }

 public function allvehiclesegmentMaster(Request $request)
 {
  
        $columns = array( 
                            0 =>'id',     
                            1=>'vehicle',
                            2=>'id',
                        );
  
        $totalData = Vehicle::count();
            
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
                    
        if(empty($request->input('search.value')))
        {            
            $vehicles = DB::table('vehicles')
                          ->offset($start)
                          ->limit($limit)
                          ->orderBy($order,$dir)
                          ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 

            $vehicles = DB::table('vehicles As n')
           
                     ->orWhere('n.vehicle', 'LIKE',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order,$dir)
                     ->get();

            $totalFiltered = DB::table('vehicles As n') ->offset($start)
                          ->limit($limit)
                           ->orderBy($order,$dir)
                           ->count();
        }
        $token=csrf_token();
        $data = array();
        if(!empty($vehicles))
        {
            $i = 0;
            foreach ($vehicles as $vehicle)
            {
              $i = $i+1;
                
             $show ="<input type='hidden' class='vehicle$vehicle->id' value='".$vehicle->vehicle."'>
              <a href='' class='btn btn-success btn-rounded mb-4 edit' data-toggle='modal' data-target='#modalLoginForm' style='float: left;' id='".$vehicle->id."'>
              <i class='icon-pencil'></i> Edit</a> ";

                 if($vehicle->active==1)
                 {
                  $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                 }
                 else
                 {
                  $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                 }
                
                $url =  route('activatedvehicleMaster');
                $nestedData['id'] = $i;
                $nestedData['name'] =$vehicle->vehicle;
               $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                    $show 
                <form action='{$url}'method='post'>
                <input type='hidden' name='_token' value='$token'>  
               <input type='hidden' name='vehicle_id' value='$vehicle->id'> $active</form></div>";
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        echo json_encode($json_data); 
      }
      public function addvehiclesegmentMaster(Request $request)
      {
               $input = $request->all();
              
               Validator::make($request->all(), [
                 'segmentname' => 'required',
                
              ])->validate();
               if((!isset($input['segmentid']))||($input['segmentid']==""))
               {
               $checkvehicle=Vehicle::where('vehicle','=',$input['segmentname'])->count();
              
               if($checkvehicle==0)
               { 
                   $insertvehicle=new Vehicle;
                   $insertvehicle->vehicle=$input['segmentname'];
                   $insertvehicle->active=1;
                   $insertvehicle->save();
                //    dd($insertvehicle);
                   if($insertvehicle)
                   {
                     return redirect('admin/vehicle-segment')->with('success', trans('Vehicle  Added successfully'));
                   }
               } 
                else
               {
                  
                   return redirect()->back()->with('error', trans('Vehicle already exists'));
                  
               } 
             }
             else
             {
               $getvehicle=Vehicle::where('id','=',$input['segmentid'])->get()->first();
               if(!empty($getvehicle))
               { 
                   $getvehicle->vehicle=$input['segmentname'];
                   $getvehicle->save();
                   // dd($insertimage);
                   if($getvehicle)
                   {
                     return redirect('admin/vehicle-segment')->with('success', trans('Vehicle Segment  Updated successfully'));
                   }
               } 
                else
               {
                  
                   return redirect()->back()->with('error', trans('Vehicle does not exists'));
                  
               } 
             }
       }

       public function activatedvehicleMaster(Request $request)
       {
          
             
                   $input=$request->all();
                   $vehicle=Vehicle::where('id','=',$input['vehicle_id'])->get()->first();
                   if($vehicle->active==1)
                 
                   {
                     // dd($image->active);
                       $vehicle->active="0";
                       $msg="Deactivated";
                   } 
                   else
                   {
                       $vehicle->active="1";
                       $msg="Activated";
                   }
                   $vehicle->save();
                   if($vehicle)
                   {
                       return redirect('admin/vehicle-segment')->with('success', trans('Vehicle '.$msg.' Successfully'));
                   }
                   else
                   {
                       return redirect('admin/vehicle-segment')->with('error', trans('Vehicle Not '.$msg)); 
                   }
        }
        public function branchmasterPage(Request $request)
        {
             $vehicles=Vehicle::where('active','=',1)->get();
            return view('admin.branch',compact('request','vehicles'));
        }
        public function addbranchMaster(Request $request)
  {
 
        
         $input = $request->all();
        // dd($input);
         Validator::make($request->all(), [
          'vehicle' => 'required',
          'branchname' => 'required',
          'location'=>'required',
          
         ])->validate();
         if((!isset($input['branchid']))||($input['branchid']==""))
         {
           $checkbranch=Branch::where('branch','=',$input['branchname'])->count();
           
           if($checkbranch==0)
           { 
               $newbranch=new Branch;
               $newbranch->vehicle_id=$input['vehicle'];
               $newbranch->branch=$input['branchname'];
               $newbranch->location=$input['location'];
               $newbranch->mobile=$input['mobileno'];
               $newbranch->landlineno=$input['contactnumber'];
               $newbranch->active=1;
               $newbranch->save();
               if($newbranch)
               {
                 return redirect('admin/branch')->with('success', trans('Branch  Added successfully'));
               }
           } 
            else
           {
              
               return redirect()->back()->with('error', trans('Branch already exists'));
              
           } 
        }
        else
        {
          $getbranch=Branch::where('id','=',$input['branchid'])->get()->first();
           if(!empty($getbranch))
           { 
               $getbranch->vehicle_id=$input['vehicle'];
               $getbranch->branch=$input['branchname'];
               $getbranch->location=$input['location'];
               $getbranch->landlineno=$input['contactnumber'];
               $getbranch->mobile=$input['mobileno'];
               $getbranch->save();
               if($getbranch)
               {
                 return redirect('admin/branch')->with('success', trans('Branch  updated successfully'));
               }
           } 
            else
           {
              
               return redirect()->back()->with('error', trans('Branch does not exists'));
              
           } 
        }
   }


   public function allbranchMaster(Request $request)
   {
    
          $columns = array( 
                              0 =>'id',     
                              1=>'vehicle_id',
                              2=>'branch',
                              3=>'location',
                              4=>'landlineno',
                              5=>'mobile',
                              6=>'id',
                          );
    
          $totalData = Branch::count();
              
          $totalFiltered = $totalData;
          $limit = $request->input('length');
          $start = $request->input('start');
          $order = $columns[$request->input('order.0.column')];
          $dir = $request->input('order.0.dir');
                      
          if(empty($request->input('search.value')))
          {            
              $branches = DB::table('branches')->join('vehicles','vehicles.id','=','branches.vehicle_id')
                            ->select('vehicles.vehicle','branches.id','branches.vehicle_id','branches.branch','branches.location','branches.mobile','branches.landlineno','branches.active')    
                            ->offset($start)
                            ->limit($limit)
                             ->orderBy($order,$dir)
                           ->get();
          }
          else 
          {
              $search = $request->input('search.value'); 
  
              $branches = DB::table('branches')->join('vehicles','vehicles.id','=','branches.vehicle_id')
                            ->select('vehicles.vehicle','branches.id','branches.vehicle_id','branches.branch','branches.location','branches.mobile','branches.landlineno','branches.active')
                            ->where('vehicles.vehicle', 'LIKE',"%{$search}%")
                            ->orWhere('branches.branch', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                           ->get();
  
              $totalFiltered = DB::table('branches')->join('vehicles','vehicles.id','=','branches.vehicle_id')
              ->select('vehicles.vehicle','branches.id','branches.vehicle_id','branches.branch','branches.location','branches.mobile','branches.landlineno','branches.active') 
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->count();
          }
          $token=csrf_token();
          $data = array();
          if(!empty($branches))
          {
              $i = 0;
              foreach ($branches as $branche)
              {
                $i = $i+1;
                  
                $show ="<input type='hidden' class='zone_$branche->id' value='$branche->vehicle_id'>
                <input type='hidden' class='branch_$branche->id' value='$branche->branch'>
                <input type='hidden' class='location_$branche->id' value='$branche->location'>
                <input type='hidden' class='mobile_$branche->id' value='$branche->mobile'>
                <input type='hidden' class='branchnamenumber_$branche->id' value='$branche->landlineno'>
                
               <a href='' class='btn btn-primary btn-rounded mb-4 edit' data-toggle='modal' style='float: left;'' data-target='#modalLoginForm' id='$branche->id'>
                <i class='icon-pencil'></i> Edit</a> ";
  
                   if($branche->active==1)
                   {
                    $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                   }
                   else
                   {
                    $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                   }
                  
                  $url =  route('activatedbranchMaster');
                  $nestedData['id'] = $i;
                  $nestedData['vehicle'] = $branche->vehicle;
                  $nestedData['name'] =$branche->branch;
                  $nestedData['location'] = $branche->location;
                  $nestedData['mobile'] =$branche->mobile;
                  $nestedData['branchnameno'] =$branche->landlineno;
                  $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                      $show 
                  <form action='{$url}'method='post'>
                  <input type='hidden' name='_token' value='$token'>  
                 <input type='hidden' name='branch_id' value='$branche->id'> $active</form></div>";
                  $data[] = $nestedData;
  
              }
          }
            
          $json_data = array(
                      "draw"            => intval($request->input('draw')),  
                      "recordsTotal"    => intval($totalData),  
                      "recordsFiltered" => intval($totalFiltered), 
                      "data"            => $data   
                      );
          echo json_encode($json_data); 
        }
        public function activatedbranchMaster(Request $request)
        {
           
              
                    $input=$request->all();
                   
                    $vehicle=Branch::where('id','=',$input['branch_id'])->get()->first();
                    
                    if($vehicle->active==1)
                  
                    {
                      // dd($image->active);
                        $vehicle->active="0";
                        // dd($vehicle);
                        $msg="Deactivated";
                    } 
                    else
                    {
                        $vehicle->active="1";
                        $msg="Activated";
                    }
                    $vehicle->save();
                    if($vehicle)
                    {
                        return redirect('admin/branch')->with('success', trans('Branch '.$msg.' Successfully'));
                    }
                    else
                    {
                        return redirect('admin/branch')->with('error', trans('Branch Not '.$msg)); 
                    }
         }

         public function desiginationmasterPage(Request $request)
         {
                return view('admin.desigination',compact('request'));
         }

         public function alldesiginationMaster(Request $request)
         {
          
                $columns = array( 
                                    0 =>'id',     
                                    1=>'desigination',
                                    2=>'id',
                                );
          
                $totalData = Desigination::count();
                    
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                            
                if(empty($request->input('search.value')))
                {            
                    $desiginations = DB::table('desiginations')
                                  ->offset($start)
                                  ->limit($limit)
                                  ->orderBy($order,$dir)
                                  ->get();
                }
                else 
                {
                    $search = $request->input('search.value'); 
        
                    $desiginations = DB::table('desiginations As n')
                   
                             ->orWhere('n.desigination', 'LIKE',"%{$search}%")
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy($order,$dir)
                             ->get();
        
                    $totalFiltered = DB::table('desiginations As n') ->offset($start)
                                  ->limit($limit)
                                   ->orderBy($order,$dir)
                                   ->count();
                }
                $token=csrf_token();
                $data = array();
                if(!empty($desiginations))
                {
                    $i = 0;
                    foreach ($desiginations as $desigination) 
                    {
                      $i = $i+1;
                        
                     $show ="<input type='hidden' class='desigination$desigination->id' value='".$desigination->desigination."'>
                      <a href='' class='btn btn-success btn-rounded mb-4 edit' data-toggle='modal' data-target='#modalLoginForm' style='float: left;' id='".$desigination->id."'>
                      <i class='icon-pencil'></i> Edit</a> ";
        
                         if($desigination->active==1)
                         {
                          $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                         }
                         else
                         {
                          $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                         }
                        
                        $url =  route('activateddesiginationMaster');
                        $nestedData['id'] = $i;
                        $nestedData['name'] =$desigination->desigination;
                       $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                            $show 
                        <form action='{$url}'method='post'>
                        <input type='hidden' name='_token' value='$token'>  
                       <input type='hidden' name='desigination_id' value='$desigination->id'> $active</form></div>";
                        $data[] = $nestedData;
        
                    }
                }
                  
                $json_data = array(
                            "draw"            => intval($request->input('draw')),  
                            "recordsTotal"    => intval($totalData),  
                            "recordsFiltered" => intval($totalFiltered), 
                            "data"            => $data   
                            );
                echo json_encode($json_data); 
              }
              public function adddesiginationMaster(Request $request)
              {
                       $input = $request->all();
                    //    dd($input);
                       Validator::make($request->all(), [
                         'desiginationname' => 'required',
                        
                      ])->validate();
                       if((!isset($input['desiginationid']))||($input['desiginationid']==""))
                       {
                       $checkdesigination=Desigination::where('desigination','=',$input['desiginationname'])->count();
                      
                       if($checkdesigination==0)
                       { 
                           $insertdesigination=new Desigination;
                           $insertdesigination->desigination=$input['desiginationname'];
                           $insertdesigination->active=1;
                           $insertdesigination->save();
                        //    dd($insertvehicle);
                           if($insertdesigination)
                           {
                             return redirect('admin/desigination')->with('success', trans('Desigination  Added successfully'));
                           }
                       } 
                        else
                       {
                          
                           return redirect()->back()->with('error', trans('Desigination already exists'));
                          
                       } 
                     }
                     else
                     {
                       $getdesigination=Desigination::where('id','=',$input['desiginationid'])->get()->first();
                       if(!empty($getdesigination))
                       { 
                           $getdesigination->desigination=$input['desiginationname'];
                           $getdesigination->save();
                           // dd($insertimage);
                           if($getdesigination)
                           {
                             return redirect('admin/desigination')->with('success', trans('Desigination Segment  Updated successfully'));
                           }
                       } 
                        else
                       {
                          
                           return redirect()->back()->with('error', trans('Desigination does not exists'));
                          
                       } 
                     }
               }
        
               public function activateddesiginationMaster(Request $request)
               {
                  
                     
                           $input=$request->all();
                           $vehicle=Desigination::where('id','=',$input['desigination_id'])->get()->first();
                           if($vehicle->active==1)
                         
                           {
                             // dd($image->active);
                               $vehicle->active="0";
                               $msg="Deactivated";
                           } 
                           else
                           {
                               $vehicle->active="1";
                               $msg="Activated";
                           }
                           $vehicle->save();
                           if($vehicle)
                           {
                               return redirect('admin/desigination')->with('success', trans('Desigination '.$msg.' Successfully'));
                           }
                           else
                           {
                               return redirect('admin/desigination')->with('error', trans('Desigination Not '.$msg)); 
                           }
                }

                public function employeemasterPage(Request $request)
                {
                     $id=Auth::id();
                     $user=User::where('id','=',$id)->get()->first();
                     if($user->desigination_id==1)
                     {
                      $branch=Branch::where('id','=',$user->branch_id)->where('active','=',1)->get();
                      $desigination=Desigination::whereIn('id',[2])->where('active','=',1)->get();
                     }
                     else
                     {
                      $branch=Branch::where('active','=',1)->get();
                      $desigination=Desigination::where('active','=',1)->get();
                     }
                     
                    return view('admin.employee',compact('request','branch','desigination'));
                }
                
                public function addemployeeMaster(Request $request)
               {
         
                
                 $input = $request->all();
                //  dd($input);
                 Validator::make($request->all(), [
                  'desigination' => 'required',
                  'name' => 'required',
                  
                 ])->validate();
                 if((!isset($input['employeeid']))||($input['employeeid']==""))
                 {
                   $checkemployee=User::where('mobile','=',$input['mobile'])->orWhere('employcode','=',$input['employcode'])->count();
                  //  dd($checkemployee);
                   if($checkemployee==0)
                   { 
                       $newemployee=new User;
                       $newemployee->desigination_id=$input['desigination'];
                       $newemployee->branch_id=$input['branch'];
                       $newemployee->name=$input['name'];
                       $newemployee->mobile=$input['mobile'];
                       $newemployee->employcode=$input['employcode'];
                       $newemployee->doj=$input['doj'];
                       $newemployee->status=$input['status'];
                       $newemployee->loginname=$input['loginname'];
                       $newemployee->email=isset($input['loginname']) ? $input['loginname'] : '';
                       $newemployee->password=isset($input['password']) ? Hash::make($input['password']) : '';
                       $newemployee->active=1;
                       $newemployee->save();
                       if($newemployee)
                       {
                         return redirect('admin/employee')->with('success', trans('Employee  Added successfully'));
                       }
                   } 
                    else
                   {
                      
                       return redirect()->back()->with('error', trans('Employee already exists'));
                      
                   } 
                }
                else
                {
                  $getemployee=User::where('id','=',$input['employeeid'])->get()->first();
                   if(!empty($getemployee))
                   { 
                       
                    $getemployee->desigination_id=$input['desigination'];
                    $getemployee->branch_id=$input['branch'];
                    $getemployee->name=$input['name'];
                    $getemployee->mobile=$input['mobile'];
                    $getemployee->employcode=$input['employcode'];
                    $getemployee->doj=$input['doj'];
                    $getemployee->status=$input['status'];
                    $getemployee->loginname=$input['loginname'];
                    $getemployee->password=Hash::make($input['password']);
                    $getemployee->save();
                    if($getemployee)
                     {
                         return redirect('admin/employee')->with('success', trans('Employee  updated successfully'));
                    }
                   } 
                    else
                   {
                      
                       return redirect()->back()->with('error', trans('Employee does not exists'));
                      
                   } 
                }
           }
        
        
           public function allemployeeMaster(Request $request)
           {
            
                  $columns = array( 
                                      0 =>'id',     
                                      1=>'desigination_id',
                                      2=>'branch_id',
                                      3=>'employee',
                                      4=>'employcode',
                                      5=>'doj',
                                      6=>'status',
                                      7=>'id',
                                  );
            
                  $totalData = User::count();
                      
                  $totalFiltered = $totalData;
                  $limit = $request->input('length');
                  $start = $request->input('start');
                  $order = $columns[$request->input('order.0.column')];
                  $dir = $request->input('order.0.dir');
                              
                  if(empty($request->input('search.value')))
                  {            
                      $employees = DB::table('users')->leftjoin('desiginations','desiginations.id','=','users.desigination_id')
                                     ->leftjoin('branches','branches.id','=','users.branch_id')
                                    ->select('desiginations.desigination','branches.branch','users.id','users.desigination_id','users.branch_id','users.name','users.employcode','users.doj','users.status','users.status','users.status','users.loginname','users.password','users.active','users.mobile','users.email')    
                                    ->offset($start)
                                    ->limit($limit)
                                     ->orderBy($order,$dir)
                                   ->get();
                  }
                  else 
                  {
                      $search = $request->input('search.value'); 
          
                      $employees = DB::table('users')->leftjoin('desiginations','desiginations.id','=','users.desigination_id')
                      ->leftjoin('branches','branches.id','=','users.branch_id')
                     ->select('desiginations.desigination','branches.branch','users.id','users.desigination_id','users.name','users.employcode','users.doj','users.status','users.loginname','users.password','users.active','users.mobile','users.email','users.branch_id')
                                    ->where('desiginations.desigination', 'LIKE',"%{$search}%")
                                    ->orWhere('users.name', 'LIKE',"%{$search}%")
                                    ->orWhere('users.mobile', 'LIKE',"%{$search}%")
                                    ->orWhere('branches.branch', 'LIKE',"%{$search}%")
                                    ->orWhere('users.employcode', 'LIKE',"%{$search}%")
				    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                   ->get();
          
                      $totalFiltered = DB::table('users')->leftjoin('desiginations','desiginations.id','=','users.desigination_id')
                                       ->leftjoin('branches','branches.id','=','users.branch_id')
                                       ->select('desiginations.desigination','branches.branch','users.id','users.vehicle_id','users.branch','users.location','users.mobile','users.branchnameno','users.active','users.mobile','users.email','users.branch_id')
                                       ->where('desiginations.desigination', 'LIKE',"%{$search}%")
                                    ->orWhere('users.name', 'LIKE',"%{$search}%")
                                    ->orWhere('users.mobile', 'LIKE',"%{$search}%")
                                     ->orWhere('branches.branch', 'LIKE',"%{$search}%")
                                    ->orWhere('users.employcode', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->count();
                  }
                  $token=csrf_token();
                  $data = array();
                  if(!empty($employees))
                  {
                      $i = 0;
                      foreach ($employees as $employee)
                      {
                        $i = $i+1;
                        $branch='';
                        if($employee->branch_id!="")
                        {
                          $branch=$employee->branch_id;
                        } 
                        $show ="<input type='hidden' class='desigination_$employee->id' value='$employee->desigination_id'>
                        <input type='hidden' class='branch_$employee->id' value='$branch'>
                        <input type='hidden' class='desig_$employee->id' value='$employee->desigination_id'>
                        <input type='hidden' class='employee_$employee->id' value='$employee->name'>
                        <input type='hidden' class='employcode_$employee->id' value='$employee->employcode'>
                        <input type='hidden' class='mobile_$employee->id' value='$employee->mobile'>
                        <input type='hidden' class='doj_$employee->id' value='$employee->doj'>
                        <input type='hidden' class='status_$employee->id' value='$employee->status'>
                        <input type='hidden' class='loginname_$employee->id' value='$employee->email'>
                        <input type='hidden' class='doj_$employee->id' value='$employee->doj'>
                       <a href='' class='btn btn-primary btn-rounded mb-4 edit' data-toggle='modal' style='float: left;'' data-target='#modalLoginForm' id='$employee->id'>
                        <i class='icon-pencil'></i> Edit</a>
                       <a href='' class='btn btn-warning btn-rounded mb-4 change' data-toggle='modal' style='float: left;'' data-target='#modalChangeForm' id='$employee->id'>
                        <i class='icon-pencil'></i> Change Password</a> ";
          
                           if($employee->active==1)
                           {
                            $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                           }
                           else
                           {
                            $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                           }
                          
                          $url =  route('activatedemployeeMaster');
                          $nestedData['id'] = $i;
                          $nestedData['desigination'] = $employee->desigination;
                          $nestedData['branch'] = $employee->branch;
                          $nestedData['employee'] = $employee->name;
                          $nestedData['employcode'] =$employee->employcode;
                          $nestedData['mobile'] =$employee->mobile;
                          $nestedData['doj'] = $employee->doj;
                          $nestedData['status'] =$employee->status;
                          $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                              $show 
                          ";
                          $data[] = $nestedData;
          
                      }
                  }
                    
                  $json_data = array(
                              "draw"            => intval($request->input('draw')),  
                              "recordsTotal"    => intval($totalData),  
                              "recordsFiltered" => intval($totalFiltered), 
                              "data"            => $data   
                              );
                  echo json_encode($json_data); 
                }

                public function activatedemployeeMaster(Request $request)
                {
                   
                      
                            $input=$request->all();
                            $vehicle=Employee::where('id','=',$input['employee_id'])->get()->first();
                            if($vehicle->active==1)
                          
                            {
                              // dd($image->active);
                                $vehicle->active="0";
                                $msg="Deactivated";
                            } 
                            else
                            {
                                $vehicle->active="1";
                                $msg="Activated";
                            }
                            $vehicle->save();
                            if($vehicle)
                            {
                                return redirect('admin/employee')->with('success', trans('Employee '.$msg.' Successfully'));
                            }
                            else
                            {
                                return redirect('admin/employee')->with('error', trans('Employee Not '.$msg)); 
                            }
                 }


                 public function modelmasterPage(Request $request)
                 {
                      $vehicles=Vehicle::where('active','=',1)->get();
                     return view('admin.model',compact('request','vehicles'));
                 }
                 public function addmodelMaster(Request $request)
           {
          
                 
                  $input = $request->all();
                //  dd($input);
                  Validator::make($request->all(), [
                   'vehicle' => 'required',
                   'modelname' => 'required',
                   
                  ])->validate();
                  if((!isset($input['modelid']))||($input['modelid']==""))
                  {
                    $checkbranch=ModelName::where('model','=',$input['modelname'])->count();
                    
                    if($checkbranch==0)
                    { 
                        $newbranch=new ModelName;
                        $newbranch->vehicle_id=$input['vehicle'];
                        $newbranch->model=$input['modelname'];
                        $newbranch->active=1;
                        $newbranch->save();
                        if($newbranch)
                        {
                          return redirect('admin/model')->with('success', trans('Model  Added successfully'));
                        }
                    } 
                     else
                    {
                       
                        return redirect()->back()->with('error', trans('Model already exists'));
                       
                    } 
                 }
                 else
                 {
                   $getbranch=ModelName::where('id','=',$input['modelid'])->get()->first();
                    if(!empty($getbranch))
                    { 
                        
                        $getbranch->vehicle_id=$input['vehicle'];
                        $getbranch->model=$input['modelname'];
                        $getbranch->save();
                        if($getbranch)
                        {
                          return redirect('admin/model')->with('success', trans('Model  updated successfully'));
                        }
                    } 
                     else
                    {
                       
                        return redirect()->back()->with('error', trans('Model does not exists'));
                       
                    } 
                 }
            }
         
         
            public function allmodelMaster(Request $request)
            {
             
                   $columns = array( 
                                       0 =>'id',     
                                       1=>'vehicle_id',
                                       2=>'model',
                                       3=>'id',
                                   );
             
                   $totalData = ModelName::count();
                       
                   $totalFiltered = $totalData;
                   $limit = $request->input('length');
                   $start = $request->input('start');
                   $order = $columns[$request->input('order.0.column')];
                   $dir = $request->input('order.0.dir');
                               
                   if(empty($request->input('search.value')))
                   {            
                       $models = DB::table('model_names')->join('vehicles','vehicles.id','=','model_names.vehicle_id')
                                     ->select('vehicles.vehicle','model_names.id','model_names.vehicle_id','model_names.model','model_names.active')    
                                     ->offset($start)
                                     ->limit($limit)
                                      ->orderBy($order,$dir)
                                    ->get();
                   }
                   else 
                   {
                       $search = $request->input('search.value'); 
           
                       $models = DB::table('models')->join('vehicles','vehicles.id','=','model_names.vehicle_id')
                       ->select('vehicles.vehicle','model_names.id','model_names.vehicle_id','model_names.model','model_names.active')
                                     ->where('vehicles.vehicle', 'LIKE',"%{$search}%")
                                     ->orWhere('models.model', 'LIKE',"%{$search}%")
                                     ->offset($start)
                                     ->limit($limit)
                                     ->orderBy($order,$dir)
                                    ->get();
           
                       $totalFiltered = DB::table('model_names')->join('vehicles','vehicles.id','=','model_names.vehicle_id')
                       ->select('vehicles.vehicle','model_names.id','model_names.vehicle_id','model_names.model','model_names.active') 
                                     ->offset($start)
                                     ->limit($limit)
                                     ->orderBy($order,$dir)
                                     ->count();
                   }
                   $token=csrf_token();
                   $data = array();
                   if(!empty($models))
                   {
                       $i = 0;
                       foreach ($models as $model)
                       {
                         $i = $i+1;
                           
                         $show ="<input type='hidden' class='zone_$model->id' value='$model->vehicle_id'>
                         <input type='hidden' class='model_$model->id' value='$model->model'>
                        <a href='' class='btn btn-primary btn-rounded mb-4 edit' data-toggle='modal' style='float: left;'' data-target='#modalLoginForm' id='$model->id'>
                         <i class='icon-pencil'></i> Edit</a> ";
           
                            if($model->active==1)
                            {
                             $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                            }
                            else
                            {
                             $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                            }
                           
                           $url =  route('activatedmodelMaster');
                           $nestedData['id'] = $i;
                           $nestedData['vehicle'] = $model->vehicle;
                           $nestedData['name'] =$model->model;
                            $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                               $show 
                           <form action='{$url}'method='post'>
                           <input type='hidden' name='_token' value='$token'>  
                          <input type='hidden' name='model_id' value='$model->id'> $active</form></div>";
                           $data[] = $nestedData;
           
                       }
                   }
                     
                   $json_data = array(
                               "draw"            => intval($request->input('draw')),  
                               "recordsTotal"    => intval($totalData),  
                               "recordsFiltered" => intval($totalFiltered), 
                               "data"            => $data   
                               );
                   echo json_encode($json_data); 
                 }

                 public function activatedmodelMaster(Request $request)
                 {
                    
                       
                             $input=$request->all();
                             $vehicle=ModelName::where('id','=',$input['model_id'])->get()->first();
                             if($vehicle->active==1)
                           
                             {
                               // dd($image->active);
                                 $vehicle->active="0";
                                 $msg="Deactivated";
                             } 
                             else
                             {
                                 $vehicle->active="1";
                                 $msg="Activated";
                             }
                             $vehicle->save();
                             if($vehicle)
                             {
                                 return redirect('admin/model')->with('success', trans('Model ' .$msg.' Successfully'));
                             }
                             else
                             {
                                 return redirect('admin/model')->with('error', trans('Model Not ' .$msg)); 
                             }
                  }
 
                  public function varientmasterPage(Request $request)
                  {
                       $model=ModelName::where('active','=',1)->get();
                      return view('admin.varient',compact('request','model'));
                  }
                  public function addvarientMaster(Request $request)
            {
           
                  
                   $input = $request->all();
                  // dd($input);
                   Validator::make($request->all(), [
                    'model' => 'required',
                    'varientname' => 'required',
                    
                   ])->validate();
                   if((!isset($input['varientid']))||($input['varientid']==""))
                   {
                     $checkbranch=Varient::where('varient','=',$input['varientname'])->count();
                     
                     if($checkbranch==0)
                     { 
                         $newbranch=new Varient;
                         $newbranch->model_id=$input['model'];
                         $newbranch->varient=$input['varientname'];
                         $newbranch->active=1;
                         $newbranch->save();
                         if($newbranch)
                         {
                           return redirect('admin/varient')->with('success', trans('Varient  Added successfully'));
                         }
                     } 
                      else
                     {
                        
                         return redirect()->back()->with('error', trans('Varient already exists'));
                        
                     } 
                  }
                  else
                  {
                    $getbranch=Varient::where('id','=',$input['varientid'])->get()->first();
                     if(!empty($getbranch))
                     { 
                         
                         $getbranch->model_id=$input['model'];
                         $getbranch->varient=$input['varientname'];
                         $getbranch->save();
                         if($getbranch)
                         {
                           return redirect('admin/varient')->with('success', trans('Varient  updated successfully'));
                         }
                     } 
                      else
                     {
                        
                         return redirect()->back()->with('error', trans('Model does not exists'));
                        
                     } 
                  }
             }
          
          
             public function allvarientMaster(Request $request)
             {
              
                    $columns = array( 
                                        0 =>'id',     
                                        1=>'model_id',
                                        2=>'varient',
                                        3=>'id',
                                    );
              
                    $totalData = Varient::count();
                        
                    $totalFiltered = $totalData;
                    $limit = $request->input('length');
                    $start = $request->input('start');
                    $order = $columns[$request->input('order.0.column')];
                    $dir = $request->input('order.0.dir');
                                
                    if(empty($request->input('search.value')))
                    {            
                        $varients = DB::table('varients')->join('model_names','model_names.id','=','varients.model_id')
                                      ->select('model_names.model','varients.id','varients.model_id','varients.varient','varients.active')    
                                      ->offset($start)
                                      ->limit($limit)
                                       ->orderBy($order,$dir)
                                     ->get();
                    }
                    else 
                    {
                        $search = $request->input('search.value'); 
            
                        $varients = DB::table('varients')->join('model_names','model_names.id','=','varients.model_id')
                        ->select('model_names.model','varients.id','varients.model_id','varients.varient','varients.active')  
                                      ->where('model_names.model', 'LIKE',"%{$search}%")
                                      ->orWhere('varients.varient', 'LIKE',"%{$search}%")
                                      ->offset($start)
                                      ->limit($limit)
                                      ->orderBy($order,$dir)
                                     ->get();
            
                        $totalFiltered = DB::table('varients')->join('model_names','model_names.id','=','varients.model_id')
                        ->select('vmodel_names.model','varients.id','varients.model_id','varients.varient','varients.active') 
                                      ->offset($start)
                                      ->limit($limit)
                                      ->orderBy($order,$dir)
                                      ->count();
                    }
                    $token=csrf_token();
                    $data = array();
                    if(!empty($varients))
                    {
                        $i = 0;
                        foreach ($varients as $varient)
                        {
                          $i = $i+1;
                            
                          $show ="<input type='hidden' class='zone_$varient->id' value='$varient->model_id'>
                          <input type='hidden' class='model_$varient->id' value='$varient->varient'>
                         <a href='' class='btn btn-primary btn-rounded mb-4 edit' data-toggle='modal' style='float: left;'' data-target='#modalLoginForm' id='$varient->id'>
                          <i class='icon-pencil'></i> Edit</a> ";
            
                             if($varient->active==1)
                             {
                              $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                             }
                             else
                             {
                              $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                             }
                            
                            $url =  route('activatedvarientMaster');
                            $nestedData['id'] = $i;
                            $nestedData['model'] = $varient->model;
                            $nestedData['name'] =$varient->varient;
                             $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                                $show 
                            <form action='{$url}'method='post'>
                            <input type='hidden' name='_token' value='$token'>  
                           <input type='hidden' name='varient_id' value='$varient->id'> $active</form></div>";
                            $data[] = $nestedData;
            
                        }
                    }
                      
                    $json_data = array(
                                "draw"            => intval($request->input('draw')),  
                                "recordsTotal"    => intval($totalData),  
                                "recordsFiltered" => intval($totalFiltered), 
                                "data"            => $data   
                                );
                    echo json_encode($json_data); 
                  }

                  public function activatedvarientMaster(Request $request)
                  {
                     
                        
                              $input=$request->all();
                              $vehicle=Varient::where('id','=',$input['varient_id'])->get()->first();
                              if($vehicle->active==1)
                            
                              {
                                // dd($image->active);
                                  $vehicle->active="0";
                                  $msg="Deactivated";
                              } 
                              else
                              {
                                  $vehicle->active="1";
                                  $msg="Activated";
                              }
                              $vehicle->save();
                              if($vehicle)
                              {
                                  return redirect('admin/varient')->with('success', trans('Varient'.$msg.' Successfully'));
                              }
                              else
                              {
                                  return redirect('admin/varient')->with('error', trans('Varient Not '.$msg)); 
                              }
                   }


     public function placemasterPage(Request $request)
     {
            return view('admin.place',compact('request'));
     }

     public function allplaceMaster(Request $request)
     {
      
            $columns = array( 
                                0 =>'id',     
                                1=>'city',
                                2=>'id',
                            );
      
            $totalData = City::count();
                
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
                        
            if(empty($request->input('search.value')))
            {            
                $citys = DB::table('cities')
                              ->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get();
            }
            else 
            {
                $search = $request->input('search.value'); 
    
                $citys = DB::table('cities As n')
               
                         ->orWhere('n.city', 'LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
    
                $totalFiltered = DB::table('cities As n') ->offset($start)
                              ->limit($limit)
                               ->orderBy($order,$dir)
                               ->count();
            }
            $token=csrf_token();
            $data = array();
            if(!empty($citys))
            {
                $i = 0;
                foreach ($citys as $city) 
                {
                  $i = $i+1;
                    
                 $show ="<input type='hidden' class='city$city->id' value='".$city->city."'>
                  <a href='' class='btn btn-success btn-rounded mb-4 edit' data-toggle='modal' data-target='#modalLoginForm' style='float: left;' id='".$city->id."'>
                  <i class='icon-pencil'></i> Edit</a> ";
    
                     if($city->active==1)
                     {
                      $active="<button type='button' data-toggle='modal' data-target='#confirmActive' data-title='Deactivate Permanently' data-message='Are you sure deactivate this?' class='btn btn-danger'><i class='icon-pencil' aria-hidden='true'></i>Deactive</button>";
                     }
                     else
                     {
                      $active="<button type='submit' class='btn btn-warning'><i class='icon-ok' aria-hidden='true'></i>Active</button>";
                     }
                    
                    $url =  route('activatedplaceMaster');
                    $nestedData['id'] = $i;
                    $nestedData['name'] =$city->city;
                   $nestedData['actions'] = " <div class='row' style='margin-left: -0.0715rem;'>          
                        $show 
                    <form action='{$url}'method='post'>
                    <input type='hidden' name='_token' value='$token'>  
                   <input type='hidden' name='city_id' value='$city->id'> $active</form></div>";
                    $data[] = $nestedData;
    
                }
            }
              
            $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );
            echo json_encode($json_data); 
    }
    public function addplaceMaster(Request $request)
    {
             $input = $request->all();
            //  dd($input);
             Validator::make($request->all(), [
               'cityname' => 'required',
              
            ])->validate();
             if((!isset($input['cityid']))||($input['cityid']==""))
             {
             $checkdesigination=City::where('city','=',$input['cityname'])->count();
            
             if($checkdesigination==0)
             { 
                 $insertdesigination=new City;
                 $insertdesigination->city=$input['cityname'];
                 $insertdesigination->active=1;
                 $insertdesigination->save();
              //    dd($insertvehicle);
                 if($insertdesigination)
                 {
                   return redirect('admin/place')->with('success', trans('City  Added successfully'));
                 }
             } 
              else
             {
                
                 return redirect()->back()->with('error', trans('City already exists'));
                
             } 
           }
           else
           {
             $getdesigination=City::where('id','=',$input['cityid'])->get()->first();
             if(!empty($getdesigination))
             { 
                 $getdesigination->city=$input['cityname'];
                 $getdesigination->save();
                 if($getdesigination)
                 {
                   return redirect('admin/place')->with('success', trans('City   Updated successfully'));
                 }
             } 
              else
             {
                
                 return redirect()->back()->with('error', trans('City does not exists'));
                
             } 
           }
     }
                  
     public function activatedplaceMaster(Request $request)
     {
        
           
         $input=$request->all();
         $vehicle=City::where('id','=',$input['city_id'])->get()->first();
         if($vehicle->active==1)
       
         {
           // dd($image->active);
             $vehicle->active="0";
             $msg="Deactivated";
         } 
         else
         {
             $vehicle->active="1";
             $msg="Activated";
         }
         $vehicle->save();
         if($vehicle)
         {
             return redirect('admin/place')->with('success', trans('Place '.$msg.' Successfully'));
         }
         else
         {
             return redirect('admin/place')->with('error', trans('Place Not '.$msg)); 
         }
     }
     public function welcomePage(Request $request)
     {
        $places=City::where('active','=',1)->get();
        return view('admin.welcome',compact('request','places'));
     }
      public function addcustomer(Request $request)
    {
         $input = $request->all();
         Validator::make($request->all(), [
           'customer_name' => 'required',
           'mobile_no' => 'required',
           'place' => 'required',
         ])->validate();
         $date=date('Y-m-d');
         $checkentry=Customer::where('customer_name','=',$input['customer_name'])->where('mobile_no','=',$input['mobile_no'])->where('walkin_date','=',$date)->count();
        
         if($checkentry==0)
         { 
             $id=Auth::id();
             $user=User::where('id','=',$id)->get()->first();
             $newcustomer=new Customer;
             $newcustomer->branches_id=$user->branch_id;
             $newcustomer->walkin_date=$date;
             $newcustomer->cities_id=$input['place'];
             $newcustomer->customer_name=$input['customer_name'];
             $newcustomer->mobile_no=$input['mobile_no'];
             $newcustomer->welcome_sms='Sent';
             $newcustomer->thankyou_sms='Pending';
             $newcustomer->welcome_at=date('Y-m-d H:i:s');
             $newcustomer->save();
             if($newcustomer)
             {
               $branch=Branch::where('id','=',$user->branch_id)->get()->first();
               $segment=Vehicle::where('id','=',$branch->vehicle_id)->get()->first();
               $name=$input['customer_name'];
               $mobile=$input['mobile_no'];
               $user="caiindustries"; //your username
$password="Cai66733"; //your password
$message = "Dear Customer, Welcome to CAI Mahindra ".$branch->branch." ".$segment->vehicle." vehicle showroom. Pls. contact: ".$branch->landlineno.".Visit at https://bit.ly/3ij6yZv -Team CAI Mahindra"; //enter Your Message
$senderid="CAIIND"; //Your senderid
$messagetype="N"; //Type Of Your Message
$DReports="Y"; //Delivery Reports
$url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
$message = urlencode($message);
$ch = curl_init();
if (!$ch){die("Couldn't initialize a cURL handle");}
$ret = curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt ($ch, CURLOPT_POSTFIELDS,
"User=$user&passwd=$password&mobilenumber=$mobile&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
$curlresponse = curl_exec($ch); 
            //   file_get_contents("https://control.msg91.com/api/sendhttp.php?authkey=312141ArDI3CajVy5e1582a8P1&mobiles=$mobile&message=Dear $name,%0AWelcome to our showroom%0A%0AThank you&sender=AKRPUB&DLT_TE_ID=1207161527095122421&dev_mode=1");
               return redirect('admin/welcome')->with('success', trans('Customer Entry Added successfully'));
             }
         } 
          else
         {
            
             return redirect()->back()->with('error', trans('Customer already exists'));
            
         } 
          
     }
     public function thankyouPage(Request $request)
     {
        $id=Auth::id();
        $user=User::where('id','=',$id)->get()->first();
        if(($user->desigination_id=="1")||($user->desigination_id=="2"))
        {
        $customers=Customer::where('branches_id','=',$user->branch_id)->where('thankyou_sms','=','Pending')->get();
        }
        else
        {
        $customers=Customer::where('thankyou_sms','=','Pending')->get();
        }
        return view('admin.thankyou',compact('request','customers'));
     }
     public function allthankyou(Request $request)
     {
      
            $columns = array( 
                                0 =>'id',     
                                1=>'walkin_date',
                                2=>'customer_name',
                                3=>'mobile_no',
                                4=>'cities_id',
                                5=>'id',
                            );
           $id=Auth::id();
           $user=User::where('id','=',$id)->get()->first();
           if(($user->desigination_id=="1")||($user->desigination_id=="2"))
           {
            $totalData = Customer::where('branches_id','=',$user->branch_id)->where('thankyou_sms','=','Pending')->count();
           }
           else
           {
           $totalData = Customer::where('thankyou_sms','=','Pending')->count();
            }

            
                
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
                        
            if(empty($request->input('search.value')))
            {   
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                 {
         
                $customers = DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
			      ->where('customers.branches_id','=',$user->branch_id)
                              ->where('customers.thankyou_sms','=','Pending')
                              ->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city'));
                 }
                 else
                 {
                 $customers = DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
			      ->where('customers.thankyou_sms','=','Pending')
                              ->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city'));

                 }
            }
            else 
            {
                $search = $request->input('search.value'); 
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                 {

                $customers = DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                         ->where('customers.branches_id','=',$user->branch_id)
                         ->where('customers.thankyou_sms','=','Pending')
                         ->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city'));
    
                $totalFiltered = DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                         ->where('customers.branches_id','=',$user->branch_id)
                         ->where('customers.thankyou_sms','=','Pending')
                         ->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
                 }
                 else
                 {
                 $customers = DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                         ->where('customers.thankyou_sms','=','Pending')
                         ->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city'));
    
                $totalFiltered = DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                         ->where('customers.thankyou_sms','=','Pending')
                         ->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();

                 }
            }
            $token=csrf_token();
            $data = array();
            if(!empty($customers))
            {
                $i = 0;
                foreach ($customers as $customer) 
                {
                   $i = $i+1;
                   $url =  url('admin/sendthankyou/'.$customer->id);  
                   $show ="<a href='".$url."' class='btn btn-success btn-rounded mb-4'>Send</a> ";
    
                    $nestedData['id'] = $i;
                    $nestedData['walkin'] = date('d-m-Y',strtotime($customer->walkin_date));
                    $nestedData['name'] = $customer->customer_name;
                    $nestedData['mobile'] =$customer->mobile_no;
                    $nestedData['place'] =$customer->city;
                    $nestedData['actions'] = $show;
                    $data[] = $nestedData;
    
                }
            }
              
            $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );
            echo json_encode($json_data); 
    }
    public function sendthankyou(Request $request,$id)
     {
        $customer=Customer::where('id','=',$id)->get()->first();
        $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
        if(!empty($branch))
        {
         $models=ModelName::where('vehicle_id','=',$branch->vehicle_id)->where('active','=',1)->get();
        }
        else
        {
	 $models=ModelName::where('active','=',1)->get();
        }
        $varients=Varient::where('active','=',1)->get();
        $userid=Auth::id();
        
        $userdata=User::where('id','=',$userid)->get()->first();
        if($userdata->branch_id!='')
        {
        $users=User::where('branch_id','=',$userdata->branch_id)->whereNotIn('desigination_id',[1,2])->where('status','=','Active')->get();
        }
        else
        {
	$users=User::where('status','=','Active')->get();
        
        }

        $segments=Vehicle::where('active','=',1)->get();
        return view('admin.sendthankyou',compact('request','customer','models','varients','branch','segments','users'));
     }
     public function updatecustomer(Request $request)
    {
         $input = $request->all();
         Validator::make($request->all(), [
           'customer_id' => 'required',
           'vehicle_segment' => 'required',
           'varient' => 'required',
           'model'=>'required',
           'customer_type' => 'required',
           'customer_category' => 'required',
           'sale_status' => 'required',
           'followup' => 'required',
           'ssc_name' => 'required',
         ])->validate();
         $date=date('Y-m-d');
         $getcustomer=Customer::where('id','=',$input['customer_id'])->get()->first();
        
         if(!empty($getcustomer))
         { 
             $id=Auth::id();
             $getcustomer->email=$input['customer_email'];
             $getcustomer->vehicles_id=$input['vehicle_segment'];
             $getcustomer->model_names_id=$input['model'];
             $getcustomer->varients_id=$input['varient'];
             $getcustomer->customer_type=$input['customer_type'];
             $getcustomer->customer_category=$input['customer_category'];
             $getcustomer->sale_status=$input['sale_status'];
             $getcustomer->followup_date=date('Y-m-d',strtotime($input['followup']));
             $getcustomer->employees_id=$input['ssc_name'];
             $getcustomer->remarks=$input['remarks'];
             $getcustomer->thankyou_sms='Sent';
             $getcustomer->thankyou_at=date('Y-m-d H:i:s');
             $getcustomer->save();
             if($getcustomer)
             {
               $branch=Branch::where('id','=',$getcustomer->branches_id)->get()->first();
               $segment=Vehicle::where('id','=',$branch->vehicle_id)->get()->first();
               $emp=User::where('id','=',$input['ssc_name'])->get()->first();
               $name=$input['customer_name'];
               $mobile=$input['mobile_no'];
                  $user="caiindustries"; //your username
$password="Cai66733"; //your password
if($branch->branch=="Coimbatore")
               {
                 $link='Please review us:https://bit.ly/cai-coimbatore';
               }
               else if($branch->branch=="Erode")
               {
		$link='Please review us:https://bit.ly/cai-coimbatore';
               }
               else if($branch->branch=="Ooty")
               {
		$link='Please review us:https://bit.ly/cai-coimbatore';
               }
               else
               {
                $link='';
               }

$message = "Dear Customer, Thanks for visiting CAI Mahindra ".$branch->branch." ".$segment->vehicle." vehicle showroom. For further assistance pls. contact: ".$emp->mobile." -Team CAI Mahindra. ".$link; //enter Your Message
//$message = "Dear Customer, Thanks for visiting CAI Mahindra ".$branch->branch." ".$segment->vehicle." vehicle showroom. For further assistance pls. contact: ".$emp->mobile." -Team CAI Mahindra"; //enter Your Message
$senderid="CAIIND"; //Your senderid
$messagetype="N"; //Type Of Your Message
$DReports="Y"; //Delivery Reports
$url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
$message = urlencode($message);
$ch = curl_init();
if (!$ch){die("Couldn't initialize a cURL handle");}
$ret = curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt ($ch, CURLOPT_POSTFIELDS,
"User=$user&passwd=$password&mobilenumber=$mobile&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
$curlresponse = curl_exec($ch);
             //  file_get_contents("https://control.msg91.com/api/sendhttp.php?authkey=312141ArDI3CajVy5e1582a8P1&mobiles=$mobile&message=Dear $name,%0AThank you visiting to our showroom%0A%0AThank you&sender=AKRPUB&DLT_TE_ID=1207161527095122421&dev_mode=1");
               return redirect('admin/thankyou')->with('success', trans('Customer Entry Updated successfully'));
             }
         } 
          else
         {
            
             return redirect()->back()->with('error', trans('Customer already exists'));
            
         } 
          
     }
     public function WelcomeReport(Request $request)
     {
        $fromdate=Session('from');
        $todate=Session('to');
        $branch=Session('branch');
        if(($fromdate!="")&&($todate!=""))
        {
          $from=$fromdate;
          $to=$todate;
        }
        else
        {
          $from='2021-09-01';
          $to=date('Y-m-d');
        }
        $id=Auth::id();
        $user=User::where('id','=',$id)->get()->first();
        if(($user->desigination_id=="1")||($user->desigination_id=="2"))
        {
          $branches=Branch::where('id','=',$user->branch_id)->where('active','=',1)->get();
        }
        else
        {
          $branches=Branch::where('active','=',1)->get();
        }
        return view('admin.welcome-report',compact('request','branches','branch','from','to'));
     }
     public function allwelcomesent(Request $request)
     {
      
            $columns = array( 
                                0 =>'id',     
                                1=>'walkin_date',
                                2=>'branches_id',
                                3=>'customer_name',
                                4=>'mobile_no',
                                5=>'cities_id',
                                
                            );
      
            
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $from_date=$request->input('from_date');
            $to_date=$request->input('to_date');
            $branch=$request->input('branch');     
            
             $id=Auth::id();
            $user=User::where('id','=',$id)->get()->first();
            if(($user->desigination_id=="1")||($user->desigination_id=="2"))
            {
		$totalData = Customer::where('branches_id','=',$user->branch_id)->whereBetween('walkin_date',[$from_date,$to_date])->count();
            }
            else
            {
                $totalData = Customer::whereBetween('walkin_date',[$from_date,$to_date])->count();
            }
            $totalFiltered = $totalData;       
            if(empty($request->input('search.value')))
            {   
                $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date]);
                if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                } 
                else
                {
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }
                }      
                $customers = $query->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id'));
                 $query1=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date]);
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                } 
                else
                {
                 $query1=$query1->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                }
                }      
           
                $totalData = $query1->count();
                
                $totalFiltered = $totalData; 
            }
            else 
            {
                $search = $request->input('search.value'); 
                $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date]);
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                } 
                else
                {
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }
                }      
     
                $customers = $query->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id'));
                $query1=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date]);
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                } 
                else
                {
                 $query1=$query1->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                }
                }      
                $totalFiltered =$query1->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
            }
            $token=csrf_token();
            $data = array();
            if(!empty($customers))
            {
                $i = 0;
                foreach ($customers as $customer) 
                {
                  $bname="";
                  $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
                  if($branch!="")
                  {
                   $bname=$branch->branch;
                  }
                   $i = $i+1;
                   $url =  url('admin/sendthankyou/'.$customer->id);  
                   $show ="<a href='".$url."' class='btn btn-success btn-rounded mb-4'>Send</a> ";
    
                    $nestedData['id'] = $i;
                    $nestedData['walkin'] = date('d-m-Y',strtotime($customer->walkin_date));
                    $nestedData['branch'] = $bname;
                    $nestedData['name'] = $customer->customer_name;
                    $nestedData['mobile'] =$customer->mobile_no;
                    $nestedData['place'] =$customer->city;
                    $data[] = $nestedData;
    
                }
            }
              
            $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );
            echo json_encode($json_data); 
    }
    public function searchwelcome(Request $request)
    {
      $input=$request->all();
      $input1 = $request->input('search');
      if (isset($input1))
      {
       $request->session()->put('from',$input['from_date']);
        $request->session()->put('to',$input['to_date']);
        if((isset($input['branch']))&&($input['branch']!=""))
        {
          $request->session()->put('branch',$input['branch']);
        }
        else
        {
           $request->session()->put('branch','');
        }
        
        return redirect()->back();
      }
      else
      {
        $page=$input['page'];
        $from_date=$input['from_date'];
        $to_date=$input['to_date'];
        $branch=$input['branch'];
        $id=Auth::id();
        $user=User::where('id','=',$id)->get()->first();

        if($page=="welcome")
        {
          $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date]);
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {

                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }   
                else
		{
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                 {
                  $query=$query->where('branches_id','=',$branch);
                 }
                }      
          $customers = $query->orderBy('id','desc')
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id','customers.welcome_at'));
          $output="";
            $output .= "SNO" . "\t" ."Walkin Date" . "\t" ."Branch" . "\t" ."Customer Name". "\t" ."Mobile No". "\t" ."Place". "\t" ."Welcome At";
           $output .="\n"; 
          
           $i=0;

          foreach($customers as $customer)
          {
            $i++;
            $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
            $branchname="";
            if(!empty($branch))
            {
              $branchname=$branch->branch;
            }
            $output .='"'.$i.'"'. "\t";
            $output .='"'.date('d-m-Y',strtotime($customer->walkin_date)).'"'. "\t";
            $output .='"'.$branchname.'"'. "\t";
            $output .='"'.$customer->customer_name.'"'. "\t";
            $output .='"'.$customer->mobile_no.'"'. "\t";
            $output .='"'.$customer->city.'"'. "\t";
            $output .='"'.date('d-m-Y H:i:s',strtotime($customer->welcome_at)).'"'. "\t";
            
            $output .="\n";
      
          }
          $filename = "WelcomeSMSReport.xls";
          header('Content-type: application/xls');
          header('Content-Disposition: attachment; filename='.$filename);
          header("Pragma: no-cache");  
          header("Expires: 0");  
          echo $output;
          echo exit();
        }
        else if($page=="pending")
        {
          $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending');
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {

                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }   
                else
		{
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                 {
                  $query=$query->where('branches_id','=',$branch);
                 }
                }      
     
          $customers = $query->orderBy('id','desc')
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id','customers.welcome_at'));
          $output="";
            $output .= "SNO" . "\t" ."Walkin Date" . "\t" ."Branch" . "\t" ."Customer Name". "\t" ."Mobile No". "\t" ."Place". "\t" ."Welcome At";
           $output .="\n"; 
          
           $i=0;

          foreach($customers as $customer)
          {
            $i++;
            

            $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
            $branchname="";
            if(!empty($branch))
            {
              $branchname=$branch->branch;
            }
            $output .='"'.$i.'"'. "\t";
            $output .='"'.date('d-m-Y',strtotime($customer->walkin_date)).'"'. "\t";
            $output .='"'.$branchname.'"'. "\t";
            $output .='"'.$customer->customer_name.'"'. "\t";
            $output .='"'.$customer->mobile_no.'"'. "\t";
            $output .='"'.$customer->city.'"'. "\t";
            $output .='"'.date('d-m-Y H:i:s',strtotime($customer->welcome_at)).'"'. "\t";
            
            $output .="\n";
      
          }
          $filename = "WelcomeSMSReport.xls";
          header('Content-type: application/xls');
          header('Content-Disposition: attachment; filename='.$filename);
          header("Pragma: no-cache");  
          header("Expires: 0");  
          echo $output;
          echo exit();
        }
        else
        {
           $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')->join('vehicles','customers.vehicles_id','=','vehicles.id')->join('model_names','customers.model_names_id','=','model_names.id')->join('varients','customers.varients_id','=','varients.id')->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('customers.thankyou_sms','=','Sent');
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {

                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }   
                else
		{
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                 {
                  $query=$query->where('branches_id','=',$branch);
                 }
                }      
      
                $customers = $query->orderBy('id','desc')
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id','customers.vehicles_id',
                                'customers.model_names_id',
                                'customers.varients_id',
                                'customers.customer_type',
                                'customers.customer_category',
                                'customers.sale_status','vehicles.vehicle','model_names.model','varients.varient','customers.employees_id','customers.followup_date','customers.welcome_at','customers.thankyou_at','customers.remarks','customers.email'));


           $output="";
           $output .= "SNO" . "\t" ."Walkin Date" . "\t" ."Branch" . "\t" ."Customer Name". "\t" ."Mobile No". "\t" ."Email ID". "\t" ."Place". "\t" ."Vehicle Segment". "\t" ."Model Interested". "\t" ."Varient Interested". "\t" ."Customer Type". "\t" ."Customer Category". "\t" ."Sale Status". "\t" ."Follow Up". "\t" ."SSC/FFC Name". "\t" ."Remarks". "\t" ."Welcome At". "\t" ."Thankyou At";
           $output .="\n"; 
          
           $i=0;

          foreach($customers as $customer)
          {
            $i++;
            $user=User::where('id','=',$customer->employees_id)->get()->first();
            $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
             $branchname="";
            if(!empty($branch))
            {
              $branchname=$branch->branch;
            }

            $output .='"'.$i.'"'. "\t";
            $output .='"'.date('d-m-Y',strtotime($customer->walkin_date)).'"'. "\t";
            $output .='"'.$branchname.'"'. "\t";
            $output .='"'.$customer->customer_name.'"'. "\t";
            $output .='"'.$customer->mobile_no.'"'. "\t";
            $output .='"'.$customer->email.'"'. "\t";
            $output .='"'.$customer->city.'"'. "\t";
            $output .='"'.$customer->vehicle.'"'. "\t";
            $output .='"'.$customer->model.'"'. "\t";
            $output .='"'.$customer->varient.'"'. "\t";
            $output .='"'.$customer->customer_type.'"'. "\t";
            $output .='"'.$customer->customer_category.'"'. "\t";
            $output .='"'.$customer->sale_status.'"'. "\t";
            $output .='"'.date('d-m-Y',strtotime($customer->followup_date)).'"'. "\t";
            $output .='"'.$user->name.'"'. "\t";
            $output .='"'.$customer->remarks.'"'. "\t";
            $output .='"'.date('d-m-Y H:i:s',strtotime($customer->welcome_at)).'"'. "\t";
            $output .='"'.date('d-m-Y H:i:s',strtotime($customer->thankyou_at)).'"'. "\t";
            $output .="\n";
      
          }
          $filename = "WelcomeSMSReport.xls";
          header('Content-type: application/xls');
          header('Content-Disposition: attachment; filename='.$filename);
          header("Pragma: no-cache");  
          header("Expires: 0");  
          echo $output;
          echo exit();

        }
      }
    }
    public function ThankyouReport(Request $request)
     {
        $fromdate=Session('from');
        $todate=Session('to');
        $branch=Session('branch');
        if(($fromdate!="")&&($todate!=""))
        {
          $from=$fromdate;
          $to=$todate;
        }
        else
        {
          $from='2021-09-01';
          $to=date('Y-m-d');
        }
        $id=Auth::id();
        $user=User::where('id','=',$id)->get()->first();
        if(($user->desigination_id=="1")||($user->desigination_id=="2"))
        {
          $branches=Branch::where('id','=',$user->branch_id)->where('active','=',1)->get();
        }
        else
        {
          $branches=Branch::where('active','=',1)->get();
        }
        return view('admin.thankyou-report',compact('request','branches','branch','from','to'));
     }
     public function allthankyousent(Request $request)
     {
      
            $columns = array( 
                                0 =>'id',     
                                1=>'walkin_date',
                                2=>'branches_id',
                                3=>'customer_name',
                                4=>'mobile_no',
                                5=>'cities_id',
                                6=>'vehicles_id',
                                7=>'model_names_id',
                                8=>'varients_id',
                                9=>'customer_type',
                                10=>'customer_category',
                                11=>'sale_status',
                                
                            );
      
            
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $from_date=$request->input('from_date');
            $to_date=$request->input('to_date');
            $branch=$request->input('branch');  
             $id=Auth::id();
             $user=User::where('id','=',$id)->get()->first();  
            if(($user->desigination_id=="1")||($user->desigination_id=="2"))
            {
            $totalData = Customer::where('branches_id','=',$user->branch_id)->whereBetween('walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Sent')->count();
            }
            else
            {
	    $totalData = Customer::whereBetween('walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Sent')->count();
            }   
            $totalFiltered = $totalData;       
            if(empty($request->input('search.value')))
            {   
                $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')->join('vehicles','customers.vehicles_id','=','vehicles.id')->join('model_names','customers.model_names_id','=','model_names.id')->join('varients','customers.varients_id','=','varients.id')->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('customers.thankyou_sms','=','Sent');
                 if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                } 
                else
                {
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }
                }      
     
                $customers = $query->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id','customers.vehicles_id',
                                'customers.model_names_id',
                                'customers.varients_id',
                                'customers.customer_type',
                                'customers.customer_category',
                                'customers.sale_status','vehicles.vehicle','model_names.model','varients.varient'));
                 $query1=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')->join('vehicles','customers.vehicles_id','=','vehicles.id')->join('model_names','customers.model_names_id','=','model_names.id')->join('varients','customers.varients_id','=','varients.id')->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('customers.thankyou_sms','=','Sent');
               if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                } 
                else
                {
                 $query1=$query1->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                }
                }      
            
                $totalData = $query1->count();
                
                $totalFiltered = $totalData; 
            }
            else 
            {
                $search = $request->input('search.value'); 
                $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')->join('vehicles','customers.vehicles_id','=','vehicles.id')->join('model_names','customers.model_names_id','=','model_names.id')->join('varients','customers.varients_id','=','varients.id')->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('customers.thankyou_sms','=','Sent');
               if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                } 
                else
                {
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }
                }      
     
                $customers = $query->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id','customers.vehicles_id',
                                'customers.model_names_id',
                                'customers.varients_id',
                                'customers.customer_type',
                                'customers.customer_category',
                                'customers.sale_status','vehicles.vehicle','model_names.model','varients.varient'));
                $query1=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')->join('vehicles','customers.vehicles_id','=','vehicles.id')->join('model_names','customers.model_names_id','=','model_names.id')->join('varients','customers.varients_id','=','varients.id')->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('customers.thankyou_sms','=','Sent');
                if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                } 
                else
                {
                 $query1=$query1->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                }
                }      
                $totalFiltered =$query1->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
            }
            $token=csrf_token();
            $data = array();
            if(!empty($customers))
            {
                $i = 0;
                foreach ($customers as $customer) 
                {
                  $bname="";
                  $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
                  if($branch!="")
                  {
                   $bname=$branch->branch;
                  }
                   $i = $i+1;
                   $url =  url('admin/sendthankyou/'.$customer->id);  
                   $show ="<a href='".$url."' class='btn btn-success btn-rounded mb-4'>Send</a> ";
    
                    $nestedData['id'] = $i;
                    $nestedData['walkin'] = date('d-m-Y',strtotime($customer->walkin_date));
                    $nestedData['branch'] = $bname;
                    $nestedData['name'] = $customer->customer_name;
                    $nestedData['mobile'] =$customer->mobile_no;
                    $nestedData['place'] =$customer->city;
                    $nestedData['segment'] =$customer->vehicle;
                    $nestedData['model'] =$customer->model;
                    $nestedData['varient'] =$customer->varient;
                    $nestedData['type'] =$customer->customer_type;
                    $nestedData['category'] =$customer->customer_category;
                    $nestedData['status'] =$customer->sale_status;
                   
                    $data[] = $nestedData;
    
                }
            }
              
            $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );
            echo json_encode($json_data); 
    }
    public function ThankyouPendingReport(Request $request)
     {
        $fromdate=Session('from');
        $todate=Session('to');
        $branch=Session('branch');
        if(($fromdate!="")&&($todate!=""))
        {
          $from=$fromdate;
          $to=$todate;
        }
        else
        {
          $from='2021-09-01';
          $to=date('Y-m-d');
        }
        $id=Auth::id();
        $user=User::where('id','=',$id)->get()->first();
        if(($user->desigination_id=="1")||($user->desigination_id=="2"))
        {
          $branches=Branch::where('id','=',$user->branch_id)->where('active','=',1)->get();
        }
        else
        {
          $branches=Branch::where('active','=',1)->get();
        }
        return view('admin.thankyou-pending-report',compact('request','branches','branch','from','to'));
     }
     public function allthankyoupending(Request $request)
     {
      
            $columns = array( 
                                0 =>'id',     
                                1=>'walkin_date',
                                2=>'branches_id',
                                3=>'customer_name',
                                4=>'mobile_no',
                                5=>'cities_id',
                                
                            );
      
            
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $from_date=$request->input('from_date');
            $to_date=$request->input('to_date');
            $branch=$request->input('branch');  
            $id=Auth::id();
            $user=User::where('id','=',$id)->get()->first();
           if(($user->desigination_id=="1")||($user->desigination_id=="2"))
           {
   
            $totalData = Customer::where('branches_id','=',$user->branch_id)->whereBetween('walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending')->count();
            }
            else
            {
            $totalData = Customer::whereBetween('walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending')->count();

            }    
            $totalFiltered = $totalData;       
            if(empty($request->input('search.value')))
            {   
                $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending');
                if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                } 
                else
                {
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }
                }      
    
                $customers = $query->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id'));
                 $query1=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending');
                if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                } 
                else
                {
                 $query1=$query1->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                }
                }      
             
                $totalData = $query1->count();
                
                $totalFiltered = $totalData; 
            }
            else 
            {
                $search = $request->input('search.value'); 
                $query=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending');
                if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                } 
                else
                {
                 $query=$query->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query=$query->where('branches_id','=',$branch);
                }
                }      
     
                $customers = $query->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get(array('customers.id','customers.customer_name','customers.walkin_date','customers.mobile_no','customers.cities_id','cities.city','customers.branches_id'));
                $query1=DB::table('customers')->join('cities','customers.cities_id','=','cities.id')
                              ->whereBetween('customers.walkin_date',[$from_date,$to_date])->where('thankyou_sms','=','Pending');
                if(($user->desigination_id=="1")||($user->desigination_id=="2"))
                {
                if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                } 
                else
                {
                 $query1=$query1->where('branches_id','=',$user->branch_id);

                }
                }
                else
                {
                 if($branch!="All")
                {
                  $query1=$query1->where('branches_id','=',$branch);
                }
                }      
                $totalFiltered =$query1->where('customers.customer_name', 'LIKE',"%{$search}%")
                         ->orWhere('customers.mobile_no', 'LIKE',"%{$search}%")
                         ->orWhere('cities.city', 'LIKE',"%{$search}%")
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->count();
            }
            $token=csrf_token();
            $data = array();
            if(!empty($customers))
            {
                $i = 0;
                foreach ($customers as $customer) 
                {
                  $bname="";
                  $branch=Branch::where('id','=',$customer->branches_id)->get()->first();
                  if($branch!="")
                  {
                   $bname=$branch->branch;
                  }

                   $i = $i+1;
                  
                    $nestedData['id'] = $i;
                    $nestedData['walkin'] = date('d-m-Y',strtotime($customer->walkin_date));
                    $nestedData['branch'] = $bname;
                    $nestedData['name'] = $customer->customer_name;
                    $nestedData['mobile'] =$customer->mobile_no;
                    $nestedData['place'] =$customer->city;
                    $data[] = $nestedData;
    
                }
            }
              
            $json_data = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );
            echo json_encode($json_data); 
    }
    public function getvarient(Request $request)
    {
      $input=$request->all();
      $varients=Varient::where('model_id','=',$input['id'])->where('active','=',1)->get();
      $html="";
      $html.='<option value="">Varient</option>';
      foreach($varients as $varient)
      {
        $html.='<option value="'.$varient->id.'">'.$varient->varient.'</option>';
      }
      $data=array();
      $data['html']=$html;
      echo json_encode($data);
      echo exit();
    }
    public function ResetpasswordPage(Request $request)
    {
       return view('admin.reset',compact('request'));
    }
    public function UpdatepasswordPage(Request $request)
    {
        $input = $request->all();
         Validator::make($request->all(), [
           'current_password' => 'required',
           'password' => [
        'required'
        
    ],
           'password_confirmation' => 'required',
         ])->validate();
        $id=Auth::id();
        $data = User::where('id','=',$id)->get()->first();
        $data->password=Hash::make($input['password']);
          $data->save();
          return redirect('admin/reset')
           ->with('success', 'Password changed successfully !');

        

    }
    public function changepassword(Request $request)
    {
      $input = $request->all();
         Validator::make($request->all(), [
           'change_password' => 'required',
      ]);
      $user=User::where('id','=',$input['change_id'])->get()->first();
      $user->password=Hash::make($input['change_password']);
      $user->save();
      return redirect('admin/employee')->with('success', trans('Password changed successfully'));
    }
    public function SMSCampaign(Request $request)
    {
      $branches=Branch::where('active','=',1)->get();
       return view('admin.smscampaign',compact('request','branches'));
    }
    public function sendbulksms(Request $request)
    {
        $input = $request->all();
         Validator::make($request->all(), [
           'smscontent' => 'required',
           'send_type' => 'required',
         ]);
         if($input['send_type']=="visitors")
         {
          $id=Auth::id();
          $data = User::where('id','=',$id)->get()->first();
          if(($data->desigination_id=="2")||($data->desigination_id=="1"))
          {
            $customers=Customer::where('branches_id','=',$data->branch_id)->get();
            
          }
          else if(($input['visitor_type']=="branch")&&($input['branch']!=""))
          {
            $customers=Customer::where('branches_id','=',$input['branch'])->get();
            
          }
          else
          {
            $customers=Customer::get();
          }
          foreach($customers as $customer)
          {
            $name=$customer->customer_name;
            $mobile=$customer->mobile_no;
            $user="caiindustries"; //your username
            $password="Cai66733"; //your password
            $message = $input['smscontent']; //enter Your Message
            $senderid="CAIIND"; //Your senderid
            $messagetype="N"; //Type Of Your Message
            $DReports="Y"; //Delivery Reports
            $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
            $message = urlencode($message);
            $ch = curl_init();
            if (!$ch){die("Couldn't initialize a cURL handle");}
            $ret = curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt ($ch, CURLOPT_POSTFIELDS,
            "User=$user&passwd=$password&mobilenumber=$mobile&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
            $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
            // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
            $curlresponse = curl_exec($ch);
          }
         }
         else
         {
          $path = $request->file('file')->getRealPath();

          if ($request->has('header')) 
          {
              $data = Excel::load($path, function($reader) {})->get()->toArray();
          } 
          else 
          {
              $data = array_map('str_getcsv', file($path));
          }
          if (count($data) > 0) {
             if ($request->has('header')) {
              $csv_header_fields = [];
              foreach ($data[0] as $key => $value) {
                  $csv_header_fields[] = $key;

                 //print_r($csv_header_fields);

              }
          }
              $csv_data = array_slice($data,1);
              
              foreach ($csv_data as $key=>$value) {
                $name=$csv_data[$key][0];
                $mobile=$csv_data[$key][1];
                $user="caiindustries"; //your username
                $password="Cai66733"; //your password
                $message = $input['smscontent']; //enter Your Message
                $senderid="CAIIND"; //Your senderid
                $messagetype="N"; //Type Of Your Message
                $DReports="Y"; //Delivery Reports
                $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
                $message = urlencode($message);
                $ch = curl_init();
                if (!$ch){die("Couldn't initialize a cURL handle");}
                $ret = curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt ($ch, CURLOPT_POSTFIELDS,
                "User=$user&passwd=$password&mobilenumber=$mobile&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
                $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
                // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
                $curlresponse = curl_exec($ch);
                  
              }
         }
       }
          return redirect('admin/smscampaign')
           ->with('success', 'SMS sent successfully !');

        

    }
}
