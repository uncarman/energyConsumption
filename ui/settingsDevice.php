
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
              <h3 class="box-title">设备管理</h3>
            </div>
            <div class="box-body">
              <div class="row" ng-repeat="v in datas.collectorList.data">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover" style="margin-bottom: 0px;">
                        <thead>
                        <tr>
                            <th ng-repeat="(k,n) in datas.collectorList.title" ng-bind="n"></th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td ng-repeat="(k,n) in datas.collectorList.title"
                                ng-bind="v[k]"></td>
                            <td>
                                
                                <button class="btn btn-primary btn-xs" ng-click="update_item(v, 1);">编辑</button>
                                <button class="btn btn-default btn-xs" ng-click="update_item(v, 2);">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-11 col-xs-offset-1">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <th ng-repeat="(ki,ni) in datas.meterList.title" ng-bind="ni" style="background:#e9f6f6;"></th>
                        <th style="width:100px; background:#e9f6f6;">操作</th>
                        </thead>
                        <tbody>
                        <tr ng-repeat="vi in datas.meterList.data" ng-show="vi.cid == v.id">
                            <td ng-repeat="(ki,ni) in datas.meterList.title"
                                ng-bind="vi[ki]"></td>
                            <td>
                                <button class="btn btn-primary btn-xs" ng-click="update_item(v, 1);">编辑</button>
                                <button class="btn btn-default btn-xs" ng-click="update_item(v, 2);">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12">
                  <div class="divider"></div>
                  <p></p>
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

                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                $scope.getDatas();
            }

            $scope.getDatas = function () {
                $scope.ajaxDeviceList()
                    .then($scope.summaryData)
                    .then($scope.deviceListTable)
                    .catch($scope.ajaxCatch);
            };

            $scope.ajaxDeviceList = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/settings/ajaxDeviceList",
                    _param: {
                        bid : $scope.datas.building_id
                    }
                };
                return global.return_promise($scope, param);
            }
            $scope.summaryData = function (data) {
                $scope.$apply(function () {
                    $scope.datas.summaryData = data.result;
                });
                return data;
            }
            $scope.deviceListTable = function (data) {
                $scope.$apply(function () {
                    $scope.datas.collectorList = data.result.collectorList;
                    $scope.datas.meterList = data.result.meterList;
                });
            };

            $scope.init_page();
        });


</script>
</body>
</html>