@extends('layouts.single')

@section('content')

    <ul class="breadcrumb">
        <li ng-repeat="g in datas.guides"
            ng-class="$index == datas.guides.length-1 ? 'active' : ''">
            <a ng-click="pageJump(g.url)" ng-bind="g.name"></a>
        </li>
    </ul>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">
            @include('layouts.errors')

            <div class="split-line" ng-click="ch_datas_on();"></div>

            <div class="box-left">
                <ul class="leftNav">
                    <li class="title"><span class="glyphicon glyphicon-flash"></span> 电能监测</li>
                    <li class="active">
                        <a><span class="glyphicon glyphicon-star-empty"></span> 总用电概述</a>
                    </li>
                    <li ng-repeat="t in datas.types" ng-class="datas.dgt==t.id ? 'active' : ''">
                        <a ng-click="pageGoto(t.id);">
                            <span class="glyphicon glyphicon-menu-right"></span> <em ng-bind="'按'+t.name+'监测'"></em>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 总用电概况 </span></li>
                </ul>
                <div class="nav-tabContents">
                    <div class="row summaryPanel">
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="t1">
                                        <em ng-bind="datas.summaryData.totalName">--</em>
                                        <b ng-bind="datas.summaryData.total | number : 2" ng-class="compareClass(datas.summaryData.total, 'd');">--</b>
                                        <i ng-bind="datas.summaryData.totalUnit">--</i>
                                    </p>
                                    <p class="t2" ng-class="compareClass(datas.summaryData.totalCompareMonth, 't');">
                                        <em>环比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompareMonth, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompareMonth);">--</b>
                                    </p>
                                    <p class="t3" ng-class="compareClass(datas.summaryData.totalCompareYear, 't');">
                                        <em>2018年同比:</em>
                                        <span class="glyphicon" ng-class="compareClass(datas.summaryData.totalCompareYear, 'i');"></span>
                                        <b ng-bind="compareValue(datas.summaryData.totalCompareYear);">--</b>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-9">
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

                <div class="divider" style="margin:20px 0;"></div>

                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 按时间区间概况 </span></li>
                    <li class="pull-right disabled form-inline">
                        查询条件:
                        <select class="form-control mr10" ng-model="datas.query.type">
                            <option ng-repeat="t in datas.opts.types"
                                    ng-value="t.val"
                                    ng-bind="t.name"
                                    ng-selected="t.val == datas.query.type"></option>
                        </select>
                        从:
                        <span class="c-datepicker-date-editor J-datepicker-range-day">
                            <input placeholder="开始日期" name="" class="c-datepicker-data-input only-date" ng-model="datas.fromDate">
                        </span>
                        到:
                        <span class="c-datepicker-date-editor J-datepicker-range-day mr10">
                            <input placeholder="结束日期" name="" class="c-datepicker-data-input only-date" ng-model="datas.toDate">
                        </span>
                        同比数据:
                        <select class="form-control _compareTos" ng-model="datas.query.compareTo">
                            <option ng-repeat="t in datas.opts.compareTos"
                                    ng-value="t.val"
                                    ng-bind="t.name"
                                    ng-selected="t.val == datas.query.compareTo"></option>
                        </select>
                        <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                    </li>
                </ul>
                <div class="nav-tabContents">

                    <div>
                        <h3 class="pull-left">图表展示:</h3>
                        <div class="form-inline pull-right mb15">
                            <div class="form-group">
                                <label class="">国标值:</label>
                                <span class="form-control w100" style="border: none;" ng-bind="datas.summaryData.internationalValue"></span>
                            </div>
                            <div class="form-group">
                                <label class="">数据单位:</label>
                                <select class="form-control _summaryChartTypes" ng-model="datas.selectSummaryChartType" ng-change="chSummaryChartInput()">
                                    <option ng-repeat="(o,n) in datas.summaryChartTypes"
                                            ng-value="o"
                                            ng-bind="n"
                                            ng-selected="datas.selectSummaryChartType==o"
                                    ></option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="dailyChart" style="width:100%; height:360px;"></div>
                        <div id="summaryPieChart" class="pull-left" style="width:28%; height:400px; display: none;"></div>
                        <div id="summaryChart" class="pull-right" style="width:70%; height:400px; display: none;"></div>
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
            }).controller('pageCtrl', function($scope) {

            global.on_load_func($scope);

            var startYear = 2018;

            // 当前页面默认值
            let datas = {
                pageInited : false,

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

                summaryChartDatas: [
                    {
                        datas: [],
                        key: "date",
                        unit: "kwh",
                        name: "照明与插座",
                        val: "fee",
                    },
                    {
                        datas: [],
                        key: "date",
                        unit: "kwh",
                        name: "空调用电",
                        val: "fee",
                    },
                    {
                        datas: [],
                        key: "date",
                        unit: "kwh",
                        name: "动力用电",
                        val: "fee",
                    },
                    {
                        datas: [],
                        key: "date",
                        unit: "kwh",
                        name: "特殊用电",
                        val: "fee",
                    }
                ],

                summaryPieDatas: [
                    {
                        datas: "",
                        unit: "kwh",
                        name: "照明与插座",
                        val: "fee",
                    },
                    {
                        datas: "",
                        unit: "kwh",
                        name: "空调用电",
                        val: "fee",
                    },
                    {
                        datas: "",
                        unit: "kwh",
                        name: "动力用电",
                        val: "fee",
                    },
                    {
                        datas: "",
                        unit: "kwh",
                        name: "特殊用电",
                        val: "fee",
                    }
                ],

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
                    setTimeout(function(){
//                        $scope.summaryChart.resize();
//                        $scope.summaryPieChart.resize();
                        $scope.dailyChart.resize();
                    }, 500);
                });
            };

            $scope.init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope, function () {
                    setTimeout(function(){
//                        $scope.summaryChart.resize();
//                        $scope.summaryPieChart.resize();
                        $scope.dailyChart.resize();
                    }, 500);
                });
                global.init_compareto($scope);
                $scope.init_datepicker($scope.datas.datePickerClassName);

                $scope.datas.query.type = $scope.datas.opts.types[1].val;
                $scope.datas.query.compareTo = $scope.datas.opts.compareTos[0].val;

                console.log("init_page");
//                $scope.summaryChart = echarts.init(document.getElementById("summaryChart"));
//                $scope.summaryPieChart = echarts.init(document.getElementById("summaryPieChart"));
                $scope.dailyChart = echarts.init(document.getElementById("dailyChart"));
                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                $scope.datas.fromDate = $($scope.datas.datePickerClassName).find("input").eq(0).val();
                $scope.datas.toDate = $($scope.datas.datePickerClassName).find("input").eq(1).val();
                $scope.getDatas();
            }

            $scope.pageGoto = function(dgt) {
                window.location.href = "../monitor/ammeterByType?dgt="+dgt;
            }
            $scope.pageJump = function(url) {
                if(url != "") {
                    window.location.href = url;
                }
            }

            $scope.getDatas = function () {
                $scope.ajaxAmmeterSummary()
                    .then($scope.initBaseDatas)
                    .then($scope.summaryDatas)
                    .then($scope.dailyChartDraw)
                    .then($scope.summaryChartTable)
                    .catch($scope.ajaxCatch);
            };
            $scope.ajaxAmmeterSummary = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/monitor/ajaxAmmeterSummary",
                    _param: {
                        from : $scope.datas.fromDate,
                        to: $scope.datas.toDate,
                        type: $scope.datas.query.type,
                        compareTo: $scope.datas.query.compareTo,
                    }
                };
                return global.return_promise($scope, param);
            }
            $scope.initBaseDatas = function (data) {
                $scope.datas.cacheData = data;
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

            $scope.summaryDatas = function (data) {
                $scope.$apply(function () {
                    $scope.datas.summaryData = data.result.summaryData;
                })
                return data;
            }

            var option = {
                color: settings.colors,
                tooltip : {
                    trigger: 'axis'
                },
                calculable : true,
                legend: { data:[] },
                xAxis : [
                    {
                        type : 'category',
                        data: [],
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
//                        type:'bar',
//                        stack: '总量',
//                        data:[],
//                    },
                ]
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
                        boundaryGap : false,
                        data : ['01','02','03','04','05','06','07','08','09','10',
                            '11','12','13','14','15','16','17','18','19','20',
                            '21','22','23','24']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'照明与插座',
                        type:'line',
                        stack: '总量',
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data:[]
                    },
                    {
                        name:'空调用电',
                        type:'line',
                        stack: '总量',
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data:[]
                    },
                    {
                        name:'动力用电',
                        type:'line',
                        stack: '总量',
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data:[]
                    },
                    {
                        name:'特殊用电',
                        type:'line',
                        stack: '总量',
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data:[]
                    }
                ]
            };
            var pieOpt = {
                color: settings.colors,
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    x : 'center',
                    data:[]
                },
                calculable : true,
                series : [
                    {
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
                var opt = angular.copy(option);

                // 生成x轴内容
                var fmt = "YYYY-MM-DD";
                if($scope.datas.query.type == "hour") { fmt = "DD-HH" }
                else if($scope.datas.query.type == "day") { fmt = "YYYY-MM-DD" }
                else if($scope.datas.query.type == "month") { fmt = "YYYY-MM" }
                else if($scope.datas.query.type == "year") { fmt = "YYYY" }
                var xlen = Math.ceil(moment(moment($scope.datas.toDate).format(fmt)).diff(moment($scope.datas.fromDate).format(fmt), $scope.datas.query.type, true));
                var sd = [], sd2 = [], sd3 = [];
                for(var i=0; i<=xlen; i++) {
                    opt.xAxis[0].data.push(moment($scope.datas.fromDate).add($scope.datas.query.type, i).format(fmt));
                    sd.push(0);
                    sd2.push(0);
                    sd3.push($scope.datas.summaryData.internationalValue);
                }

                var r = 1;
                var ds = data.result.chartDatas;
                if($scope.datas.selectSummaryChartType == 0) { r = 1; }
                else if ($scope.datas.selectSummaryChartType == 1) { r = 1 / ds.area; }
                else if ($scope.datas.selectSummaryChartType == 2) { r = ds.coal; }
                else if ($scope.datas.selectSummaryChartType == 3) { r = ds.co2; }
                else if ($scope.datas.selectSummaryChartType == 4) { r = ds.fee_policy; }
                // 生成当前柱状图数据
                opt.legend.data[0] = $scope.datas.summaryChartTypes[$scope.datas.selectSummaryChartType];
                ds.datas.map(function (k) {
                    var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
                    sd[ind] = parseFloat(k.val * r).toFixed(4);
                });
                opt.series[0] = {
                    name: opt.legend.data[0],
                    type:'bar',
                    data: sd,
                };

                // 生成对比折现图数据
                opt.legend.data[1] = $("._compareTos option:selected").text();
                var ds2 = data.result.chartCompareDatas;
                ds2.datas.map(function (k) {
                    var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
                    sd2[ind] = parseFloat(k.val * r).toFixed(4);
                });
                opt.series[1] = {
                    name: opt.legend.data[1],
                    type:'line',
                    data: sd2,
                };

                // 生成国际值数据
                opt.legend.data[2] = "国际值";
                ds2.datas.map(function (k) {
                    var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
                    sd2[ind] = parseFloat(k.val * r).toFixed(4);
                });
                opt.series[2] = {
                    name: opt.legend.data[2],
                    type:'line',
                    symbol: 'none',
                    data: sd3,
                };

                console.log(JSON.stringify(opt));
                $scope.dailyChart.setOption(opt, true);
                $scope.dailyChart.resize();
                return data;
            };

            $scope.summaryChartDraw = function () {
                // 初始化随机数据, php 生成的原始数据样式
                for(var i=0; i<$scope.datas.summaryChartDatas.length; i++) {
                    var d = [];
                    for(var j=0; j<12; j++) {
                        d.push({ "val": (Math.random()*700 + 1200 - i*300).toFixed(2), "key": moment($scope.datas.startYear).add("month", j).format("YYYY-MM")});
                    }
                    $scope.datas.summaryChartDatas[i].datas = d;
                }

                // 将原始数据画成图表
                var opt = angular.copy(option);
                var legend_data = [];
                for(var i =0; i<$scope.datas.summaryChartDatas.length; i++) {
                    legend_data.push($scope.datas.summaryChartDatas[i]["name"]);
                    var tempSeries = {
                        name: $scope.datas.summaryChartDatas[i]["name"],
                        type:'bar',
                        stack: '总量',
                        data: fmtEChartData($scope.datas.summaryChartDatas[i]),
                    }
                    opt.series.push(tempSeries);
                }
                opt.legend.data = legend_data;
                // 生成12个月的分组
                for(var i=0; i<12; i++) {
                    opt.xAxis[0].data.push(moment($scope.datas.startYear).add("month", i).format("YYYY-MM"));
                }
                console.log(opt);
                global.drawEChart($scope.summaryChart, opt);

                function fmtEChartData (data){
                    var tmpSeriesData = [];
                    data.datas.map(function (p) {
                        tmpSeriesData.push((p.val == "" ? 0 : parseFloat(p.val)))
                    });
                    return tmpSeriesData;
                }
            };

            $scope.summaryPieDraw = function () {
                // 初始化随机数据, php 生成的原始数据样式
                for(var i=0; i<$scope.datas.summaryPieDatas.length; i++) {
                    $scope.datas.summaryPieDatas[i].datas = (Math.random()*700 + 1200 - i*300).toFixed(2);
                }

                // 将原始数据画成图表
                var opt = angular.copy(pieOpt);
                var legend_data = [];
                var ds = [];
                for(var i =0; i<$scope.datas.summaryPieDatas.length; i++) {
                    legend_data.push($scope.datas.summaryPieDatas[i]["name"]);
                    ds.push({"value": $scope.datas.summaryPieDatas[i]["datas"], "name": $scope.datas.summaryPieDatas[i]["name"]});
                }
                opt.legend.data = legend_data;
                opt.series[0].name = "用电占比";
                opt.series[0].data = ds;
                console.log(opt);
                global.drawEChart($scope.summaryPieChart, opt);
            };

            $scope.chSummaryChartInput = function () {
                if(typeof $scope.datas.selectSummaryChartType == "undefined") {
                    $scope.datas.selectSummaryChartType = 0;
                }
                $scope.dailyChartDraw($scope.datas.cacheData);
            }

            $scope.summaryChartTable = function (data) {
                $scope.$apply(function () {
                    $scope.datas.summaryTableTitles = ["日期", "总用电量(kwh)", "当量标煤(吨)", "碳排放量(吨)", "能耗密度(kwh/m2)", "费用(元)"];
                    $scope.datas.summaryTableDatas = {};

                    var fmt = "YYYY-MM-DD";
                    if($scope.datas.query.type == "hour") { fmt = "DD-HH" }
                    else if($scope.datas.query.type == "day") { fmt = "YYYY-MM-DD" }
                    else if($scope.datas.query.type == "month") { fmt = "YYYY-MM" }
                    else if($scope.datas.query.type == "year") { fmt = "YYYY" }
                    var xlen = Math.ceil(moment(moment($scope.datas.toDate).format(fmt)).diff(moment($scope.datas.fromDate).format(fmt), $scope.datas.query.type, true));
                    var sd = [], sd2 = [];
                    for(var i=0; i<=xlen; i++) {
                        var k = moment($scope.datas.fromDate).add($scope.datas.query.type, i).format(fmt);
                        $scope.datas.summaryTableDatas[k] = [k, 0, 0, 0, 0, 0];
                    }
                    data.result.chartDatas.datas.map(function (d) {
                        $scope.datas.summaryTableDatas[d.key][1] = parseFloat(d.val).toFixed(4); // 总用电量(kwh)
                        $scope.datas.summaryTableDatas[d.key][2] = parseFloat(d.val * data.result.chartDatas.coal).toFixed(4) ;  // 当量标煤(吨)
                        $scope.datas.summaryTableDatas[d.key][3] = parseFloat(d.val * data.result.chartDatas.co2).toFixed(4) ;  // 碳排放量(吨)
                        $scope.datas.summaryTableDatas[d.key][4] = parseFloat(d.val / data.result.chartDatas.area).toFixed(4) ;  // 能耗密度(kwh/m2)
                        $scope.datas.summaryTableDatas[d.key][5] = parseFloat(d.val * data.result.chartDatas.fee_policy).toFixed(4) ;  // 费用(元)
                    });
                    console.log($scope.datas.summaryTableDatas);
                });
                return data;
            };

            $scope.init_page();
        });

    </script>
@stop

