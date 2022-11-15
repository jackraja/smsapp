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
                              Branch Master
                            </h2>
                        </div>
                        <div class="body">
                        
                            <div class="table-responsive">
                                <table id="data-table-basic" class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:100%;">
                                    <thead>
                                       <tr>
                                           <th># </th>
                                            <th>Segment Name</th>
                                            <th>Branch Name</th>
                                            <th>Location</th>
                                            <th>Contact Number(Landline)</th>
                                            <th>Contact Number(Mobile)</th>
                                            <!--<th>Branch Manager Name/Mobile No</th>-->
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
    <form action="{{ route('addbranchMaster') }}" method="post" class="form-horizontal"  id="form_submit" autocomplete="off" enctype="multipart/form-data">
     @csrf
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add New Branch</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Vehicle Segment</label>
          <input type="hidden" name="branchid" id="branchid">
          <select  name="vehicle" id="vehicle" class="form-control">
           <option value= "">Select Vehicle Segment</option>
           @foreach($vehicles as $vehicle)
           <option value="{{$vehicle->id}}">{{$vehicle->vehicle}}</option>
           @endforeach
          </select>
       </div>
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Branch Name</label>
          <input type="text"  name ="branchname" id="branchname" class="form-control validate" placeholder="Branch Name">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Location</label>
          <input type="text"  name ="location" id="location" class="form-control validate" placeholder="Location">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Contact No(Landline)</label>
          <input type="tel"  name ="contactnumber" id="contactno" class="form-control validate" placeholder="Landline No" onkeypress="return isNumberKey(event)" onkeyup="return isNumberKey(event)">
       </div>
       <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Contact No(Mobile)</label>
          <input type="tel"  name ="mobileno" id="mobileno" class="form-control validate" placeholder="Mobile name" onkeypress="return isNumberKey(event)" onkeyup="return isNumberKey(event)" maxlength="10">
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
        vehicle:
            {

            required:true
            },
            branchname:
            {

            required:true
            },
            location:
            {

            required:true
            },
            contactnumber:
            {

            required:true
            },
            mobileno:
            {

            required:true
            }

          },
          messages: {
            vehicle: "Please select Vehicle Segment",
            branchname: "Please enter branch Name",
            location: "Please enter location",
            contactnumber: "Please enter landline no",
            mobileno: "Please enter mobile no",
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
                     "url": "{{url('allbranchMaster')}}",
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "vehicle" },
                { "data": "name" },
                { "data": "location" },
                { "data": "branchnameno" },
                { "data": "mobile" },
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
         $(document).on('click','.edit',function(e) {
                var id=this.id;
                var vehicle=$('.zone_'+id).val();
                var branchname=$('.branch_'+id).val();
                var location = $('.location_'+id).val();
                var mobile = $('.mobile_'+id).val();
                var branchnameno = $('.branchnamenumber_'+id).val();
                $('#branchid').val(id);
                $('#branchname').val(branchname);
                $('#location').val(location);
                $('#contactno').val(branchnameno);
                $('#mobileno').val(mobile);
                $('#vehicle').val(vehicle);

                
            });
           $(document).on('click','.add',function(e) {
            $('#branchid').val('');
                $('#branchname').val('');
                $('#location').val('');
                $('#contactno').val('');
                $('#mobileno').val('');
                $('#vehicle').val('');
                
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
