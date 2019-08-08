@extends('layouts.single')

@section('content')

    <div class="breadcrumb">
        <li><a href="/dashboard">首页</a></li>
        <li>数据统计</li>
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">
            @include('layouts.errors')

            <div class="split-line" ng-click="ch_datas_on();"></div>

            <div class="box-left">
                <ul class="leftNav">
                    <li class="title"><span class="glyphicon glyphicon-calendar"></span> 数据统计</li>
                    <li class="active"><a><span class="glyphicon glyphicon-star"></span> 总体能耗统计</a></li>
                    <li><a ng-click="pageJump('../statistics/summaryFee');"><span class="glyphicon glyphicon-star"></span> 总体费用分析</a></li>
                </ul>
            </div>

            <div class="box-right">

                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 总能耗统计 </span></li>
                </ul>
                <div class="nav-tabContents">
                    <div class="row summaryPanel">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-3">
                                    <p class="t1">
                                        <em ng-bind="datas.summaryData.total1Name">--</em>
                                        <b ng-bind="datas.summaryData.total1 | number : 2" ng-class="compareClass(datas.summaryData.total1, 'd');">--</b>
                                        <i ng-bind="datas.summaryData.total1Unit">--</i>
                                    </p>
                                    <p class="t2" ng-class="compareClass(datas.summaryData.totalCompare1Month, 't');">
                                        <em>环比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare1Month, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare1Month);">--</b>
                                    </p>
                                    <p class="t3" ng-class="compareClass(datas.summaryData.totalCompare1Year, 't');">
                                        <em>2018年同比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare1Year, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare1Year);">--</b>
                                    </p>
                                </div>
                                <div class="col-xs-3">
                                    <p class="t1">
                                        <em ng-bind="datas.summaryData.total2Name">--</em>
                                        <b ng-bind="datas.summaryData.total2 | number : 2" ng-class="compareClass(datas.summaryData.total2, 'd');">--</b>
                                        <i ng-bind="datas.summaryData.total2Unit">--</i>
                                    </p>
                                    <p class="t2" ng-class="compareClass(datas.summaryData.totalCompare2Month, 't');">
                                        <em>环比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare2Month, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare2Month);">--</b>
                                    </p>
                                    <p class="t3" ng-class="compareClass(datas.summaryData.totalCompare2Year, 't');">
                                        <em>2018年同比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare2Year, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare2Year);">--</b>
                                    </p>
                                </div>
                                <div class="col-xs-3">
                                    <p class="t1">
                                        <em ng-bind="datas.summaryData.total3Name">--</em>
                                        <b ng-bind="datas.summaryData.total3 | number : 2" ng-class="compareClass(datas.summaryData.total3, 'd');">--</b>
                                        <i ng-bind="datas.summaryData.total3Unit">--</i>
                                    </p>
                                    <p class="t2" ng-class="compareClass(datas.summaryData.totalCompare3Month, 't');">
                                        <em>环比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare3Month, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare3Month);">--</b>
                                    </p>
                                    <p class="t3" ng-class="compareClass(datas.summaryData.totalCompare3Year, 't');">
                                        <em>2018年同比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare3Year, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare3Year);">--</b>
                                    </p>
                                </div>
                                <div class="col-xs-3">
                                    <p class="t1">
                                        <em ng-bind="datas.summaryData.total4Name">--</em>
                                        <b class="color" ng-bind="datas.summaryData.total4 | number : 2" ng-class="compareClass(datas.summaryData.total4, 'd');">--</b>
                                        <i ng-bind="datas.summaryData.total4Unit">--</i>
                                    </p>
                                    <p class="t2" ng-class="compareClass(datas.summaryData.totalCompare4Month, 't');">
                                        <em>环比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare4Month, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare4Month);">--</b>
                                    </p>
                                    <p class="t3" ng-class="compareClass(datas.summaryData.totalCompare4Year, 't');">
                                        <em>2018年同比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompare4Year, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompare4Year);">--</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider" style="margin: 20px 0;"></div>

                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 按时间区间概况 </span></li>
                    <li class="pull-right disabled">
                        <span>
                            <b>选择日期: &nbsp; </b>
                            <span class="c-datepicker-date-editor J-datepicker-range-day">
                                <i class="c-datepicker-range__icon kxiconfont icon-clock"></i>
                                <input placeholder="开始日期" name="" class="c-datepicker-data-input only-date" ng-model="datas.fromDate">
                                <span class="c-datepicker-range-separator">-</span>
                                <input placeholder="结束日期" name="" class="c-datepicker-data-input only-date" ng-model="datas.toDate">
                            </span>
                            <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                        </span>
                    </li>
                </ul>
                <div class="nav-tabContents">
                    <div>
                        <h3 class="pull-left">图表展示:</h3>
                        <div class="form-inline pull-right mb15">
                            <div class="form-group">
                                <label class="">国标值:</label>
                                <input class="form-control w100" value="0.15">
                            </div>
                            <div class="form-group">
                                <label class="">数据单位:</label>
                                <select class="form-control">
                                    <option>能耗密度KWh/m2</option>
                                    <option>能耗KWh</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="dailyChart" style="width:100%; height:360px; display: none;"></div>
                        <div id="summaryPieChart" class="pull-left" style="width:28%; height:400px;"></div>
                        <div id="summaryChart" class="pull-right" style="width:70%; height:400px;"></div>
                        <div class="clearfix"></div>

                    </div>

                    <div class="divider"></div>

                    <div>
                        <h3>
                            <span class="glyphicon glyphicon-time"></span>
                            <span ng-bind="datas.fromDate"></span> - <span ng-bind="datas.toDate"></span> 数据
                        </h3>
                        <table class="table table-bordered table-hover" style="margin-bottom: 5px;">
                            <thead>
                            <tr>
                                <th ng-repeat="(k,n) in datas.dailyList.title" ng-bind="n"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="v in datas.dailyList.data">
                                <td ng-repeat="(k,n) in datas.dailyList.title"
                                    ng-bind="v[k]"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script type="application/javascript">
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
                leftOn: true,
                datePickerClassName: ".J-datepicker-range-day",
                fromDate: moment().add(-7, 'day').format("YYYY-MM-DD"),
                toDate: moment().format("YYYY-MM-DD"),

            };
            $.extend(datas, settings.default_datas);
            $scope.datas = datas;

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
                $scope.init_datepicker($scope.datas.datePickerClassName);
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
                    $scope.datas.dailyList = data.result.dailyList;
                });
                return data;
            };

            $scope.init_page();
        });

    </script>
@stop

