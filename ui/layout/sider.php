<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="./static/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Sam</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li>
          <a href="index.php">
            <i class="index fa fa-th"></i> <span>数据中心</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>监测分析</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="monitor"><a href="monitor.php"><i class="fa fa-circle-o"></i> 总体用能概述</a></li>
            <li class="monitorAmmeter monitorAmmeterByType"><a href="monitorAmmeter.php"><i class="fa fa-circle-o"></i> 电能监测</a></li>
            <li class="monitorWatermeter"><a href="#monitorWatermeter.php"><i class="fa fa-circle-o"></i> 水量监测</a></li>
            <li class="monitorGasmeter"><a href="#monitorGasmeter.php"><i class="fa fa-circle-o"></i> 天然气监测</a></li>
            <li class="monitorVapourmeter"><a href="#monitorVapourmeter.php"><i class="fa fa-circle-o"></i> 蒸汽量监测</a></li>
            <li class="monitorEnvironment"><a href="#monitorEnvironment.php"><i class="fa fa-circle-o"></i> 室内环境监测</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i> <span>数据统计</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="statistics"><a href="statistics.php"><i class="fa fa-circle-o"></i> 能耗统计</a></li>
            <li class="statisticsFee"><a href="statisticsFee.php"><i class="fa fa-circle-o"></i> 费用分析</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> 评价能耗</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i> <span>节能管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../statistics/summary"><i class="fa fa-circle-o"></i> ###</a></li>
            <li><a href="../statistics/summaryFee"><i class="fa fa-circle-o"></i> ###</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> ###</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i> <span>报警处理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="warning"><a href="warning.php"><i class="fa fa-circle-o"></i> 所有报警</a></li>
            <li class="warningSetting"><a href="warningSetting.php"><i class="fa fa-circle-o"></i> 报警设置</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>系统配置</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="settingsGroup"><a href="settingsGroup.php"><i class="fa fa-circle-o"></i> 监测配置</a></li>
            <li class="settingsDevice"><a href="settingsDevice.php"><i class="fa fa-circle-o"></i> 设备管理</a></li>
            <li class="settingsBase"><a href="settingsBase.php"><i class="fa fa-circle-o"></i> 基本配置</a></li>
            <li class="settingsProfile"><a href="settingsProfile.php"><i class="fa fa-circle-o"></i> 账号管理</a></li>
            <li class="settingsRoles"><a href="settingsRoles.php"><i class="fa fa-circle-o"></i> 权限和角色</a></li>
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>