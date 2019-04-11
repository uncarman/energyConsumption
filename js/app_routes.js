define(function (require) {

    var m = require('./app');
    var app = m.app;

    // 设置全局变量，所有页面公用
    settings = m.comm.settings;
    global = m.comm.global;
    ajax_list = []; // url 中 hash 发生变化放弃页面中未完成的ajax请求

    alert = MyAlert = m.dialog.MyAlert;
    MyMsg = m.dialog.MyMsg;
    MyCustomPop = m.dialog.MyCustomPop;
    MyAlertError = m.dialog.MyAlertError;
    MyConfirm = m.dialog.MyConfirm;

    // 替换默认console函数
    if(!settings.is_debug)
    {
        console = {
            log: function(){},
            debug: function(){},
            info: function(){},
            warn: function(){},
            error: function(){}
        }
    }

    // 判断能否使用 localStorage
    if(window.localStorage){
        settings.can_localStorage = true;
    }else{
        settings.can_localStorage = false;
    }

    app.run(['$state', '$stateParams', '$rootScope', function ($state, $stateParams, $rootScope) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
    }]);

    // 添加 富文本转换 filter
    app.filter('to_html', ['$sce', function ($sce) {
        return function (text) { return $sce.trustAsHtml(text); };
    }]);

    // 添加 舍去小数末尾数字（非四舍五入） filter
    app.filter('fmt_money', function(){
        return global.fmt_money
    });

    app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

        var default_page = settings.default_page;

        // 获取当前页面地址
        var url_list = window.location.href.split("#").pop();
        var page = url_list.split("/")[1];
        if(page.indexOf("?") > 0)
        {
            page = page.split("?")[0];
        }
        if(!page)
        {
            // 支付或登录后退后回到上一个页面
            var temp_session = global.read_storage('session');
            if (temp_session['from']) {
                default_page = temp_session['from'];
            }
            // 清空原来的 from
            global.set_storage_key('session', [
                {key:'from', val:''}
            ]);
            $urlRouterProvider.otherwise('/'+default_page);
        }
        else
        {
            $urlRouterProvider.otherwise('/'+default_page);
        }

        $stateProvider
            ///////////// 公共模块
            .state('dashboard', {
                url: '/dashboard',
                templateUrl: './modules/dashboard.html?v='+version,
                controllerUrl: './modules/dashboard',
                controller: 'dashboard'
            })

            ///////////// 首页
            .state('home', {
                url: '/home',
                templateUrl: './modules/home.html?v='+version,
                controllerUrl: './modules/home',
                controller: 'home'
            })

            ///////////// 登录
            .state('login', {
                url: '/login',
                templateUrl: './modules/login.html?v='+version,
                controllerUrl: './modules/login',
                controller: 'login'
            })

            ///////////// 建筑概述
            .state('building_summary/:id', {
                url: '/building_summary/:id',
                templateUrl: './modules/building/building_summary.html?v='+version,
                controllerUrl: './modules/building/building_summary',
                controller: 'buildingSummary'
            })
            ///////////// 建筑详情
            .state('building_detail/:id', {
                url: '/building_detail/:id',
                templateUrl: './modules/building/building_detail.html?v='+version,
                controllerUrl: './modules/building/building_detail',
                controller: 'buildingDetail'
            })
            ///////////// 暖通空调
            .state('building_ntkt/:id', {
                url: '/building_ntkt/:id',
                templateUrl: './modules/building/building_ntkt.html?v='+version,
                controllerUrl: './modules/building/building_ntkt',
                controller: 'buildingNTKT'
            })
            ///////////// 变配电
            .state('building_bpd/:id', {
                url: '/building_bpd/:id',
                templateUrl: './modules/building/building_bpd.html?v='+version,
                controllerUrl: './modules/building/building_bpd',
                controller: 'buildingBPD'
            })
            ///////////// 智能照明
            .state('building_znzm/:id', {
                url: '/building_znzm/:id',
                templateUrl: './modules/building/building_znzm.html?v='+version,
                controllerUrl: './modules/building/building_znzm',
                controller: 'buildingZNZM'
            })
            ///////////// 门禁管理
            .state('building_mj/:id', {
                url: '/building_mj/:id',
                templateUrl: './modules/building/building_mj.html?v='+version,
                controllerUrl: './modules/building/building_mj',
                controller: 'buildingMJ'
            })
            ///////////// 消防监控
            .state('building_xfjk/:id', {
                url: '/building_xfjk/:id',
                templateUrl: './modules/building/building_xfjk.html?v='+version,
                controllerUrl: './modules/building/building_xfjk',
                controller: 'buildingXFJK'
            })


            ///////////// 能耗计量
            .state('building_nhjl/:id', {
                url: '/building_nhjl/:id',
                templateUrl: './modules/building/building_nhjl.html?v='+version,
                controllerUrl: './modules/building/building_nhjl',
                controller: 'buildingNHJL'
            })
            ///////////// 数据统计
            .state('building_sjtj/:id', {
                url: '/building_sjtj/:id',
                templateUrl: './modules/building/building_sjtj.html?v='+version,
                controllerUrl: './modules/building/building_sjtj',
                controller: 'buildingSJTJ'
            })
            ///////////// 报警处理
            .state('building_bjcl/:id', {
                url: '/building_bjcl/:id',
                templateUrl: './modules/building/building_bjcl.html?v='+version,
                controllerUrl: './modules/building/building_bjcl',
                controller: 'buildingBJCL'
            })
            ///////////// 基础数据
            .state('building_jcsj/:id', {
                url: '/building_jcsj/:id',
                templateUrl: './modules/building/building_jcsj.html?v='+version,
                controllerUrl: './modules/building/building_jcsj',
                controller: 'buildingJCSJ'
            })

            ///////////// 能耗计量分项
            .state('building_nhjl_detail/:id/:type', {
                url: '/building_nhjl_detail/:id/:type',
                templateUrl: './modules/building/building_nhjl_detail.html?v='+version,
                controllerUrl: './modules/building/building_nhjl_detail',
                controller: 'buildingNHJLDetail'
            })

    }]);
});
