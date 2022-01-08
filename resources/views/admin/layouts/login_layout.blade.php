@yield('code_php')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Transction / {{$title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- topscript call -->
    @include('admin.layouts.topscript')
    @yield('css')
    <base id="myBase" href="{{ URL('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition login-page">

    <!-- Main content  -->
    @yield('content')

    <!-- Modal Content -->
    @yield('modal')
    
    <!-- bottomscript call -->
    @include('admin.layouts.bottomscript')
    <!-- Script content -->
    @yield('script')
</body>
</html>
