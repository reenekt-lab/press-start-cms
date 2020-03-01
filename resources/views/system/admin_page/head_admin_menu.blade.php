@if(Auth::check())
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        @if(Gate::allows('access_admin_page'))
            <div class="row">
                <div class="col-10 d-flex justify-content-center my-auto admin_header">
                    <a href="{{route('admin_main')}}">Админ страница</a>
                </div>
                <div class="col-2 my-auto site_header">
                    <a href="/">Сайт</a>
                </div>
            </div>
        @endif
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="auth_user_icon">
                    <p style="margin-right: 20px">
                        Здравствуй, {{Auth::user()->login}}
                    </p>
                </li>
                <li class="nav-item dropdown">
                    <a class="logout_a" href="{{route('custom_logout')}}">Выйти</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif
