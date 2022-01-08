<!doctype html>
<html lang="en">
<head>

    @yield('title')
	@yield('code_php')
    <!-- topscript call -->
    @if((url()->current()) != url('admin/login'))
        @include('admin.topscript')
    @endif
    @yield('css')
    <base id="myBase" href="{{ URL('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

@if((url()->current()) == url('admin/login'))
    <body class="login_page">
@else
	<body class="side_menu_active side_menu_expanded">
        <div id="page_wrapper">
@endif

<!-- header call -->
@if((url()->current()) != url('admin/login'))
	@include('admin.leftnav')
     <div id="page_wrapper">
        <!-- header -->
        <header id="main_header">
            @include('admin.header')
        </header>
@endif

<!-- Main content  -->
@yield('content')

<!-- footer call -->
@if((url()->current()) != url('admin/login'))
    </div>
	{{-- @include('admin.footer') --}}
@endif

<!-- Modal Content -->
@yield('modal')
<!-- bottomscript call -->
@if((url()->current()) != url('admin/login'))
    @include('admin.bottomscript')
@endif
<!-- Script content -->
@yield('script')

</body>
</html>
