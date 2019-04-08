define(function (require, exports, module) {
    var angular = require('angular');
    var asyncLoader = require('angular-async-loader');
    var jquery = require('jquery');
    var dialog = require('dialog');
    var comm = require('comm');

    require('angular-ui-router');
    require('angular-touch');
    //require('angular-animate');

    var p = [
        'ui.router',
        'ngTouch',
        //'ngAnimate'
    ];

    var app = angular.module('app', p);
    
    asyncLoader.configure(app);

    // 绑定跳转页面时隐藏弹出框
    $(window).bind('hashchange', function(e) {
        $(".maskDiv").remove();
        $(".dialogDiv").remove();
    });

    module.exports = {
    	app: app,
    	jquery: jquery,
    	dialog: dialog,
    	comm: comm
    };
});
