<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/dashboard" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Navbar Right Menu -->
        @if(!empty(request()->user()))
            <ul class="nav nav-pills pull-left" style="position: relative; top:6px;">
                <li class="btn-group top-monitor">
                    <a href="/list" class=""><span class="glyphicon glyphicon-th-list"></span> 列表</a>
                </li>
                <li class="btn-group top-monitor">
                    <a href="/map" class=""><span class="glyphicon glyphicon-map-marker"></span> 地图</a>
                </li>
                <li class="btn-group top-monitor">
                    <a href="#" class=""><span class="glyphicon glyphicon-dashboard"></span> 分析</a>
                </li>
                <li class="btn-group top-monitor">
                    <a href="#" class=""><span class="glyphicon glyphicon-book"></span> 概况</a>
                </li>
            </ul>
        @endif

        @if(!empty(request()->user()))
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown btn-group user user-menu">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="/admin-lte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> {{ request()->user()->name }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/profile">个人设置</a></li>
                        <li><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">退出登录</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </li>
            </ul>
        @else
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown btn-group user user-menu">
                    <a href="login">用户登录</a>
                </li>
            </ul>
        @endif

    </nav>

</header>

