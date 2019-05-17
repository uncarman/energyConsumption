define(function (require) {
    var app = require('../js/app').app;

    app.controller('home', ['$scope', function ($scope) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);
        });

        $scope.$on('$destroy', function () {
            // pass
        });

        // 初始化数据
        var datas = {
            map_id: "map",
            mapPos: null,
            map_zoom_max_limit: 24,
            map_zoom_max: 12,
            map_zoom_min: 6,
            opt: {
                state: 1
            }
        }
        $scope.datas = { ...settings.default_datas, ...datas };

        $scope.reset_datas = function($scope, tp) {
            try {
                $scope.datas.opt.state = typeof tp != "undefined" ? tp : $scope.datas.opt.state;
            } catch (ex) {
                // pass
            }
        }

        $scope.ajax_data = function($scope) {
            var param = {
                _method: 'get',
                _url: settings.ajax_func.getBuidings,
                _param: {
                    // page: $scope.datas.cur_page,
                    // state: $scope.datas.opt.state,
                    // query: $scope.datas.opt.query
                }
            };
            return global.return_promise($scope, param);
        }

        $scope.get_datas_callback = function(res) {
            $scope.$apply(function(){
                $scope.datas.dataList = res.data;
            });
        }

        $scope.gotoSummary = function(id) {
            $scope.goto("building_summary/"+id);
        }

        $scope.init_map_size = function() {
            var height = document.documentElement.clientHeight - $(".form-inline").height() - 50;
            $("#"+$scope.datas.map_id).css({"height": height});
        }
        

        // 执行函数
        $scope.get_datas($scope);

        // 初始化地图
        $scope.init_map_size();
        global.init_map($scope);
        console.log($scope.map);

    }])
});
