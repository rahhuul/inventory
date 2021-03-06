@yield('code_php')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inventory / {{$title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- topscript call -->
    @include('admin.layouts.topscript')
    @yield('css')
    <base id="myBase" href="{{ URL('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script type="text/javascript">
          window.baseUrl = "{{ URL('/') }}";
    </script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <!-- header call -->
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <!-- Main content  -->
    @yield('content')

    <!-- footer call -->
    @include('admin.layouts.footer')

    <!-- Modal Content -->
    @include('admin.layouts.modal')
    </div>
    <!-- bottomscript call -->
    @include('admin.layouts.bottomscript')
    <script type="text/javascript">
         window.mindate = moment().format("DD-MM-YYYY");
    </script>
    <!-- Script content -->
    @yield('script')
</body>
</html>
