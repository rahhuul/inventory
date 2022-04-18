<!-- jQuery -->
<script src="{{URL('/')}}/assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{URL('/')}}/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="{{URL('/')}}/assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{URL('/')}}/assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="{{URL('/')}}/assets/admin/plugins/moment/moment.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="{{URL('/')}}/assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="{{URL('/')}}/assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{URL('/')}}/assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="{{URL('/')}}/assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="{{URL('/')}}/assets/admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="{{URL('/')}}/assets/admin/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="{{URL('/')}}/assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{URL('/')}}/assets/admin/dist/js/demo.js"></script>


<!-- DataTables -->
<script src="{{URL('/')}}/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/toastr/toastr.min.js"></script>
{{-- extra js aaded --}}
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{URL('/')}}/assets/admin/js/login.js"></script>
<script src="{{URL('/')}}/assets/admin/js/main_admin.js"></script>
<script src="{{URL('/')}}/assets/admin/js/withdraw.js"></script>
<script src="{{URL('/')}}/assets/admin/js/noty.min.js"></script>
<script src="{{URL('/')}}/assets/admin/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
 @if (session('message'))
        cubemine_admin.notifyWithtEle("{{ session('message') }}", "{{ (null !== session('type')) ? session('type') : 'success' }}", 'topRight', 2000);
@endif

$.fn.select2.defaults.reset();
$.fn.select2.defaults.set("theme", "bootstrap4");

$('.select2').select2()

// $("#recustomer_id").select2({disabled:'readonly'});
// $("#rematerial_id").select2({disabled:'readonly'});







</script>