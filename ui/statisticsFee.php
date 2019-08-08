
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
        数据统计
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><i class="fa fa-files-o"></i> 总费用统计</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">总费用统计</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="info-box bg-yellow">
                        <div class="info-box-content">
                          <span class="info-box-text">总共费用(元)</span>
                          <span class="info-box-number">310,303.20</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description pull-left">
                            环比: 0.00%
                          </span>
                          <span class="progress-description pull-right">
                            2018年同比: 0.00%
                          </span>
                          <div class="clearfixed"></div>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="info-box bg-aqua">
                        <div class="info-box-content">
                          <span class="info-box-text">总电费(元)</span>
                          <span class="info-box-number">100,848.54</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description pull-left">
                            环比: 0.00%
                          </span>
                          <span class="progress-description pull-right">
                            2018年同比: 0.00%
                          </span>
                          <div class="clearfixed"></div>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="info-box bg-aqua">
                        <div class="info-box-content">
                          <span class="info-box-text">总水费(元)</span>
                          <span class="info-box-number">31.03</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description pull-left">
                            环比: 0.00%
                          </span>
                          <span class="progress-description pull-right">
                            2018年同比: 0.00%
                          </span>
                          <div class="clearfixed"></div>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="info-box bg-aqua">
                        <div class="info-box-content">
                          <span class="info-box-text">总燃气费(元)</span>
                          <span class="info-box-number">263,757.72</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description pull-left">
                            环比: 0.00%
                          </span>
                          <span class="progress-description pull-right">
                            2018年同比: 0.00%
                          </span>
                          <div class="clearfixed"></div>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="info-box bg-aqua">
                        <div class="info-box-content">
                          <span class="info-box-text">总蒸汽费(元)</span>
                          <span class="info-box-number">263,757.72</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                          </div>
                          <span class="progress-description pull-left">
                            环比: 0.00%
                          </span>
                          <span class="progress-description pull-right">
                            2018年同比: 0.00%
                          </span>
                          <div class="clearfixed"></div>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                    </div>
                  </div>
                </div>
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
              <h3 class="box-title">按时间区间概况</h3>
              <div class="form-inline pull-right mb15">
                <div class="form-group">
                    <label class="">选择日期:</label>
                    <input type="text" class="form-control" id="reservation">
                    <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                </div>
              </div>
              <div class="clearfixed"></div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"> 画图表示</h3>
                      <div class="form-inline pull-right mb15">
                        <div class="form-group">
                            <label class="">国标值:</label>
                            <span class="form-control w100" style="border:none ;" ng-bind="datas.summaryData.internationalValue"></span>
                        </div>
                        <div class="form-group">
                            <label class="">数据单位:</label>
                            <select class="form-control" ng-model="datas.selectSummaryChartType" ng-change="chSummaryChartInput()">
                                <option ng-repeat="(o,n) in datas.summaryChartTypes"
                                        ng-value="o"
                                        ng-bind="n"
                                        ng-selected="datas.selectSummaryChartType==o"
                                ></option>
                            </select>
                        </div>
                      </div>
                      <div class="clearfixed"></div>
                    </div>

                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div id="summaryPieChart" style="height:400px;"></div>
                        </div>
                        <div class="col-md-8">
                          <div id="summaryChart" style="height:400px;"></div>
                          <div id="dailyChart" style="width:100%; height:360px; display: none;"></div>
                        </div>
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
                      <h3 class="box-title"><span ng-bind="datas.fromDate"></span> - <span ng-bind="datas.toDate"></span> 数据</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover">
                          <thead>
                          <tr>
                              <th ng-repeat="t in datas.summaryTableTitles" ng-bind="t"></th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr ng-repeat="(k,v) in datas.summaryTableDatas">
                              <td ng-repeat="t in datas.summaryTableTitles"
                                  ng-bind="v[$index]"></td>
                          </tr>
                          </tbody>
                      </table>

                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
              </div>
            </div>
            <!-- /.box-body -->
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

            $scope = global.init_base_scope($scope);
            $scope.compareClass = global.normalCompareClass;
            $scope.compareValue = global.normalCompareValue;

            // 当前页面默认值
            let datas = {
                fmt: "YYYY-MM-DD",
                datePickerDom: "#reservation",
                leftOn: true,
                datePickerClassName: ".J-datepicker-range-day",
                fromDate: moment().add(-7, 'day').format("YYYY-MM-DD"),
                toDate: moment().format("YYYY-MM-DD"),

                summaryChartTypes: [
                    "能耗密度kwh/m2",
                    "能耗kwh",
                ],

                summaryData: {
                    internationalValue: 0.15,  // 国际能耗
                },

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

            $scope.ch_datas_on = function () {
                $scope.datas.leftOn = !$scope.datas.leftOn;
                global.init_left($scope, function () {
                    setTimeout(function(){
                        $scope.summaryChart.resize();
                        $scope.summaryPieChart.resize();
                        $scope.dailyChart.resize();
                    }, 500);
                });
            };

            $scope.init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope, function () {
                    setTimeout(function(){
                        $scope.summaryChart.resize();
                        $scope.summaryPieChart.resize();
                        $scope.dailyChart.resize();
                    }, 500);
                });
                //$scope.init_datepicker($scope.datas.datePickerClassName);
                console.log("init_page");

                $scope.summaryChart = echarts.init(document.getElementById("summaryChart"));
                $scope.summaryPieChart = echarts.init(document.getElementById("summaryPieChart"));
                $scope.dailyChart = echarts.init(document.getElementById("dailyChart"));

                $scope.getDatas();

//                $scope.dailyChartDraw();
//                $scope.summaryChartDraw();
//                $scope.summaryPieDraw();
//                $scope.summaryChartTable();
//                $scope.init_datepicker();
            };

            $scope.refresh_datas = function () {
                $scope.datas.fromDate = $($scope.datas.datePickerClassName).find("input").eq(0).val();
                $scope.datas.toDate = $($scope.datas.datePickerClassName).find("input").eq(1).val();
                $scope.getDatas();
            }

            $scope.getDatas = function () {
                $scope.ajaxMeterSummary()
                    .then($scope.initBaseDatas)
                    .then($scope.summaryDatas)
                    .then($scope.summaryChartDraw)
                    .then($scope.summaryPieDraw)
                    .then($scope.summaryChartTable)
                    .catch($scope.ajaxCatch);
            };
            $scope.ajaxMeterSummary = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/statistics/ajaxMeterSummary",
                    _param: {
                        from : $scope.datas.fromDate,
                        to: $scope.datas.toDate,
//                        type: $scope.datas.query.type,
//                        compareTo: $scope.datas.query.compareTo,
                    }
                };
                return global.return_promise($scope, param);
            }

            $scope.initBaseDatas = function (data) {
                $scope.datas.cacheData = data;
                if(!$scope.datas.pageInited) {
                    $scope.$apply(function () {
                        $scope.datas.pageInited = true;
                    });
                }
                return data;
            };

            $scope.summaryDatas = function (data) {
                $scope.$apply(function () {
                    $scope.datas.summaryData = data.result.summaryData;
                })
                return data;
            }

            // var colors = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
            var option = {
                color: settings.colors,
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:[],
                    y: "10px",
                },
                grid: {
                    top: "0",
                    left: "0",
                    right: "0",
                    bottom: "0",
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : []
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
//                    {
//                        name:'用电量',
//                        type:'bar',
//                        data:[]
//                    }
                ]
            };
            var opts = {
                color: settings.colors,
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:[],
                    y: "10px",
                },
                grid: {
                    top: "0",
                    left: "0",
                    right: "0",
                    bottom: "0",
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : []
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
//                    {
//                        name:'电',
//                        type:'line',
//                        stack: '总量',
//                        data:[]
//                    }
                ]
            };
            var pieOpt = {
                color: settings.colors,
                tooltip : {
                    trigger: 'top',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    data:[],
                    x : 'center',
                    y: "10px",
                },
                calculable : true,
                series : [
                    {
                        name:'费用占比',
                        type:'pie',
                        radius : [30, 110],
                        center : ['50%', '50%'],
                        roseType : 'area',
                        x: '50%',               // for funnel
                        max: 40,                // for funnel
                        sort : 'ascending',     // for funnel
                        data:[]
                    }
                ]
            };

            $scope.dailyChartDraw = function (data) {
                var opt = angular.copy(opts);

                // 生成x轴内容
                var fmt = "YYYY-MM-DD";
                var xlen = Math.ceil(moment(moment($scope.datas.toDate).format(fmt)).diff(moment($scope.datas.fromDate).format(fmt), 'days', true));
                var sd = [];
                for(var i=0; i<=xlen; i++) {
                    opt.xAxis[0].data.push(moment($scope.datas.fromDate).add('days', i).format(fmt));
                    sd.push(0);
                }

                for(var o in data.result.chartDatas) {
                    var d = data.result.chartDatas[o];
                    opt.legend.data.push(d.name);

                    d.datas.map(function (k) {
                        var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
                        sd[ind] = parseFloat(k.val).toFixed(4);
                    });

                    var tempSeries = {
                        name: d.name,
                        type: "bar",
                        stack: "总量",
                        data: sd
                    };
                    opt.series.push(tempSeries);
                }
                $scope.dailyChart.setOption(opt, true);
                $scope.dailyChart.resize();
                return data;
            };

            $scope.summaryChartDraw = function (data) {
                var opt = angular.copy(option);

                // 生成x轴内容
                var fmt = "YYYY-MM-DD";
                var xlen = Math.ceil(moment(moment($scope.datas.toDate).format(fmt)).diff(moment($scope.datas.fromDate).format(fmt), 'days', true));
                for(var i=0; i<=xlen; i++) {
                    opt.xAxis[0].data.push(moment($scope.datas.fromDate).add('days', i).format(fmt));
                }

                for(var o in data.result.chartDatas) {
                    var sd = [];
                    for(var i=0; i<=xlen; i++) {
                        sd.push(0);
                    }
                    var d = data.result.chartDatas[o];
                    opt.legend.data.push(d.name);

                    d.datas.map(function (k) {
                        var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
                        sd[ind] = parseFloat(k.val).toFixed(4);
                    });

                    var tempSeries = {
                        name: d.name,
                        type: "bar",
                        stack: "总量",
                        data: sd
                    };
                    opt.series.push(tempSeries);
                }
                console.log(opt);
                $scope.summaryChart.setOption(opt, true);
                $scope.summaryChart.resize();
                return data;
            };

            $scope.summaryPieDraw = function (data) {
                var opt = angular.copy(pieOpt);
                var d = [];
                for(var o in data.result.totalVal) {
                    var d = data.result.totalVal[o];
                    opt.legend.data.push(d.name);
                    opt.series[0].data.push({
                        value: parseFloat(d.val).toFixed(2),
                        name: d.name,
                    });
                }
                console.log(opt);
                $scope.summaryPieChart.setOption(opt, true);
                $scope.summaryPieChart.resize();
                return data;
            };

            $scope.summaryChartTable = function (data) {
                $scope.$apply(function () {
                    $scope.datas.summaryTableTitles = data.result.dailyList.title;
                    $scope.datas.summaryTableDatas = data.result.dailyList.data;
                });
                return data;
            };

            $scope.init_page();
        });

</script>
</body>
</html>