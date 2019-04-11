define(function (require) {
    var app = require('../../js/app').app;

    app.controller('buildingNHJL', ['$scope', '$stateParams', function ($scope, $stateParams) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);
        });

        $scope.$on('$destroy', function () {
            // pass
        });

        // 初始化数据
        var datas = {
            // 是否显示选项
            show_settings: false,
            // 页面默认选项
            opt: {
                state : 1
            },

            // 筛选条件
            opts: {
                
            },
            // 正在编辑中的筛选条件
            newOpts: {

            },

            // 假数据
            building: {
                id: $stateParams.id,
                name: "嘉兴市融通商务中心4号楼",
            },
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

        // 四个大标签
        $scope.gotoPage = function(page) {
            $scope.goto("building_" + page + "/"+$stateParams.id);
        }

        // 进入监测分项
        $scope.gotoDetail = function(type) {
            $scope.goto("building_nhjl_detail/"+$stateParams.id+"/"+type);
        }

        // 执行函数
        //$scope.get_datas($scope);
        
    }])
});
