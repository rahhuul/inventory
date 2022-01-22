<!-- jQuery -->
<script src="{{URL('/')}}/assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{URL('/')}}/assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{URL('/')}}/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- ChartJS -->
<script src="{{URL('/')}}/assets/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{URL('/')}}/assets/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{URL('/')}}/assets/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{URL('/')}}/assets/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{URL('/')}}/assets/admin/plugins/moment/moment.min.js"></script>
<script src="{{URL('/')}}/assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{URL('/')}}/assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{URL('/')}}/assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{URL('/')}}/assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{URL('/')}}/assets/admin/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{URL('/')}}/assets/admin/dist/js/pages/dashboard.js"></script> -->
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
<script src="{{URL('/')}}/assets/admin/js/myprofile.js"></script>
<script src="{{URL('/')}}/assets/admin/js/main_admin.js"></script>
<script src="{{URL('/')}}/assets/admin/js/withdraw.js"></script>
<script src="{{URL('/')}}/assets/admin/js/noty.min.js"></script>
<script src="{{URL('/')}}/assets/admin/js/socket.io.js"></script>
<script src="{{URL('/')}}/assets/admin/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
<script>
 @if (session('message'))
        cubemine_admin.notifyWithtEle("{{ session('message') }}", "{{ (null !== session('type')) ? session('type') : 'success' }}", 'topRight', 2000);
@endif


$('.select2').select2();
 $('.js-example-basic-single').select2();
</script>