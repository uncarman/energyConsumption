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
                        <a><span class="glyphicon glyphicon-star-empty"></span> 监测配置</a>
                    </li>
                </ul>
            </div>

            <div class="box-right">
                <ul class="nav nav-tabs tftab">
                    <li><span class="title"><span class="glyphicon glyphicon-star-empty"></span> 监控层级 </span></li>
                </ul>
                <div class="nav-tabContents">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3><span ng-bind="datas.summaryData.building.name"></span> 示意图</h3>
                        </div>
                        <div class="col-xs-6">
                            <button class="btn btn-primary pull-right">编辑</button>
                        </div>
                    </div>


                    <div class="divider"></div>

                    <div id="treeMap" class="big-echart" style="width:100%; height:700px;"></div>
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



            var series = {
                name:'分项示意图',
                type:'tree',
                orient: 'horizontal',  // vertical horizontal
                rootLocation: {x: 50,y: "center" }, // 根节点位置  {x: 100, y: 'center'}
                nodePadding: 40,
                layerPadding: 130,
                hoverable: true,
                roam: "move",
                symbolSize: 12,
                itemStyle: {
                    normal: {
                        label: {
                            show: true,
                            position: 'top',
                            textStyle: {
                                color: '#000',
                                fontSize: 16
                            }
                        },
                        lineStyle: {
                            color: '#ddd',
                            type: 'broken' // 'curve'|'broken'|'solid'|'dotted'|'dashed'

                        }
                    }
                },
                data: []
            };
            var option = {
                series : []
            };
            $scope.ajaxGroupTree = function () {
                var param = {
                    _method: 'get',
                    _url: "/" + $scope.datas.buildingId + "/settings/ajaxGroupTree",
                    _param: {
                        bid : $scope.datas.building_id
                    }
                };
                return global.return_promise($scope, param);
            }
            $scope.groupTree = function () {
                $scope.ajaxGroupTree()
                    .then($scope.summaryData)
                    .then($scope.drawMap)
                    .catch($scope.ajaxCatch);
            };
            $scope.summaryData = function (data) {
                $scope.$apply(function () {
                    $scope.datas.summaryData = data.result;
                });
                return data;
            }
            $scope.drawMap = function (data) {
                $scope.$apply(function () {
                    var ci = 0;
                    var res = data.result.groups;
                    var opt = angular.copy(option);
                    for(var o in res) {
                        var s = angular.copy(series);
                        s.name = res[o].name;
                        s.rootLocation = {x: (50 + 550*o),y: "center"}; // 根节点位置  {x: 100, y: 'center'}
                        for(var i in res[o].children) {
                            res[o].children[i].symbol = 'circle';
                            res[o].children[i].itemStyle = {
                                normal: {
                                    color: settings.colors[ci],
                                    label: {
                                        show: true,
                                        position: 'top',
                                        textStyle: {
                                            color: settings.colors[ci],
                                            fontSize: 16
                                        }
                                    },
                                }
                            }
                            for(var j in res[o].children[i].children) {
                                res[o].children[i].children[j].symbol = 'circle';
                                res[o].children[i].children[j].itemStyle = {
                                    normal: {
                                        color: settings.colors[ci],
                                        label: {
                                            show: true,
                                            position: 'right',
                                            textStyle: {
                                                color: settings.colors[ci],
                                                fontSize: 16
                                            }
                                        },
                                    }
                                }
                            }
                            ci += 1;
                        }
                        s.data = [{"name":s.name, "children": res[o].children}];
                        opt.series.push(s);
                    }
                    console.log(opt);
                    $scope.treeMap.setOption(opt, true);
                    $scope.treeMap.resize();
                });
                return data;
            };

            $scope.init_page();
        });

    </script>
@stop
