
<?php include"layout/head.php" ?>

<div class="wrapper">

  <?php include"layout/header.php" ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php include"layout/sider.php" ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        设备管理
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><i class="fa fa-files-o"></i> 设备管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">所有配置</h3>
            </div>
            <div class="box-body">
              <div class="nav-tabContents">
                <div class="row">
                    <div class="col-xs-6">
                        <h3><span ng-bind="datas.summaryData.building.name"></span> 全局配置</h3>
                    </div>
                    <div class="col-xs-6">
                        <button class="btn btn-primary pull-right">编辑</button>
                    </div>
                </div>

                <div class="form-horizontal" style="margin-top: 10px;">
                    <div class="form-group">
                        <div class="col-xs-2">能耗国际值</div>
                        <div class="col-xs-10">0.15 kwh/m2</div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2">建筑面积</div>
                        <div class="col-xs-10">900 m2</div>
                    </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
    
  <?php include"layout/footer.php" ?>

</div>
<!-- ./wrapper -->

<?php include"layout/end.php" ?>
<script src="./static/plugins/echart/echarts.js"></script>
<script src="./static/plugins/moment/moment-with-locales.min.js"></script>

<script>
        angular.module("app",[])
            .config(function($interpolateProvider) {
                $interpolateProvider.startSymbol('{[{');
                $interpolateProvider.endSymbol('}]}');
            }).controller('pageCtrl', function($scope) {

            global.on_load_func($scope);

            // 当前页面默认值
            let datas = {
                pageInited : false,
                leftOn: true,
            };
            $.extend(datas, settings.default_datas);
            $scope.datas = datas;

            $scope = global.init_base_scope($scope);

            $scope.init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope);

                console.log("init_page");

                $scope.treeMap = echarts.init(document.getElementById("treeMap"));
                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                $scope.getDatas();
            }

            $scope.getDatas = function () {
                $scope.groupTree();
            };

            $scope.init_page();
        });

</script>
</body>
</html>