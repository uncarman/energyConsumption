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
                <a href="../monitor/summary" class=""><span class="glyphicon glyphicon-dashboard"></span> 监测分析</a>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only"> </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="../monitor/summary">总体用能概述</a></li>
                    <li><a href="../monitor/ammeter">电能监测</a></li>
                    <li><a href="../monitor/watermeter">水量监测</a></li>
                    <li><a href="../monitor/gasmeter">天然气监测</a></li>
                    <li><a href="../monitor/vapourmeter">蒸汽量监测</a></li>
                    <li><a href="../monitor/environment">室内环境监测</a></li>
                </ul>
            </li>

            <li class="btn-group top-statistics">
                <a href="../statistics/summary" class=""><span class="glyphicon glyphicon-calendar"></span> 数据统计</a>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only"> </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="../statistics/summary">能耗统计</a></li>
                    <li><a href="../statistics/summaryFee">费用分析</a></li>
                    <li><a href="#">评价能耗</a></li>
                </ul>
            </li>

            <li class="btn-group top-management">
                <a href="../management/summary" class=""><span class="glyphicon glyphicon-leaf"></span> 节能管理</a>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only"> </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/monitor/ammeter">电能监测</a></li>
                    <li><a href="/monitor/watermeter">水量监测</a></li>
                </ul>
            </li>

            <li class="btn-group top-warning">
                <a href="../warning/summary" class=""><span class="glyphicon glyphicon-envelope"></span> 报警处理</a>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only"> </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="../warning/summary">所有报警</a></li>
                    <li><a href="../warning/alertSettings">报警设置</a></li>
                </ul>
            </li>

            <li class="btn-group top-settings">
                <a href="../settings/group" class=""><span class="glyphicon glyphicon-cog"></span> 系统配置</a>
                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only"> </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="../settings/group">监测配置</a></li>
                    <li><a href="../settings/device">设备管理</a></li>
                    <li><a href="../settings/base">基本配置</a></li>
                    <li class="divider"></li>
                    <li><a href="/settings/profile">账号管理</a></li>
                    <li><a href="/settings/roles">权限和角色</a></li>
                </ul>
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

