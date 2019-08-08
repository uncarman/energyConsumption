
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
        报警处理
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><i class="fa fa-files-o"></i> 报警处理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">所有类型报警</h3>
              <div class="form-inline pull-right mb15">
                <div class="form-group">
                    <label class="">选择日期:</label>
                    <input type="text" class="form-control" id="reservation">
                    <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                
                <div class="col-md-3">
                  <div class="info-box bg-aqua info-box-normal">
                    <span class="info-box-icon"><i class="fa">电</i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">未处理: <b>2</b></span>
                      <span class="info-box-text">月能耗报警: <b>2</b></span>
                      <span class="info-box-text">总能耗报警: <b>2</b></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="info-box bg-aqua info-box-normal">
                    <span class="info-box-icon"><i class="fa">水</i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">未处理: <b>2</b></span>
                      <span class="info-box-text">月能耗报警: <b>2</b></span>
                      <span class="info-box-text">总能耗报警: <b>2</b></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="info-box bg-aqua info-box-normal">
                    <span class="info-box-icon"><i class="fa">气</i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">未处理: <b>2</b></span>
                      <span class="info-box-text">月能耗报警: <b>2</b></span>
                      <span class="info-box-text">总能耗报警: <b>2</b></span>
                    </div>
                    <div class="clearfixed"></div>
                  </div>
                  <div class="clearfixed"></div>
                </div>

                <div class="col-md-3">
                  <div class="info-box bg-aqua info-box-normal">
                    <span class="info-box-icon"><i class="fa">环境</i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">未处理: <b>2</b></span>
                      <span class="info-box-text">月能耗报警: <b>2</b></span>
                      <span class="info-box-text">总能耗报警: <b>2</b></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <div class="clearfixed"></div>
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
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#" data-toggle="tab1">电(2)</a></li>
              <li><a href="#" data-toggle="tab2">水(0)</a></li>
              <li><a href="#" data-toggle="tab3">天然气(0)</a></li>
              <li><a href="#" data-toggle="tab4">蒸汽(0)</a></li>
              <li><a href="#" data-toggle="tab5">室内环境(0)</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="row">
                  <div class="col-md-12">
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
                              <button class="btn btn-success btn-xs" ng-click="update_item(v, 1);">处理</button>
                              <button class="btn btn-default btn-xs" ng-click="update_item(v, 2);">忽略</button>
                          </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab2">
              </div>

              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab3">
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab4">
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab5">
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        </div>
      </div>

      <div class="clearfixed"></div>
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

                fmt: "YYYY-MM-DD",
                datePickerDom: "#reservation",
                leftOn: true,
                datePickerClassName: ".J-datepicker-range-day",
                fromDate: moment().add(-7, 'day').format("YYYY-MM-DD"),
                toDate: moment().format("YYYY-MM-DD"),

                startYear: startYear,
                opts : {
                    types: [
                        {
                            val: "hour",
                            name: "按小时",
                            "fmt" : "D-H",
                        },
                        {
                            val: "day",
                            name: "按日",
                            "fmt" : "Y-M-D",
                        },
                        {
                            val: "month",
                            name: "按月",
                            "fmt" : "Y-M",
                        },
                        {
                            val: "year",
                            name: "按年",
                            "fmt" : "Y",
                        }
                    ],
                    // 需要根据当前时间生成对比数据
                    compareTos: [
//                        {
//                            val: 2018,
//                            name: "2018年同比数据"
//                        }
                    ],
                },

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

            //Date range picker
            $($scope.datas.datePickerDom).daterangepicker({
              startDate: moment($scope.datas.fromDate),
              endDate: moment($scope.datas.toDate),
              locale: {
                 format: $scope.datas.fmt
              },
            });

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
                global.init_compareto($scope);
                //$scope.init_datepicker($scope.datas.datePickerClassName);

                $scope.datas.query.type = $scope.datas.opts.types[1].val;
                $scope.datas.query.compareTo = $scope.datas.opts.compareTos[0].val;

                console.log("init_page");
                $scope.getDatas();
            };

            $scope.getDatas = function () {
                $scope.ajaxWarnng()
                    .then($scope.initBaseDatas)
                    .then($scope.summaryDatas)
                    .then($scope.summaryChartTable)
                    .catch($scope.ajaxCatch);
            };

            $scope.ajaxWarnng = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/warning/ajaxWarning",
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