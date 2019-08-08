
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
        报警设置
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><i class="fa fa-files-o"></i> 报警设置</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">提醒设置</h3>
            </div>
            <div class="box-body">
              <div class="row">
                
                <div class="col-xs-12">
                  <form class="form-inline ng-pristine ng-valid">
                      <div class="form-group mr10">
                          <label for="name">名称</label>
                          <input type="text" class="form-control" id="name" placeholder="管理员名称">
                      </div>
                      <div class="form-group mr10">
                          <label for="sendTo">发送</label>
                          <input type="text" class="form-control" id="sendTo" placeholder="联系方式: 电话或邮箱">
                      </div>
                      <p></p>
                      <div class="form-group mr10">
                          <label for="from">最早</label>
                          <input type="text" class="form-control" id="from" placeholder="最早时间">
                      </div>
                      <div class="form-group mr10">
                          <label for="to">最晚</label>
                          <input type="text" class="form-control" id="to" placeholder="最晚时间">
                      </div>
                      <div class="form-group mr10">
                          <label for="span">间隔</label>
                          <input type="number" class="form-control" id="span" placeholder="时间间隔">
                      </div>
                      <button type="button" class="btn btn-primary">添加</button>
                  </form>
                </div>

                <div class="clearfixed"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">所有提醒人员</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th ng-repeat="(k,n) in datas.warningList.title" ng-bind="n"></th>
                      <th>操作</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr ng-repeat="v in datas.warningList.data">
                      <td ng-repeat="(k,n) in datas.warningList.title"
                          ng-bind="v[k]"></td>
                      <td>
                          <button class="btn btn-primary btn-xs" ng-click="update_item(v, 1);">编辑</button>
                          <button class="btn btn-success btn-xs" ng-click="update_item(v, 1);">停止</button>
                          <button class="btn btn-default btn-xs" ng-click="update_item(v, 2);">删除</button>
                      </td>
                  </tr>
                  </tbody>
              </table>
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

            var startYear = 2018;

            // 当前页面默认值
            let datas = {
                pageInited : false,

                selectMeterType : 0,

                leftOn: true,
                datePickerClassName: ".J-datepicker-range-day",
                fromDate: moment().add(-7, 'day').format("YYYY-MM-DD"),
                toDate: moment().format("YYYY-MM-DD"),

                query: {
//                    type: null,
//                    compareTo: null,
                },

                guides : [
                    {
                        "url": "../",
                        "name": "",
                    },
                    {
                        "url": "../monitor/summary",
                        "name": "监测分析"
                    },
                    {
                        "url": "../monitor/ammeter",
                        "name": "电能监测"
                    },
                    {
                        "url": "",
                        "name": "总用电概述"
                    }
                ],

                summaryChartTypes: {
                    0: "能耗kwh",
                    1: "能耗密度kwh/m2",
                    2: "标煤(吨)",
                    3: "碳排放(吨)",
                    4: "费用(元)"
                },
                selectSummaryChartType : 1,

                summaryData: {},

                summaryTableDatas: [],
            };
            $.extend(datas, settings.default_datas);
            $scope.datas = datas;

            $scope = global.init_base_scope($scope);
            $scope.compareClass = global.normalCompareClass;
            $scope.compareValue = global.normalCompareValue;

            $scope.ch_datas_on = function () {
                $scope.datas.leftOn = !$scope.datas.leftOn;
                global.init_left();
            };

            $scope.init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope);
                //$scope.init_datepicker($scope.datas.datePickerClassName);

                console.log("init_page");
                $scope.getDatas();
            };

            $scope.getDatas = function () {
                $scope.ajaxWarnng()
                    .then($scope.initBaseDatas)
                    .then($scope.summaryChartTable)
                    .catch($scope.ajaxCatch);
            };

            $scope.ajaxWarnng = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/warning/ajaxAlertList",
                    _param: {}
                };
                return global.return_promise($scope, param);
            };

            $scope.initBaseDatas = function (data) {
                $scope.datas.cacheData = data;
                if(!$scope.datas.pageInited) {
                    $scope.$apply(function () {
                        $scope.datas.pageInited = true;
                        $scope.datas.types = data.result.types;
                    });
                }
                return data;
            };

            $scope.summaryDatas = function (data) {
                $scope.$apply(function () {
                    $scope.datas.warningSummary = data.result.warningSummary;
                });
                return data;
            };

            $scope.summaryChartTable = function (data) {
                $scope.$apply(function () {
                    $scope.datas.warningList = data.result.warningList;
                });
                return data;
            };

            $scope.update_item = function (ind, d, status) {
                if(confirm("确定已处理当前信息: " + d.id + " ?")) {
                    delete $scope.datas.warningList[ind];
                }
            };

            $scope.init_page();
        });

    
</script>
</body>
</html>