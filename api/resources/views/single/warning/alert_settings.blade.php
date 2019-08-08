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
                    <li class="title"><span class="glyphicon glyphicon-earphone"></span> 预警处理</li>
                    <li>
                        <a ng-click="pageJump('./summary');">
                            <span class="glyphicon glyphicon-triangle-right"></span> 所有预警
                        </a>
                        <ul class="subNav">
                            <li>
                                <a><span class="glyphicon glyphicon-menu-right"></span> 能耗计划预警</a>
                            </li>
                            <li>
                                <a><span class="glyphicon glyphicon-menu-right"></span> 设备安全预警</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active">
                        <a>
                            <span class="glyphicon glyphicon-menu-right"></span> 提醒设置
                        </a>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 提醒设置 </span></li>
                </ul>
                <div class="nav-tabContents">

                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="name">名称</label>
                                    <input type="text" class="form-control" id="name" placeholder="管理员名称">
                                </div>
                                <div class="form-group">
                                    <label for="sendTo">发送</label>
                                    <input type="text" class="form-control" id="sendTo" placeholder="联系方式: 电话或邮箱">
                                </div>
                                <p></p>
                                <div class="form-group">
                                    <label for="from">最早</label>
                                    <input type="text" class="form-control" id="from" placeholder="最早时间">
                                </div>
                                <div class="form-group">
                                    <label for="to">最晚</label>
                                    <input type="text" class="form-control" id="to" placeholder="最晚时间">
                                </div>
                                <div class="form-group">
                                    <label for="span">间隔</label>
                                    <input type="number" class="form-control" id="span" placeholder="时间间隔">
                                </div>
                                <button type="button" class="btn btn-primary">添加</button>
                            </form>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>

                        <h3>
                            <span class="glyphicon glyphicon-earphone"></span>
                            <span ng-bind="datas.summaryData.building.name"></span> 所有提醒人员
                        </h3>
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
                $scope.init_datepicker($scope.datas.datePickerClassName);

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
@stop