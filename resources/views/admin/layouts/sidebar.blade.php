<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{URL('/dashboard')}}" class="brand-link">
        <img src="{{URL('/')}}/assets/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
        <span class="brand-text font-weight-light text-white">AdminLTE 3</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{URL('/admin/dashboard')}}" class="nav-link @if((url()->current()) == url('/index') || (url()->current()) == url('/') || (url()->current()) == url('/dashboard'))active @endif ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{URL('/admin/user')}}" class="nav-link  @if((url()->current()) == url('/admin/event'))active @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Customers</p>
                    </a>
                </li>
                 
                

            </ul>
        </nav>
    </div>
</aside>