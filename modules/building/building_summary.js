define(function (require) {
    var app = require('../../js/app').app;

    app.controller('buildingSummary', ['$scope', '$stateParams', function ($scope, $stateParams) {

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
                name: "嘉兴市融通商务中心4号楼嘉兴市融通商务中心4号楼",
                location: "嘉兴市某某路XXX号",
            }
        }
        $scope.datas = { ...settings.default_datas, ...datas };

        $scope.gotoDetail = function(id, type) {
            if(typeof type == "undefined") {
                $scope.goto("building_detail/"+id);
            } else {
                $scope.goto("building_" + type + "/"+id);
            }
        }

        // 执行函数
        //$scope.get_datas($scope);
    }])
});
