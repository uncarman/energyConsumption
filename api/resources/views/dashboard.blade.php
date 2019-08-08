@extends('layouts.multiple')

@section('content')

    <div class="breadcrumb">
        <li><a href="/dashboard">首页</a></li>
        <li>控制面板</li>
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-body mainbody">

            @include('layouts.errors')

            <div class="form-group">
                <button class="btn btn-default" ng-click="getSummary('ammeter')">获取总用电</button>
                <button class="btn btn-default" ng-click="getSummary('watermeter')">获取总用水</button>
                <button class="btn btn-default" ng-click="getSummary('energymeter')">获取总用热</button>

                <button class="btn btn-default" ng-click="getMeters('ammeter')">所有电表</button>
                <button class="btn btn-default" ng-click="getMeterDatas(1, 'ammeter', 'hour')">电表1数据</button>
                <button class="btn btn-default" ng-click="getMeterDatas(2, 'ammeter', 'hour')">电表2数据</button>
                <button class="btn btn-default" ng-click="getMeterDatas(3, 'ammeter', 'hour')">电表3数据</button>

            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="c-datepicker-date-editor J-datepicker-range-day mt10">
                        <i class="c-datepicker-range__icon kxiconfont icon-clock"></i>
                        <input placeholder="开始日期" name="" class="c-datepicker-data-input only-date" value="">
                        <span class="c-datepicker-range-separator">-</span>
                        <input placeholder="结束日期" name="" class="c-datepicker-data-input only-date" value="">
                    </div>
                </div>
                <script>
                    //年月日范围
                    function shortcutMonth () {
                        // 当月
                        var nowDay = moment().get('date');
                        var prevMonthFirstDay = moment().subtract(1, 'months').set({ 'date': 1 });
                        var prevMonth2FirstDay = moment().subtract(2, 'months').set({ 'date': 1 });
                        var prevMonth3FirstDay = moment().subtract(3, 'months').set({ 'date': 1 });
                        var prevMonthDay = moment().diff(prevMonthFirstDay, 'days');
                        var prevMonth2Day = moment().diff(prevMonth2FirstDay, 'days');
                        var prevMonth3Day = moment().diff(prevMonth3FirstDay, 'days');
                        return {
                            now: '-' + (nowDay-1) + ',0',
                            prev: '-' + prevMonthDay + ',-' + nowDay,
                            prev2: '-' + prevMonth2Day + ',-' + (prevMonthDay+1),
                            prev3: '-' + prevMonth3Day + ',-' + (prevMonth2Day+1)
                        }
                    }
                    var sm = shortcutMonth();
                    var rangeShortcutOption = [
                        {
                            name: '昨天',
                            day: '-1,0',
                        },
                        {
                            name: '最近7天',
                            day: '-7,0'
                        },
                        {
                            name: '最近30天',
                            day: '-30,0'
                        },
                        {
                            name: '最近90天',
                            day: '-90, 0'
                        },
                        {
                            name: '这一月',
                            day: sm.now,
                        },
                        {
                            name: '上一个月',
                            day: sm.prev,
                        },
                        {
                            name: '上二个月',
                            day: sm.prev2,
                        },
                        {
                            name: '上三个月',
                            day: sm.prev3,
                        }
                    ];
                    $(function(){
                        $('.J-datepicker-range-day').datePicker({
                            isRange: true,
                            hasShortcut: true,
                            format: "YYYY-MM-DD",
                            shortcutOptions: rangeShortcutOption
                        });
                    });
                </script>
            </div>

            <div class="form-control" style="height: auto;" ng-bind="datas.datas | json"></div>

            <div id="ammeterHourBig" class="big-echart"></div>

            <div id="main" style="height:500px;border:1px solid #ccc;padding:10px;"></div>
            <div id="mainMap" style="height:500px;border:1px solid #ccc;padding:10px;"></div>


            <!-- /.box-body -->
            @if(!empty($plants))
                <div class="box-footer clearfix">
                    {{ $plants->appends(request()->all())->render() }}
                </div>
            @endif

        </div>
    </div>

<script type="application/javascript">
    angular.module("app",[])
        .config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('{[{');
            $interpolateProvider.endSymbol('}]}');
        }).controller('pageCtrl', function($scope) {

        global.on_load_func($scope);

        // 当前页面默认值
        let datas = {
            existAmmeter: [],
        };
        $.extend(settings.default_datas, datas);
        $scope.datas = datas;

        $scope.init_page = function () {
            $scope.ammeterHourBig = echarts.init(document.getElementById("ammeterHourBig"));
        };


        $scope.ajaxCallback = function (data) {
            $scope.$apply(function(){
                $scope.datas.datas = data.result;
            });
            return data;
        };

        $scope.ajaxCatch = function (e) {
            alert(e);
        }

        $scope.ajaxGetUserSummary = function (type) {
            var param = {
                _method: 'get',
                _url: settings.ajax_func.ajaxGetUserSummary,
                _param: {
                    type : type
                }
            };
            return global.return_promise($scope, param);
        }
        $scope.getSummary = function (type) {
            $scope.ajaxGetSummary(type)
                .then($scope.ajaxCallback)
                .catch($scope.ajaxCatch);
        };


        $scope.ajaxGetMeters = function (type) {
            var param = {
                _method: 'get',
                _url: settings.ajax_func.ajaxGetMeters,
                _param: {
                    type : type
                }
            };
            return global.return_promise($scope, param);
        }
        $scope.getMeters = function (type) {
            $scope.ajaxGetMeters(type)
                .then($scope.ajaxCallback)
                .catch($scope.ajaxCatch);
        };


        $scope.ajaxGetMeterDatas = function (device_id, type, date_type, from, to) {
            var param = {
                _method: 'get',
                _url: settings.ajax_func.ajaxGetMeterDatas,
                _param: {
                    type : type,
                    device_id: device_id,
                    date_type: date_type,
                    from: from,
                    to: to,
                }
            };
            return global.return_promise($scope, param);
        }
        $scope.getMeterDatas = function (device_id, type, date_type, from, to) {
            $scope.ajaxGetMeterDatas(device_id, type, date_type, from, to)
                .then($scope.ajaxCallback)
                .then($scope.drawLine)
                .catch($scope.ajaxCatch);
        };

        function copy(obj){
            var newObj = obj;
            if (obj && typeof obj === "object") {
                newObj = Object.prototype.toString.call(obj) === "[object Array]" ? [] : {};
                for (var i in obj) {
                    newObj[i] = copy(obj[i]);
                }
            }
            return newObj;
        }
        function fmtEChartData(data){
            var tmpSeriesData = [];
            data.datas.map(function (p) {
                tmpSeriesData.push([
                    new Date(p.key),
                    (p.val == "" ? 0 : parseFloat(p.val).toFixed(2))
                ])
            });
            return tmpSeriesData;
        }
        function drawEChart(echart, opt) {
            console.log(opt);
            echart.setOption(opt, true);
            echart.resize();
        }
        var series = {
            type:'line',
            smooth:true,
            symbol: 'circle',
            sampling: 'average',
            data: [],
        };
        var lineOption = {
            dataZoom: {
                type: 'inside'
            },
            grid: {
                left: '5%',
                right: '5%',
                bottom: '5%',
                top: '12%',
                containLabel: true
            },
            tooltip: {
                trigger: 'axis',
                position: function (pos, params, dom, rect, size) {
                    var obj = {top: 60};
                    return obj[['left', 'right'][+(pos[0] < size.viewSize[0] / 2)]] = 5;
                }
            },
            legend: {
                data: [],
            },
            xAxis: {
                type: 'time',
            },
            yAxis: {
                type: 'value',
            },
            series: [],
        };
        $scope.drawLine = function (data) {
            $scope.$apply(function () {
                var chart = $scope.ammeterHourBig;
                var opt = null;
                try {
                    opt = chart.getOption();
                } catch (e) {
                    opt = copy(lineOption);
                }
                var index = $scope.datas.existAmmeter.indexOf(data.result.id);
                if(index >=0 ) {
                    opt.series[index].data = fmtEChartData(data.result);
                } else {
                    $scope.datas.existAmmeter.push(data.result.id);
                    var temSeries = copy(series);
                    temSeries.name = data.result.id;
                    temSeries.data = fmtEChartData(data.result);
                    opt.legend = {data: $scope.datas.existAmmeter};
                    opt.series.push(temSeries);
                }
                drawEChart($scope.ammeterHourBig, opt);
            });

        };

        $scope.init_page();
    });

</script>
@stop
