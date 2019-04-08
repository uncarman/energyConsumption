
var version = is_debug ? version : (new Date()).getTime();
var _cdn = is_cdn ? cdn : "";

require.config({
    baseUrl: _cdn,
    waitSeconds: 180,
    paths: {
        'angular': _cdn+'js/libs/angular.min',
        'angular-ui-router': _cdn+'js/libs/angular_ui_router.min',
        'angular-async-loader': _cdn+'js/libs/angular_async_loader.min',
        'angular-touch': _cdn+'js/libs/angular_touch.min',
        'angular-animate': _cdn+'js/libs/angular_animate.min',
        'jquery': _cdn+'js/libs/jquery_1.11.0.min',
        'bootstrap': _cdn+'js/libs/bootstrap.3.3.7.min',
        "dialog": _cdn+'js/f_ui_dialog',
        "comm": _cdn+'js/comm',
    },
    shim: {
        'angular': {exports: 'angular'},
        'angular-ui-router': {deps: ['angular']},
        'angular-touch': {deps: ['angular']},
        'angular-animate': {deps: ['angular']},
        'angular-async-loader': {deps: ['angular']},

        'bootstrap': {deps: ['jquery']},
    },
    urlArgs: "v=" +  version
});


require(['angular', './js/app_routes'], function (angular) {
    angular.element(document).ready(function () {
        angular.bootstrap(document, ['app']);
        angular.element(document).find('html').addClass('ng-app');
    });
});

