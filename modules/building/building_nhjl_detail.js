define(function (require) {
    var app = require('../../js/app').app;

    app.controller('buildingNHJLDetail', ['$scope', '$stateParams', function ($scope, $stateParams) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);
        });

        $scope.$on('$destroy', function () {
            // pass
        });

        var pageTypes = {
        	"electric": "电能",
        	"water": "水能",
        	"gas": "天然气",
        	"vapour": "蒸汽"
        }

        // 初始化数据
        var datas = {
            // 一级菜单选中状态
            topMenuSelected: 0,
            
            // 是否显示选项
            show_settings: false,

            opts: {

            },
            newOpts: {

            },

            pageType: pageTypes[$stateParams.type],

            // 假数据
            building: {
                id: $stateParams.id,
                type: $stateParams.type,

                name: "嘉兴市融通商务中心4号楼",
                subMenu: [
                	["总能耗概况", "nhgk"],
                    ["能耗分项", "nhfx"],
                    ["建筑区域", "jzqy"],
                    ["组织架构", "zjjg"]
                ]
            },
            summaryTable: [
                ["总用电量", "12349.00kwh"]
            ],
            listTableTitles: [],
            listTableDatas: [],
        }
        $scope.datas = { ...settings.default_datas, ...datas };

        $scope.gotoSummary = function() {
            $scope.goto("building_summary/"+$stateParams.id);
        }

        $scope.displaySettings = function(type) {
            $scope.datas.show_settings = type == 1 ? true : false;
        }

        $scope.refreshDatas = function() {
            $scope.datas.opts = global.copy($scope.datas.newOpts);
            $scope.get_datas($scope);
        }

        $scope.gotoDetail = function(bid, type) {

        }

        // 执行函数
        //$scope.get_datas($scope);
        $scope.changeFloor($scope.datas.subMenuSelected);

    }])
});
