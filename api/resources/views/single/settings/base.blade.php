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
                    <li class="title"><span class="glyphicon glyphicon-flash"></span> 基础设置</li>
                    <li class="active">
                        <a><span class="glyphicon glyphicon-star-empty"></span> 基础配置</a>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 所有配置 </span></li>
                </ul>
                <div class="nav-tabContents">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3><span ng-bind="datas.summaryData.building.name"></span> 全局配置</h3>
                        </div>
                        <div class="col-xs-6">
                            <button class="btn btn-primary pull-right">编辑</button>
                        </div>
                    </div>

                    <div class="form-horizontal" style="margin-top: 10px;">
                        <div class="form-group">
                            <div class="col-xs-2">能耗国际值</div>
                            <div class="col-xs-10">0.15 kwh/m2</div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-2">建筑面积</div>
                            <div class="col-xs-10">900 m2</div>
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

                $scope.treeMap = echarts.init(document.getElementById("treeMap"));
                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                $scope.getDatas();
            }

            $scope.getDatas = function () {
                $scope.groupTree();
            };

            $scope.init_page();
        });

    </script>
@stop
