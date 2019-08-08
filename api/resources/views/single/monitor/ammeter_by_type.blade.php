@extends('layouts.single')

@section('content')

    <div>
        <ul class="breadcrumb">
            <li ng-repeat="g in datas.guides"
                ng-class="$index == datas.guides.length-1 ? 'active' : ''">
                <a ng-click="pageJump(g.url)" ng-bind="g.name"></a>
            </li>
        </ul>
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">
            @include('layouts.errors')

            <div class="split-line" ng-click="ch_datas_on();"></div>

            <div class="box-left">
                <ul class="leftNav">
                    <li class="title"><span class="glyphicon glyphicon-fire"></span> 电能监测</li>
                    <li><a href="../monitor/ammeter"><span class="glyphicon glyphicon-star-empty"></span> 总用电概述</a></li>
                    <li ng-repeat="t in datas.types" ng-class="datas.dgt==t.id ? 'active' : ''">
                        <a ng-click="pageGoto(t.id);">
                            <span class="glyphicon"
                                ng-class="datas.dgt==t.id ? 'glyphicon-triangle-right' : 'glyphicon-menu-right'"></span> <em ng-bind="'按'+t.name+'监测'"></em>
                        </a>
                        <ul class="subNav" ng-if="datas.dgt==t.id">
                            <li ng-repeat="g in datas.typeGroups"
                                ng-if="g.group_type==t.id && g.parent_id==0"
                                ng-class="datas.pid==g.id ? 'active' : ''">
                                <a ng-click="pageGoto(t.id, g.id);">
                                    <span class="glyphicon"
                                          ng-class="datas.pid==g.id ? 'glyphicon glyphicon-triangle-right' : 'glyphicon-menu-right'"></span> <em ng-bind="g.name"></em>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li>
                        <span class="title">
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span ng-bind="datas.pid == 0 ? datas.currentType.name : datas.currentTypeGroup.name"></span>
                        </span>
                    </li>
                    <li class="pull-right disabled">
                        <span>
                            <b>选择日期:  </b>
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
                                <span class="form-control w100" style="border:none ;" ng-bind="datas.summaryData.internationalValue"></span>
                                {{--<input class="form-control w100" ng-model="datas.summaryData.internationalValue" ng-change="chSummaryChartInput()">--}}
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
                        <div class="clearfix"></div>

                        <div id="summaryPieChart" style="float:left; width:30%; height:400px;"></div>
                        <div id="dailyChart" style="float:left; width:70%; height:400px;"></div>

                        <div class="clearfix"></div>

                    </div>

                    <div class="divider"></div>

                    <div>
                        <h3>
                            <span class="glyphicon glyphicon-time"></span>
                            <span ng-bind="datas.fromDate"></span> - <span ng-bind="datas.toDate"></span> 数据
                        </h3>
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

                </div>

            </div>

        </div>
    </div>

    <script type="application/javascript">
        angular.module("app",[])
            .config(function($interpolateProvider) {
                $interpolateProvider.startSymbol('{[{');
                $interpolateProvider.endSymbol('}]}');
            }).controller('pageCtrl', ['$scope', function($scope) {

            global.on_load_func($scope);

            // 当前页面默认值
            let datas = {
                pageInited : false,

                leftOn: true,
                datePickerClassName: ".J-datepicker-range-day",
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
                $scope.init_datepicker($scope.datas.datePickerClassName);
                console.log("init_page");
                $scope.dailyChart = echarts.init(document.getElementById("dailyChart"));
                $scope.summaryPieChart = echarts.init(document.getElementById("summaryPieChart"));
                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                $scope.datas.fromDate = $($scope.datas.datePickerClassName).find("input").eq(0).val();
                $scope.datas.toDate = $($scope.datas.datePickerClassName).find("input").eq(1).val();
                $scope.getDatas();
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
@stop
