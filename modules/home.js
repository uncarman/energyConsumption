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
            opt: {
                state: 2
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

        // 执行函数
        $scope.get_datas($scope);
    }])
});
