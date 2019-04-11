define(function (require) {
    var app = require('../js/app').app;

    app.controller('dashboard', ['$scope', function ($scope) {

        global.on_load_func($scope);

        $scope.$watch('$viewContentLoaded', function () {
            global.on_loaded_func($scope);
        });

        $scope.$on('$destroy', function () {
        	// pass
        });

        // 当前页面默认值
        let datas = {};
        $scope.datas = { ...settings.default_datas, ...datas };

        // 执行函数
        (function(){
            $scope.get_datas = get_datas;
            $scope.get_datas(1);
        })();

        // confirm 弹出框
        $scope.showConfirm = function () {
            MyConfirm({
                showTitleBtn: false,
                txtTitle: "文字标题",
                txtContent: "<div style='text-align: center; margin-bottom: 20px;'>文字内容是否确认收到款项 8720.0元</div>",
                _OK: function(obj){
                    alert("ok click");
                    obj.hide();
                },
                _Cancel: function(obj){
                    alert("cancel click");
                },
                isBtnOkHide: false,
                isBtnCancelHide: false,
            });
        };

        function get_datas (page) {
            if(!$scope.ajax_loading) {
                $scope.datas.cur_page = typeof page != "undefined" ? page : settings.page_default;
                $scope.ajax_loading = true;

                ajax_data(page).then(function(data){
                    let total_page = Math.ceil(data.total / settings.items_per_page);
                    $scope.$apply(function(){
                        $scope.ajax_loading = false;
                        $scope.datas.dataList = data.data;
                        $scope.datas.pageList = []
                        for(let i = 1; i<total_page; i++) {
                            $scope.datas.pageList.push(i);
                        }
                    });
                }).catch(function (data) {
                    alert("获取数据失败(ajax_data):"+data.error);
                });

            }
        }

        function ajax_data(page) {
            var param = {
                _method: 'post',
                _url: settings.ajax_func.getList,
                _param: {
                    page: page,
                    per_page: settings.items_per_page
                }
            };
            return global.return_promise($scope, param);
        }

        function get_user_profile(){
            var params = {
                _url: settings.ajax_func.user
            };

            global.ajax_data($scope, params, function (data) {
                console.log(data);
                $scope.$apply(function(){
                    $scope.user = data.data;
                });
            });
        }

        $scope.do_logout = function () {
            global.remote_do_logout(function(){
                global["goto"]('profile');
            });
        };

    }])
});
