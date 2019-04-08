define(function (require) {
    var app = require('../../js/app').app;

    app.controller('buildingMJ', ['$scope', '$stateParams', function ($scope, $stateParams) {

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
                ntkt: [
                    ["冷热源", "FLRB", ["楼顶"]],
                    ["新风机组", "DAHU", ['2F', "3F", "4F", "5F", "6F", "7F", "8F", "9F", "10F", "楼顶"]],
                    ["窗帘", "EFAN", ["7F"]],
                    ["室内环境", "IEMD", ["2F", "3F", "4F", "5F", "6F", "7F"]],
                    ["风机盘管", "FCU", ["2F"]]
                ]
            },
            deviceDetail: [
                ["设备编号", "Door_2FB2S"],
                ["设备类型", "门禁"],
                ["设备描述", "2F售菜间南门"],
                ["开关状态", "打开"],
            ]
        }
        $scope.datas = { ...settings.default_datas, ...datas };

        $scope.changeType = function(ind) {
            console.log(ind);
            $scope.datas.topMenuSelected = ind;
            let type = $scope.datas.building.ntkt[ind];
            console.log(type);
        }

        $scope.changeFloor = function(ind) {
            console.log(ind);
            $scope.datas.subMenuSelected = ind;
            let floor = $scope.datas.building.ntkt[$scope.datas.topMenuSelected][2][ind];
            console.log(floor);
        }

        // 执行函数
        //$scope.get_datas($scope);

    }])
});
