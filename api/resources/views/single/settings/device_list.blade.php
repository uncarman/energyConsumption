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
                    <li class="title"><span class="glyphicon glyphicon-flash"></span> 系统设置</li>
                    <li class="active">
                        <a><span class="glyphicon glyphicon-star-empty"></span> 设备管理</a>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 设备管理 </span></li>
                </ul>
                <div class="nav-tabContents">
                    <h3>
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <span ng-bind="datas.summaryData.building.name"></span> 所有设备
                    </h3>



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
                                        {{--<button class="btn btn-success btn-xs" ng-click="update_item(v, 1);">展开</button>--}}
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
@stop
