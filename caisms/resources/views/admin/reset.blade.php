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
                            Reset Password
                            </h2>
                        </div>
                        <div class="body">
                             <form action="{{ route('resetpassword') }}" method="post" class="form-horizontal"  id="form_submit" autocomplete="off" enctype="multipart/form-data">
                             @csrf
                             <div class="md-form mb-5">
                              <i class="fas fa-envelope prefix grey-text"></i>
                              <label data-error="wrong" data-success="right" for="defaultForm-email">Current Password</label>
                              <input type="password"  name ="current_password" id="current_password" class="form-control validate">
                              @error('current_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              </div>
                              <div class="md-form mb-5">
                              <i class="fas fa-envelope prefix grey-text"></i>
                              <label data-error="wrong" data-success="right" for="defaultForm-email">New Password</label>
                              <input type="password"  name ="password" id="password" class="form-control validate">
                              @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              </div>
                              <div class="md-form mb-5">
                              <i class="fas fa-envelope prefix grey-text"></i>
                              <label data-error="wrong" data-success="right" for="defaultForm-email">Confirm Password</label>
                              <input type="password"  name ="password_confirmation" id="password_confirmation" class="form-control validate">
                              @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              </div><br>
                              <div class="md-form mb-5">

                              <button class="btn btn-primary" type="submit">Submit</button>
                              </div>

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
         $(document).on('click','.edit',function(e) {
                var id=this.id;
                var val=$('.city'+id).val();
                $('#cityid').val(id);
                $('#cityname').val(val);
               
            });
           $(document).on('click','.add',function(e) {
                $('#cityid').val('');
                $('#cityname').val('');
                
            });
         </script>
      <script>
jQuery( document ).ready(function() {

jQuery('#form_submit').validate({
    rules:{
        current_password:
            {

            required:true,
            minlength:8
            },
        password:
            {

            required:true,
            minlength:8
            },
        password_confirmation:
            {

            required:true,
            minlength:8,
            equalTo: "#password"
            }
          },
          messages: {
            current_password: "Please enter your 8 digit current password",
            password: "Please enter your 8 digit new password",
            password_confirmation: "Please enter your 8 digit confirm password",
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
                     "url": "{{url('allplaceMaster')}}",
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
              { "data": "name" },
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
        $(document).ready(function() {
            $("#myBtn").click(function() {
                $("#myModal").modal("hide");
            });
  
        });
    </script>
</body>
</html>
