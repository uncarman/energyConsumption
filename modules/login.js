define(function (require) {
    var app = require('../js/app').app;

    app.controller('login', ['$scope', function ($scope) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);

            $scope.loginStyle = {
                "margin-top": window.screen.availHeight/2 - $(".login").height()/2 - 60 + "px",
            }
        });

        $scope.$on('$destroy', function () {
            // pass
        });

        $scope.datas = { ...settings.default_datas, ...{} };

        // 执行函数
        (function(){
            // 前端校验用户登录
            var _session = global.read_storage('session');
            var user = _session.user;
            if(user) {
                global["goto"]($scope.settings.default_page);
            }
        })();

        $scope.fake_login = function() {
            global.set_storage_key("session", [
                {
                    key: "user",
                    val: "fakeUser"
                }
            ]);
            global["goto"]($scope.settings.default_page);
        }

    }])
});
