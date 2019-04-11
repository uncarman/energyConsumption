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
                menu: [
                    ["门禁管理", "MJGL", ['2F', "3F", "4F", "5F", "6F", "7F", "8F", "9F", "10F"]]
                ]
            },
            deviceDetail: [],

            devicePoints: [
                {
                    id: 1,
                    style: {"margin-left":"80px", "margin-top":"100px" },
                    deviceDetail: [
                        ["设备编号", "HVAC_2FB2S"],
                        ["设备类型", "暖通"],
                        ["设备描述", "2F售菜间南门"],
                        ["开关状态", "打开"]
                    ]
                },
                {
                    id: 2,
                    style: { "margin-left":"50px", "margin-top":"150px" },
                    deviceDetail: [
                        ["设备编号", "airConditioning_2FB3D"],
                        ["设备类型", "空调"],
                        ["设备描述", "2F售菜间北门"],
                        ["开关状态", "打开"]
                    ]
                }
            ],
        }
        $scope.datas = { ...settings.default_datas, ...datas };

        $scope.gotoSummary = function() {
            $scope.goto("building_summary/"+$stateParams.id);
        }

        $scope.changeType = function(ind) {
            console.log(ind);
            $scope.datas.topMenuSelected = ind;
            let type = $scope.datas.building.menu[ind];
            console.log(type);
        }

        $scope.changeFloor = function(ind) {
            console.log(ind);
            $scope.datas.subMenuSelected = ind;
            let floor = $scope.datas.building.menu[$scope.datas.topMenuSelected][2][ind];
            console.log(floor);
            $scope.datas.currentFloorBg = settings.floorBgs[floor];
            // TODO refresh $scope.datas.devicePoints
        }

        $scope.viewDeviceDetail = function (point) {
            $scope.datas.deviceDetail = point.deviceDetail;
        }

        // 执行函数
        //$scope.get_datas($scope);
        $scope.changeFloor($scope.datas.subMenuSelected);
    }])
});
