@include('partials.adminheader')
<style type="text/css">
 [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
    position: unset !important;
    left: -9999px;
    opacity: unset !important;
}
</style>
<section class="content">
        <div class="container-fluid">
            <!-- Input -->
            <!-- Basic Examples -->
            <div class="row clearfix">
           
            <div class="text-center">
  <a href="" class="btn btn-default btn-rounded mb-4 add" data-toggle="modal" style="float: right;" data-target="#modalLoginForm">
    Add New</a>
</div>
<br><br>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 @if(session('error'))
                    <div class="alert bg-pink alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{session('error')}}
                    </div>
                  @endif
                  @if(session('success'))
                  <div class="alert bg-green alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{session('success')}}
                    </div>
                    @endif
                    <div class="card">
                        <div class="header">
                            <h2>
                              Employee Master
                            </h2>
                        </div>
                        <div class="body">
                        
                            <div class="table-responsive">
                                <table id="data-table-basic" class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:100%;">
                                    <thead>
                                       <tr>
                                           <th># </th>
                                            <th>Employee Code</th>
                                            <th>Name</th>
                                            <th>MobileNo</th>
                                            <th>Branch</th>
                                            <th>Designation</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                         </tr>
                                   </thead>
                                   <tbody>
                                      
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="{{ route('addemployeeMaster') }}" method="post" class="form-horizontal"  id="form_submit" autocomplete="off" enctype="multipart/form-data">
     @csrf
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add New Employee</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
      
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Employ Code</label>
          <input type="text"  name ="employcode" id="employcode" class="form-control validate" placeholder="Employee Code">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Name</label>
          <input type="text"  name ="name" id="name" class="form-control validate" placeholder="Name">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Desigination</label>
         
          <select  name="desigination" id="desigination" class="form-control">
           <option value= "">Select Desigination</option>
           @foreach($desigination as $desiginations)
           <option value="{{$desiginations->id}}">{{$desiginations->desigination}}</option>
           @endforeach
          </select>
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Branch</label>
          <input type="hidden" name="employeeid" id="employeeid">
          <select  name="branch" id="branch" class="form-control">
           <option value= "">Select Branch</option>
           @foreach($branch as $branchs)
           <option value="{{$branchs->id}}">{{$branchs->branch}}</option>
           @endforeach
          </select>
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Mobile No</label>
          <input type="tel"  name ="mobile" id="mobile" class="form-control validate" placeholder="Mobile No" onkeypress="return isNumberKey(event)" onkeyup="return isNumberKey(event)" maxlength="10">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Date Of Joining</label>
          <input type="date"  name ="doj" id="doj" class="form-control validate" placeholder="Date Of Joining">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Status</label>
          <select  name="status" id="status" class="form-control">
           <option value= "">Select Status</option>
          <option value="Active">Active</option>
          <option value="Resigned">Resigned</option>
         </select>
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Login Name</label>
          <input type="text"  name ="loginname" id="loginname" class="form-control validate" placeholder="Login Name">
       </div>
       <div class="md-form mb-5 password">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Password</label>
          <input type="text"  name ="password" id="password" class="form-control validate" placeholder="Password">
       </div>
      
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-default">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modalChangeForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="{{ route('changepassword') }}" method="post" class="form-horizontal"  id="form_change" autocomplete="off" enctype="multipart/form-data">
     @csrf
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Change Employee Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <input type="hidden" name="change_id" id="change_id">
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">New Password</label>
          <input type="password"  name ="change_password" id="change_password" class="form-control validate" placeholder="Password">
       </div>
       
       
       
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-default">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="confirmActive" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
            <h4 class="modal-title">Deactivate Parmanently</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       </div>
       <div class="modal-body">
         <p>Are you sure deactivate this?</p>
       </div>
       <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="confirm">Submit</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>

                
    </section>

       <!-- Jquery Core Js -->
       <script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{asset('asset/plugins/bootstrap/js/bootstrap.js')}}"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('asset/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('asset/plugins/node-waves/waves.js')}}"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('asset/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{asset('asset/js/admin.js')}}"></script>
    <script src="{{asset('asset/js/pages/tables/jquery-datatable.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('asset/js/demo.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script src="{{asset('asset/js/jquery.validate.js')}}"></script>
    <script>
jQuery( document ).ready(function() {

jQuery('#form_submit').validate({
    rules:{
      name:
            {

            required:true
            },
            employcode:
            {

            required:true
            },
            desigination:
            {

            required:true
            },
            branch:
            {

            required:true
            },
            doj:
            {

            required:true
            },
            status:
            {

            required:true
            },
            mobile:
            {
            required:true
            },
            password:
            {

             required:{
                depends: function(elem) {
                    if(($('#loginname').val()!="")&&($('#employeeid').val()==""))
                    {
                        return true
                    }
                
                }
                }
            },
          },
          messages: {
            name: "Please enter Name",
            employcode : "Please enter Employee Code",
            desigination: "Please select Desigination",
            branch: "Please select Branch",
            doj: "Please enter Date Of Joining",
            status: "Please select Status",
            mobile:"Please enter mobile number",
            password: "Please enter 8 digit Password",
          },
          highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

})
});
</script>
   <script>
jQuery( document ).ready(function() {
jQuery('#form_change').validate({
    rules:{
      change_password:
            {

            required:true
            },
          },  
          messages: {
            change_password: "Please enter 8 digit password",
            
          },
          highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

})
});
</script>
  
    <script>
    $(document).ready(function () {
        
        $('#data-table-basic').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "destroy": true,
            "ajax":{
                     "url": "{{url('allemployeeMaster')}}",
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "employcode" },
                { "data": "employee" },
                { "data": "mobile" },
                { "data": "branch" },
                { "data": "desigination" },
                { "data": "status" },
                { "data": "actions" },
             ],
            "columnDefs": [
                { "orderable": false, "targets": 0}
            ]
        });
    });
    </script>
 
         
         <script>
      $('#confirmActive').on('show.bs.modal', function (e) {
          $message = $(e.relatedTarget).attr('data-message');
          $(this).find('.modal-body p').text($message);
          $title = $(e.relatedTarget).attr('data-title');
          $(this).find('.modal-title').text($title);

          // Pass form reference to modal for submission on yes/ok
         var form = $(e.relatedTarget).closest('form');
          $(this).find('.modal-footer #confirm').data('form', form);
      });

      <!-- Form confirm (yes/ok) handler, submits form -->
      $('#confirmActive').find('.modal-footer #confirm').on('click', function(){
      $(this).data('form').submit();
      });
    </script>
    
<script>
        $(document).on('click','.change',function(e) {
                var id=this.id;
                $('#change_id').val(id);
          });
         $(document).on('click','.edit',function(e) {
                var id=this.id;
                var branch=$('.branch_'+id).val();
                var employee=$('.employee_'+id).val();
                var employcode = $('.employcode_'+id).val();
                var status = $('.status_'+id).val();
                var loginname = $('.loginname_'+id).val();
                var password = $('.password_'+id).val();
                var doj = $('.doj_'+id).val(); 
                var mobile=$('.mobile_'+id).val();
                var desig=$('.desig_'+id).val();
                $('#employeeid').val(id);
                $('#name').val(employee);
                $('#employcode').val(employcode);
                $('#status').val(status);
                $('#loginname').val(loginname);
                $('.password').hide();
                $('#doj').val(doj);
                $('#mobile').val(mobile);
                $('#desigination').val(desig);
                $('#branch').val(branch);
              });
           $(document).on('click','.add',function(e) {
                $('#employeeid').val('');
                $('#name').val('');
                $('#employcode').val('');
                $('#status').val('');
                $('#loginname').val('');
                $('#password').val('');
                $('.password').show();
                $('#mobile').val('');
                $('#desigination').val('');
                $('#branch').val('');
            });
           function isNumberKey(evt){
              var charCode = (evt.which) ? evt.which : event.keyCode
              if (charCode > 31 && (charCode < 48 || charCode > 57))
              {
                  if((charCode!=32)&&(charCode!=43))
                  {
                      return false; 
                  }
                  else{
                  return true;
                  }
              }
              else{
                  return true;
              }  
          } 
         </script>
</body>
</html>
