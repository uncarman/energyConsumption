define(function (require) {
    var app = require('../../js/app').app;

    app.controller('buildingBPD', ['$scope', '$stateParams', function ($scope, $stateParams) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);
        });

        $scope.$on('$destroy', function () {
            // pass
        });

        // 初始化数据
        var datas = {
            // 一级菜单选中状态
            topMenuSelected: 0,
            // 二级菜单选中状态
            subMenuSelected: 0,
            
            // 假数据
            building: {
                id: $stateParams.id,
                name: "嘉兴市融通商务中心4号楼",
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
