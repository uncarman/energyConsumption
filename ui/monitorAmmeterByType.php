
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
        总用电概述
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="monitor.php"><i class="fa fa-files-o"></i> 总体用能概述</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> 总用电概述</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li><a href="monitorAmmeter.php">总用电概述</a></li>
          <li <?php if($_GET['type']==1 || empty($_GET['type'])) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=1">按能耗分项监测</a></li>
          <li <?php if($_GET['type']==2) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=2">按建筑区域监测</a></li>
          <li <?php if($_GET['type']==3) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=3">按组织机构监测</a></li>
          <li <?php if($_GET['type']==4) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=4">按自定义分类监测</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
<?php
                  if($_GET['type']==1) {
?>
                  <li <?php if($_GET['ctype']==1 || empty($_GET['ctype'])) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=1&ctype=1">照明与插座</a></li>
                  <li <?php if($_GET['ctype']==2) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=1&ctype=2">空调用电</a></li>
                  <li <?php if($_GET['ctype']==3) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=1&ctype=3">动力用电</a></li>
                  <li <?php if($_GET['ctype']==4) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=1&ctype=4">特殊用电</a></li>
<?php
                  } else if($_GET['type']==2) {
?>
                  <li <?php if($_GET['ctype']==1 || empty($_GET['ctype'])) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=2&ctype=1">出租楼层</a></li>
                  <li <?php if($_GET['ctype']==2) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=2&ctype=2">自用楼层</a></li>
<?php
                  } else if($_GET['type']==3) {
?>
                  <li <?php if($_GET['ctype']==1 || empty($_GET['ctype'])) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=1&ctype=1">商场</a></li>
                  <li <?php if($_GET['ctype']==2) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=3&ctype=2">地下车库</a></li>
                  <li <?php if($_GET['ctype']==2) { echo 'class="active"'; } ?>><a href="monitorAmmeterByType.php?type=3&ctype=2">办公楼层</a></li>
<?php
                  } else {
                  }
?>
                  <li class="pull-right disabled form-inline">
                    <input type="text" class="form-control mr10" id="reservation">
                    <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="type1_1">
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
                                <div id="dailyChart" style="height:400px;"></div></div>
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
                  <div class="tab-pane" id="type1_2">

                  </div>
                  <div class="tab-pane" id="type1_2">

                  </div>
                  <div class="tab-pane" id="type1_3">

                  </div>
          </div>
        </div>
        <!-- /.tab-content -->
      </div>

      <div class="clearfixed"></div>
    </section>
    <!-- /.content -->
  </div>
    
  <?php include"layout/footer.php" ?>

</div>
<!-- ./wrapper -->

<style type="text/css">
.info-box-number { font-size: 24px; }
.info-box-content { margin-left:0px; }  
.info-box .progress { height: 1px; }
</style>


<?php include"layout/end.php" ?>
<script src="./static/plugins/echart/echarts.js"></script>
<script src="./static/plugins/moment/moment-with-locales.min.js"></script>

<script>
        angular.module("app",[])
            .config(function($interpolateProvider) {
                $interpolateProvider.startSymbol('{[{');
                $interpolateProvider.endSymbol('}]}');
            }).controller('pageCtrl', ['$scope', function($scope) {

            global.on_load_func($scope);

            // 当前页面默认值
            let datas = {
                pageInited : false,

                fmt: "YYYY-MM-DD",
                leftOn: true,
                datePickerDom: "#reservation",
                fromDate: moment().add(-7, 'day').format("YYYY-MM-DD"),
                toDate: moment().format("YYYY-MM-DD"),

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
                    }
                ],

                dgt: global.request("dgt"),
                pid: global.request("pid") || 0,

                summaryChartTypes: [
                    "能耗密度kwh/m2",
                    "能耗kwh",
                ],

                summaryData: {
                    internationalValue: 0.15,  // 国际能耗
                },

                summaryTableTitles: [],
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
                global.init_left($scope, function () {
                    setTimeout(function () {
                        //$scope.summaryChart.resize();
                        $scope.summaryPieChart.resize();
                        $scope.dailyChart.resize();
                    }, 500);
                });
            }

            $scope.init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope, function () {
                    setTimeout(function(){
                        //$scope.summaryChart.resize();
                        $scope.summaryPieChart.resize();
                        $scope.dailyChart.resize();
                    }, 500);
                });
                //$scope.init_datepicker($scope.datas.datePickerClassName);
                console.log("init_page");
                $scope.dailyChart = echarts.init(document.getElementById("dailyChart"));
                $scope.summaryPieChart = echarts.init(document.getElementById("summaryPieChart"));
                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                //$scope.datas.fromDate = $($scope.datas.datePickerClassName).find("input").eq(0).val();
                //$scope.datas.toDate = $($scope.datas.datePickerClassName).find("input").eq(1).val();
                //$scope.getDatas();
            }

            $scope.pageJump = function(url) {
                if(url != "") {
                    window.location.href = url;
                }
            }
            $scope.pageGoto = function(dgt, pid) {
                if(typeof pid == "undefined") {
                    pid = 0;
                }
                if($scope.datas.dgt != dgt || $scope.datas.pid != pid) {
                    window.location.href = "../monitor/ammeterByType?pid="+pid+"&dgt="+dgt;
                }
            }

            $scope.getDatas = function () {
                $scope.ajaxAmmeterGroupsSummaryDailyByType()
                    .then($scope.initBaseDatas)
                    .then($scope.dailyChartDraw)
                    .then($scope.summaryPieDraw)
                    .then($scope.summaryChartTable)
                    .catch($scope.ajax_catch);
            };
            $scope.ajaxAmmeterGroupsSummaryDailyByType = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/monitor/ajaxAmmeterGroupsSummaryDaily/" + $scope.datas.dgt,
                    _param: {
                        from : $scope.datas.fromDate,
                        to: $scope.datas.toDate,
                        pid: $scope.datas.pid,
                    }
                };
                return global.return_promise($scope, param);
            }

            $scope.initBaseDatas = function (data) {
                if(!$scope.datas.pageInited) {
                    $scope.$apply(function () {
                        $scope.datas.pageInited = true;
                        $scope.datas.guides[0].name = data.result.building.name;
                        $scope.datas.types = data.result.types;
                        $scope.datas.typeGroups = data.result.typeGroups;
                        $scope.datas.types.map(function (t) {
                            if(t.id == $scope.datas.dgt) {
                                $scope.datas.currentType = t;
                                $scope.datas.guides.push({
                                    "href": "../monitor/ammeterByType?dgt="+t.id,
                                    "name" : t.name,
                                })
                            }
                        });
                        $scope.datas.typeGroups.map(function (t) {
                            if(t.group_type == $scope.datas.dgt && t.id == $scope.datas.pid) {
                                $scope.datas.currentTypeGroup = t;
                                $scope.datas.guides.push({
                                    "href": "",
                                    "name" : t.name,
                                })
                            }
                        });
                    });
                }
                return data;
            };

            var opts = {
                color: settings.colors,
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:[]
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data:[]
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
//                    {
//                        name:'照明与插座',
//                        type:'line',
//                        stack: '总量',
//                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
//                        data:[]
//                    },
                ]
            };
            $scope.dailyChartDraw = function (data) {
                console.log(data);
                var opt = angular.copy(opts);
                for(var i=0; i<=moment(data.result.to).diff(moment(data.result.from), "days"); i++) {
                    opt.xAxis[0].data.push(moment(data.result.from).add(i, "day").format("YYYY-MM-DD"));
                }
                var legend_data = [];
                var tmp_sub_data = {};
                // 生成处理函数
                var func = null;
                if($scope.datas.selectSummaryChartType == 1) {
                    func = function(a) {
                        return parseFloat(a).toFixed(4);
                    }
                } else {
                    func = function(a, b) {
                        try {
                            return (a / b).toFixed(4);
                        } catch (e) {
                            return a;
                        }
                    }
                }

                data.result["dailyDatas"].map(function (d) {
                    legend_data.push(d["name"]);
                    var tmpSeries = {
                        name: d["name"],
                        type:'line',
                        //stack: '总量',
                        //itemStyle: {normal: {lineStyle: {type: 'default'}}},
                        data: fmtEChartData(opt.xAxis[0].data, d, func),
                    };
                    opt.series.push(tmpSeries);
                    tmp_sub_data[d["gid"]] = d["name"];
                });
                // 添加国际值线
                legend_data.push("国际值");
                opt.series.push({
                    name: "国际值",
                    type: "line",
                    symbol: 'none',
                    itemStyle: {normal: {lineStyle: {type: 'dotted'}}},
                    data: fmtEChartData(opt.xAxis[0].data, {datas: []}, undefined, $scope.datas.summaryData.internationalValue),
                    z: 100,  // 显示在最顶层
                });
                opt.legend.data = legend_data;
                $scope.datas.subTypes = tmp_sub_data;
                console.log(opt);
                global.drawEChart($scope.dailyChart, opt);
                return data;
            };
            function fmtEChartData (categroys, data, func, defaultVal) {
                if(typeof defaultVal == "undefined") { defaultVal = 0; }
                if(typeof func == "undefined") { func = function(a){ return a.val; } };
                var tmpSeriesData = [];
                for (var i in categroys) {
                    tmpSeriesData[i] = defaultVal;
                    for (var j in data.datas) {
                        if (data.datas[j].key == categroys[i]) {
                            tmpSeriesData[i] = func(data.datas[j].val, data.prop_area);
                            break;
                        }
                    }
                }
                return tmpSeriesData;
            }

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
                        name:'占比',
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
            $scope.summaryPieDraw = function (data) {
                var opt = angular.copy(pieOpt);
                var legend_data = [];
                data.result["dailyDatas"].map(function (d) {
                    opt.legend.data.push(d["name"]);
                    var data = 0;
                    for(var i=0; i< d.datas.length; i++) {
                        data += parseFloat(d.datas[i].val);
                    }
                    opt.series[0].data.push({
                        value: data.toFixed(2),
                        name: d["name"]
                    });
                });
                console.log(opt);
                $scope.summaryPieChart.setOption(opt, true);
                $scope.summaryPieChart.resize();
                return data;
            };

            $scope.chSummaryChartInput = function () {
                if(typeof $scope.datas.selectSummaryChartType == "undefined") {
                    $scope.datas.selectSummaryChartType = 0;
                }
                $scope.dailyChartDraw($scope.datas.cacheData);
            }

            $scope.summaryChartTable = function (data) {
                $scope.datas.summaryTableTitles = ["日期"];
                $scope.datas.summaryTableDatas = {};

                for(var i=0; i<=moment(data.result.to).diff(moment(data.result.from), "days"); i++) {
                    var k = moment(data.result.from).add(i, "day").format("YYYY-MM-DD");
                    $scope.datas.summaryTableDatas[k] = [k];
                }

                data.result["dailyDatas"].map(function (d) {
                    $scope.datas.summaryTableTitles.push(d["name"]);
                    $scope.datas.summaryTableTitles.push(d["name"]+"密度");
                    var ind = $scope.datas.summaryTableTitles.indexOf(d["name"]);
                    for(var o in $scope.datas.summaryTableDatas) {
                        $scope.datas.summaryTableDatas[o].push(0);
                        $scope.datas.summaryTableDatas[o].push(0);
                    }
                    for(var i in d.datas) {
                        $scope.datas.summaryTableDatas[d.datas[i].key][ind] = parseFloat(d.datas[i].val).toFixed(4);
                        $scope.datas.summaryTableDatas[d.datas[i].key][ind+1] = (d.datas[i].val/d.prop_area).toFixed(4);
                    }
                });
                console.log($scope.datas.summaryTableTitles);
                console.log($scope.datas.summaryTableDatas);
                $scope.$apply(function () {
                    $scope.datas.summaryTableTitles = $scope.datas.summaryTableTitles;
                    $scope.datas.summaryTableDatas = $scope.datas.summaryTableDatas;
                });

                $scope.datas.cacheData = data;
            };

            $scope.init_page();
        }]);

</script>

</body>
</html>