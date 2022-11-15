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
                              Varient
                            </h2>
                        </div>
                        <div class="body">
                        
                            <div class="table-responsive">
                                <table id="data-table-basic" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                       <tr>
                                           <th># </th>
                                            <th>Model Name</th>
                                            <th>Varient Name</th>
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
    <form action="{{ route('addvarientMaster') }}" method="post" class="form-horizontal"  id="form_submit" autocomplete="off" enctype="multipart/form-data">
     @csrf
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add New Varient</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Model</label>
          <input type="hidden" name="varientid" id="varientid">
          <select  name="model" id="model" class="form-control">
           <option value= "">Select Model</option>
           @foreach($model as $models)
           <option value="{{$models->id}}">{{$models->model}}</option>
           @endforeach
          </select>
       </div>
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Varient Name</label>
           <input type="text"  name ="varientname" id="varientname" class="form-control validate">
          @error('varientname')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
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
         $(document).on('click','.edit',function(e) {
                var id=this.id;
                var model=$('.zone_'+id).val();
                var varientname = $('.model_'+id).val();
                $('#varientid').val(id);
                $('#varientname').val(varientname);
                $('#model').val(model);
            });
           $(document).on('click','.add',function(e) {
            $('#varientid').val('');
                $('#varientname').val('');
                $('#model').val('');
                
            });
         </script>
      <script>
jQuery( document ).ready(function() {

jQuery('#form_submit').validate({
    rules:{
     varientname:
            {

            required:true
            },
            model:
            {

            required:true
            }

          },
          messages: {
            varientname: "Please enter varient name",
            model : "Please select model name",
            
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
                     "url": "{{url('allvarientMaster')}}",
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "model" },  
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
