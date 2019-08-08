@extends('layouts.single')

@section('content')

    <div class="breadcrumb">
        <li><a href="/dashboard">首页</a></li>
        <li class="active">报警处理</li>
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">
            @include('layouts.errors')

            <div class="split-line" ng-click="ch_datas_on();"></div>

            <div class="box-left">
                <ul class="leftNav">
                    <li class="title">
                        <span>
                            <span class="glyphicon glyphicon-warning-sign"></span> 预警处理
                        </span>
                    </li>
                    <li class="active">
                        <a>
                            <span class="glyphicon glyphicon-triangle-right"></span> 所有预警
                        </a>
                        <ul class="subNav">
                            <li>
                                <a ng-click="pageJump('./summary?tp=1');">
                                    <span class="glyphicon glyphicon-menu-right"></span> 能耗计划预警
                                </a>
                            </li>
                            <li>
                                <a ng-click="pageJump('./summary?tp=1');">
                                    <span class="glyphicon glyphicon-menu-right"></span> 设备安全预警
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a ng-click="pageJump('./alertSettings');">
                            <span class="glyphicon glyphicon-menu-right"></span> 提醒设置
                        </a>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 所有类型报警 </span></li>
                    <li class="pull-right disabled form-inline">
                        查询条件:
                        {{--<select class="form-control mr10" ng-model="datas.query.type">--}}
                            {{--<option ng-repeat="t in datas.opts.types"--}}
                                    {{--ng-value="t.val"--}}
                                    {{--ng-bind="t.name"--}}
                                    {{--ng-selected="t.val == datas.query.type"></option>--}}
                        {{--</select>--}}
                        从:
                        <span class="c-datepicker-date-editor J-datepicker-range-day">
                            <input placeholder="开始日期" name="" class="c-datepicker-data-input only-date" ng-model="datas.fromDate">
                        </span>
                        到:
                        <span class="c-datepicker-date-editor J-datepicker-range-day mr10">
                            <input placeholder="结束日期" name="" class="c-datepicker-data-input only-date" ng-model="datas.toDate">
                        </span>
                        {{--同比数据:--}}
                        {{--<select class="form-control _compareTos" ng-model="datas.query.compareTo">--}}
                            {{--<option ng-repeat="t in datas.opts.compareTos"--}}
                                    {{--ng-value="t.val"--}}
                                    {{--ng-bind="t.name"--}}
                                    {{--ng-selected="t.val == datas.query.compareTo"></option>--}}
                        {{--</select>--}}
                        <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                    </li>
                </ul>
                <div class="nav-tabContents">

                    <div class="row warningSummaryPanel">
                        <div class="row">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-2" ng-repeat="w in datas.warningSummary">
                                <p class="t1">
                                    <em ng-bind="w.name">--</em>
                                </p>
                                <div class="clearFix"></div>
                                <p class="t2">
                                    <em>未处理: <span ng-bind="w.unDealNum" ng-class="w.unDealNum > 0 ? 'color' : ''"></span></em>
                                    <em>月能耗报警: <span ng-bind="w.monthNum" ng-class="v.monthNum <= 0 ? 'grey' : ''"></span></em>
                                    <em>总能耗报警: <span ng-bind="w.totalNum" ng-class="v.totalNum <= 0 ? 'grey' : ''"></span></em>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <p>&nbsp;</p>

                        <ul class="nav nav-tabs innertab">
                            <li ng-repeat="w in datas.warningSummary">
                                <span class="title"
                                      ng-class="$index==datas.selectMeterType ? 'active' : ''"
                                      ng-click="datas.selectMeterType = $index"
                                ><span ng-bind="w.name + '('+w.unDealNum+')'"></span></span>
                            </li>
                            <li class="pull-right disabled form-inline">
                                <span class="glyphicon glyphicon-time"></span>
                                <span ng-bind="datas.fromDate"></span> - <span ng-bind="datas.toDate"></span> 数据
                                <button class="btn btn-primary" style="visibility: hidden"><spam class="glyphicon glyphicon-refresh"></spam> </button>
                            </li>
                        </ul>
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

                selectMeterType : 0,

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
                $scope.init_datepicker($scope.datas.datePickerClassName);

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
@stop