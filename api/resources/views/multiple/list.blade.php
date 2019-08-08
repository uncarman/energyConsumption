@extends('layouts.multiple')

@section('content')

    <div class="breadcrumb">
        <li><a href="/dashboard">首页</a></li>
        <li class="active">列表</li>
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">
            @include('layouts.errors')

            <ul class="nav nav-tabs tftab">
                <li><span class="title"><span class="glyphicon glyphicon-th-list"></span> 列表 </span></li>
            </ul>
            <div class="nav-tabContents">

                <table class="table table-bordered table-hover" style="margin-bottom: 0px;">
                    <thead>
                    <tr>
                        <th ng-repeat="(k,n) in datas.buildingList.title" ng-bind="n"></th>
                        <th style="width: 100px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="v in datas.buildingList.data">
                        <td ng-repeat="(k,n) in datas.buildingList.title">
                            <span ng-bind="v[k]" ng-if="k!='photo'"></span>
                            <img ng-src="{[{v.photo}]}" ng-if="k=='photo'" width="120">
                        </td>
                        <td>
                            {{--<button class="btn btn-success btn-xs" ng-click="update_item(v, 1);">展开</button>--}}
                            <button class="btn btn-primary btn-xs" ng-click="view_item(v);">查看</button>
                            {{--<button class="btn btn-default btn-xs" ng-click="update_item(v, 2);">删除</button>--}}
                        </td>
                    </tr>
                    </tbody>
                </table>

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
                        .then($scope.buildingListTable)
                        .catch($scope.ajaxCatch);
                };

                $scope.ajaxDeviceList = function () {
                    var param = {
                        _method: 'get',
                        _url: "/ajaxBuildingList",
                        _param: {}
                    };
                    return global.return_promise($scope, param);
                }
                $scope.buildingListTable = function (data) {
                    $scope.$apply(function () {
                        $scope.datas.buildingList = data.result.buildingList;
                    });
                };


                $scope.view_item = function (item) {
                    window.location.href = "/"+item.id+"/monitor/summary";
                }

                $scope.init_page();
            });

        </script>
@stop


