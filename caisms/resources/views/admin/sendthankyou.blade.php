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
  <!--<a href="" class="btn btn-default btn-rounded mb-4 add" data-toggle="modal" style="float: right;" data-target="#modalLoginForm">
    Add New</a>-->
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
                             Thank you Form
                            </h2>
                        </div>
                        <div class="body">
                        <form action="{{ route('updatecustomer') }}" method="post" class="form-horizontal"  id="form_submit" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="customer_id" name="customer_id" value="{{$customer->id}}">
                        <div class="row">
                          <div class="col-md-6">
                          <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Walkin Date</label>
                            <input type="text"  name ="walkin_date" id="walkin_date" class="form-control validate" placeholder="Walkin Date" value="{{date('d-m-Y',strtotime($customer->walkin_date))}}" readonly>
                         </div>
                       </div>
                       <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Walkin Branch</label>
                            <input type="text"  name ="branch" id="branch" class="form-control validate" placeholder="Walkin Branch" value="@if(!empty($branch)){{$branch->branch}} @endif" @if(!empty($branch)) readonly @endif>
                         </div>
                        </div>
                          <div class="col-md-6">
                          <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Customer Name</label>
                            <input type="text"  name ="customer_name" id="customer_name" class="form-control validate" placeholder="Customer Name" value="{{$customer->customer_name}}" readonly>
                         </div>
                       </div>
                       <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Customer Mobile number</label>
                            <input type="text"  name ="mobile_no" id="mobile_no" class="form-control validate" placeholder="Customer Mobile number" onkeypress="return isNumberKey(event)" onkeyup="return isNumberKey(event)" maxlength="10" value="{{$customer->mobile_no}}" readonly>
                         </div>
                        </div>
                        <div class="col-md-6">
                          <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Customer Email</label>
                            <input type="text"  name ="customer_email" id="customer_email" class="form-control validate" placeholder="Customer Email">
                         </div>
                       </div>
                       <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Vehicle Segment<span style="color:red;">*</span></label>
                            <select  name ="vehicle_segment" id="vehicle_segment" class="form-control validate" readonly>
                              <option value="">Vehicle Segment</option>
                              @foreach($segments as $segment)
                              <option value="{{$segment->id}}" @if((!empty($branch))&&($segment->id==$branch->vehicle_id)) selected @endif>{{$segment->vehicle}}</option>
                              @endforeach
                            </select>
                         </div>
                        </div>
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Model Interested<span style="color:red;">*</span></label>
                            <select  name ="model" id="model" class="form-control validate">
                              <option value="">Model Interested</option>
                              @foreach($models as $model)
                              <option value="{{$model->id}}">{{$model->model}}</option>
                              @endforeach
                            </select>
                         </div>
                        </div> 
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Varient Interested<span style="color:red;">*</span></label>
                            <select  name ="varient" id="varient" class="form-control validate">
                              <option value="">Varient Interested</option>
                              @foreach($varients as $varient)
                              <option value="{{$varient->id}}">{{$varient->varient}}</option>
                              @endforeach
                            </select>
                         </div>
                        </div> 
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Customer Type<span style="color:red;">*</span></label>
                            <select  name ="customer_type" id="customer_type" class="form-control validate">
                              <option value="">Customer Type</option>
                              <option value="Individual">Individual</option>
                              <option value="Government">Government</option>
                              <option value="Corporate">Corporate</option>
                              
                            </select>
                         </div>
                        </div>
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Customer Category<span style="color:red;">*</span></label>
                            <select  name ="customer_category" id="customer_category" class="form-control validate">
                              <option value="">Customer Category</option>
                              <option value="New">New</option>
                              <option value="Existing">Existing</option>
                              
                            </select>
                         </div>
                        </div>
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Sale Status<span style="color:red;">*</span></label>
                            <select  name ="sale_status" id="sale_status" class="form-control validate">
                              <option value="">Sale Status</option>
                              <option value="Hot">Hot</option>
                              <option value="Warm">Warm</option>
                              <option value="Cold">Cold</option>
                            </select>
                         </div>
                        </div>
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Next Followup date<span style="color:red;">*</span></label>
                            <input type="date"  name ="followup" id="followup" class="form-control validate">
                             
                         </div>
                        </div>
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">SSC / FSC name<span style="color:red;">*</span></label>
                            <select  name ="ssc_name" id="ssc_name" class="form-control validate">
                              <option value="">SSC/FSC name</option>
                              @foreach($users as $user)
                              <option value="{{$user->id}}">{{$user->name}}</option>
                              @endforeach
                            </select>
                             
                         </div>
                        </div>
                        <div class="col-md-6">
                         <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Remarks</label>
                            <textarea  name ="remarks" id="remarks" class="form-control validate"></textarea>
                             
                         </div>
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
            customer_email:
            {
              email:true
            },
      vehicle_segment:
            {

            required:true
            },
            model:
            {

            required:true
            },
            varient:
            {

            required:true
            },
            customer_type:
            {

            required:true
            },
            customer_category:
            {

            required:true
            },
            sale_status:
            {

            required:true
            },
            followup:
            {

            required:true
            },
            ssc_name:
            {

            required:true
            },
           
          },
          messages: {
            customer_email:"Please enter valid email id",
            vehicle_segment: "Please select vehicle segment",
            model : "Please select model interested",
            varient: "Please select varient interested",
            customer_type: "Please select customer type",
            customer_category:"Please select customer category",
            sale_status: "Please select sale status",
            followup: "Please enter next follow up date",
            ssc_name: "Please select ssc/fsc name",
            
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
           $(document).on('change','#model',function(e) {
            var val=this.value;
            $.ajax({
                type:"POST",
                url:"{{url('getvarient')}}",
                data:{_token:"{{csrf_token()}}",id:val},
                success:function(html){
                  var objs=JSON.parse(html);
                  $('#varient').html(objs['html']);
                  
                 }
              });
           });
         </script>
</body>
</html>
