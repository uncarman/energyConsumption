@extends('layouts.multiple')

@section('content')

    <div class="breadcrumb">
        <li><a href="/dashboard">首页</a></li>
        <li class="active">地图</li>
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">
            @include('layouts.errors')

            <ul class="nav nav-tabs tftab">
                <li><span class="title"><span class="glyphicon glyphicon-map-marker"></span> 地图 </span></li>
            </ul>
            <div class="nav-tabContents">
                <div id="map" style="width: 100%; height: 650px;"></div>
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

            map = null;

            // 当前页面默认值
            let datas = {
                pageInited : false,
                leftOn: true,
                mapId: "map",
            };
            $.extend(datas, settings.default_datas);
            $scope.datas = datas;

            $scope = global.init_base_scope($scope);

            $scope.init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope);

                // 初始化地图
                initMap();

                console.log("init_page");

                $scope.getDatas();
            };

            $scope.refresh_datas = function () {
                $scope.getDatas();
            }

            $scope.getDatas = function () {
                $scope.ajaxBuildingList()
                    .then($scope.drawMap)
                    .catch($scope.ajaxCatch);
            };

            $scope.ajaxBuildingList = function () {
                var param = {
                    _method: 'get',
                    _url: "/ajaxBuildingList",
                    _param: {}
                };
                return global.return_promise($scope, param);
            }
            $scope.drawMap = function (datas) {
                console.log(datas);
                $scope.$apply(function () {
                    var data = datas.result.buildingList.data;
                    var infoWindow = new AMap.InfoWindow({offset: new AMap.Pixel(6, -20)});
                    for (var i = 0; i < data.length; i++) {
                        var marker = new AMap.Marker({
                            position: [data[i].longitude, data[i].latitude],
                            map: map,
                            bubble: false,
                            topWhenClick: true,
                            cursor: "point",
                            extData: data[i],  // 缓存电站信息到market点中
                            ind: i,
                            //title: data[i].name,
                            label: {content: data[i].name, offset: new AMap.Pixel(30, 5)},
                            zIndex: 100,
                        });
                        marker.on('click', markerClick);
                    }

                    // 设置最佳显示状态
                    map.setFitView();

                    function markerClick(e) {
                        var d = e.target.getExtData();
                        var $content = $("<div class='media'></div>")
                            .append($("<div class='media-left'></div>")
                                .append($("<img class='media-object' style='margin-bottom: 10px;' width='80'>").attr("src", d.photo))
                            ).append($("<div class='media-body' style='min-width:240px;'></div>")
                                .append($("<p></p>").html("<b>"+d.name+"</b><br>"+d.address+"<br><br>查看详情 &nbsp; <a href='/"+d.id+"/monitor/summary'>监测分析</a> &nbsp; <a href='/"+d.id+"/statistics/summary'>数据统计</a> &nbsp; <a href='/"+d.id+"/settings/group'>系统配置</a>"))
                            );
                        infoWindow.setContent($content.get(0));
                        infoWindow.open(map, e.target.getPosition());
                    }
                });
                return datas;
            };

            // 初始化地图
            function initMap() {
                map = new AMap.Map($scope.datas.mapId,{
                    resizeEnable: true,
                    rotateEnable:true,
                    pitchEnable:true,
                    zoom: 6,
                    pitch:45,
                    rotation:0,
                    viewMode:'3D',//开启3D视图,默认为关闭
                    expandZoomRange:true,
                    zooms:[6,24],
                });
                //map.setMapStyle('amap://styles/d3e48bfa418416a85b7eec13dbe3aeb0');
                // 右上控制插件
                map.plugin(["AMap.ControlBar"],function(){
                    map.addControl(new AMap.ControlBar({
                        showZoomBar:true,
                        showControlButton:true,
                        position:{
                            right:'30px',
                            top:'10px'
                        }
                    }));
                });
                var content = [
                    '<div class="context-menu-content">',
                    '<ul class="context_menu">',
                    '<li onclick="showSearch();">搜索</li>',
                    '<li onclick="refreshDatas();">重新加载</li>',
                    '<li class="split_line" onclick="map.zoomOut();">放大一级</li>',
                    '<li class="split_line" onclick="map.zoomIn();">缩小一级</li>',
                    '<li class="split_line" onclick="map.setZoom(12); map.setCenter(new AMap.LngLat(mapPos.getLng(), mapPos.getLat()));">放到跟前</li>',
                    '<li class="split_line" onclick="map.setZoom(6);">缩到全局</li>',
                    '</ul>',
                    '</div>'
                ];
                contextMenu = new AMap.ContextMenu({
                    isCustom: true,
                    content: content.join('')
                });
                map.on('rightclick', function(e) {
                    window.contextMenu.open(map, e.lnglat);
                    window.mapPos = e.lnglat;
                });
                map.on("click", function (e) {
                    setPlantView();
                })
            }

            $scope.init_page();
        });

    </script>
@stop


