<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php $v = (Cookie::get('userid_login')!='') ? getbalance(Crypt::decrypt(Cookie::get('userid_login'))) :0;

    $numb = isset($v->_Mainbalance) ? number_format($v->_Mainbalance,8) : 0;

    ?>
    <div class="wbalance">
        <!-- <h3 class="ml-3 float-left"> Wallet Balance :</h3>
        <h4 class="ml-1 float-left mt-1"> 
            {{($numb != '') ? $numb : 0.00000000}} 
        </h4> -->
    </div>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{URL('/admin/logout')}}" >
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
