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
                             SMS Campaign
                            </h2>
                        </div>
                        <div class="body">
                        <form action="{{ route('sendbulksms') }}" method="post" class="form-horizontal"  id="form_submit" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                          <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Send Type</label>
                            <select  name ="send_type" id="send_type" class="form-control validate">
                              <option value="">Select Type</option>
                              <option value="visitors" selected>Visitors</option>
                              <option value="upload">Upload File</option>
                            </select>
                         </div>
                         <br>
                         <div class="md-form mb-5 upload" style="display:none;">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Upload CSV File To Send SMS</label>
                            <input type="file" name ="file" id="file" class="form-control validate" accept=".csv" ><br>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Sample CSV Format</label>
                            <div class="table-responsive">
                              <table class="table table-bordered">
                                <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Mobile No</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td></td>
                                  <td></td>
                                </tr>
                              </tbody>
                              </table>
                            </div>
                         </div>
                         @php($id=Auth::id())
                         @php($user=App\Models\User::where('id','=',$id)->get()->first())
                         <input type="hidden" name="userid" id="userid" value="{{$user->desigination_id}}">
                         <div class="md-form mb-5 vtype" @if(($user->desigination_id=="1")||($user->desigination_id=="2")) style="display:none;" @endif>
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Visitor Type</label>
                            <select  name ="visitor_type" id="visitor_type" class="form-control validate">
                              <option value="">Visitor Type</option>
                              <option value="all" selected>All</option>
                              <option value="branch">By Branch</option>
                             
                            </select>
                         </div>
                         <div class="md-form mb-5 branch" style="display:none;">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Branch </label>
                            <select  name ="branch" id="branch" class="form-control validate">
                              <option value="">Select Branch</option>
                              @foreach($branches as $branch)
                              <option value="{{$branch->id}}">{{$branch->branch}}</option>
                              @endforeach
                            </select>
                         </div>
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">SMS Content</label>
                           
                            <textarea  name="smscontent" id="smscontent" class="form-control" rows="5">
                            </textarea>
                         </div>
                         
                         
                         <br>
                         <div class="md-form mb-5">
                           <input type="submit" class="btn btn-primary btn-rounded mb-4" style="float: right;">
                         </div>
                         <br><br>
                        </form>   
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
      send_type:
            {

            required:true
            },
           
            smscontent:
            {

            required:true
            },
           
          },
          messages: {
            send_type: "Please select send type",
            smscontent : "Please enter sms content",
            
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
 $(document).on('change','#send_type',function(e) {
            var val=this.value;
            var user=$('#userid').val();
            if(val=="upload")
            {
              $('.upload').show();
              $('.vtype').hide();
              $('.branch').hide();
            }
            else
            {
              $('.upload').hide();
              if((user=="3")||(user=="4"))
              {
                $('.vtype').show();
              }
              
            }
           });
$(document).on('change','#visitor_type',function(e) {
            var val=this.value;
            if(val=="branch")
            {
              $('.branch').show();
            }
            else
            {
              $('.branch').hide();
            }
           });
</script>    
<script>
      
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
