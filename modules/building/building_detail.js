define(function (require) {
    var app = require('../../js/app').app;

    app.controller('buildingDetail', ['$scope', '$stateParams', function ($scope, $stateParams) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);
        });

        $scope.$on('$destroy', function () {
            // pass
        });

        // 初始化数据
        var datas = {
            // 假数据
            building: {
                id: $stateParams.id,
                img: "../imgs/default.png",
                name: "嘉兴市融通商务中心4号楼",
                location: "嘉兴市某某路XXX号",
                features: [
                    ["../imgs/icon-input-success.png", "建筑代码", "110105C001"],
                    ["../imgs/icon-input-success.png", "建筑年代", "2017"],
                    ["../imgs/icon-input-success.png", "建筑层数", "10"],
                    ["../imgs/icon-input-success.png", "建筑类型", "办公建筑"],
                    ["../imgs/icon-input-success.png", "建筑总面积", "10932 m2"],
                    ["../imgs/icon-input-success.png", "空调面积", "7920 m2"],
                    ["../imgs/icon-input-success.png", "采暖面积", "7920 m2"],
                ]
            }
        }
        $scope.datas = { ...settings.default_datas, ...datas };

        $scope.gotoSummary = function() {
            $scope.goto("building_summary/"+$stateParams.id);
        }
        
        // 执行函数
        //$scope.get_datas($scope);
    }])
});
