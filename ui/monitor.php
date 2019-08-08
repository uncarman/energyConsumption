
<?php include"layout/head.php" ?>

<div class="wrapper">

  <?php include"layout/header.php" ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php include"layout/sider.php" ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        总体用能概述
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><i class="fa fa-files-o"></i> 总体用能概述</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">图表展示</h3>

              <div class="pull-right">
                <input type="text" class="form-control" id="reservation">
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <div id="summaryChart" style="height:400px;"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><span ng-bind="datas.fromDate"></span> - <span ng-bind="datas.toDate"></span> 数据</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover" id="summaryTable">
                  <thead>
                    <tr>
                        <th ng-repeat="(k,n) in datas.result.dailyList.title" ng-bind="n"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="v in datas.result.dailyList.data">
                        <td ng-repeat="(k,n) in datas.result.dailyList.title"
                            ng-bind="v[k]"></td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
    
  <?php include"layout/footer.php" ?>

</div>
<!-- ./wrapper -->

<?php include"layout/end.php" ?>
<script src="./static/plugins/echart/echarts.js"></script>
<script src="./static/plugins/moment/moment-with-locales.min.js"></script>

<script>
  angular.module("app",[])
    .config(function($interpolateProvider) {
        $interpolateProvider.startSymbol('{[{');
        $interpolateProvider.endSymbol('}]}');
    }).controller('pageCtrl', function($scope) {
      // 当前页面默认值
      let datas = {
          fmt: "YYYY-MM-DD",
          datePickerDom: "#reservation",
          fromDate: moment().add(-15, 'day').format("YYYY-MM-DD"),
          toDate: moment().format("YYYY-MM-DD"),
          option: {
            color: ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
            tooltip : {
              trigger: 'axis'
            },
            legend: {
              data:[],
              y: "10px",
            },
            grid: {
              top: "0",
              left: "0",
              right: "0",
              bottom: "0",
            },
            calculable : true,
            xAxis : [
              {
                type : 'category',
                data : []
              }
            ],
            yAxis : [
              {
                type : 'value'
              }
            ],
            series : [
              // {
              //   name:'用电量',
              //   type:'bar',
              //   data:[]
              // }
            ]
        },
      };

      // 准备假数据
      $scope.datas = datas;
      $scope.datas.result = monitorSummary.result;
      $scope.datas.result.chartDatas.ammeter.datas = [];
      $scope.datas.result.chartDatas.watermeter.datas = [];
      $scope.datas.result.chartDatas.gasmeter.datas = [];
      $scope.datas.result.chartDatas.vapormeter.datas = [];
      $scope.datas.result.dailyList.data = [];
      //  根据日期生成随机数据
      var normalAmmeterDaily = 5000;
      var xlen = Math.ceil(moment(moment($scope.datas.toDate).format($scope.datas.fmt)).diff(moment($scope.datas.fromDate).format($scope.datas.fmt), 'days', true));
      for(var i=0; i<=xlen; i++) {
          var d = moment($scope.datas.fromDate).add('days', i).format($scope.datas.fmt);
          var ad = (normalAmmeterDaily * Math.random()).toFixed(2);
          var wd = (normalAmmeterDaily / 10 * Math.random()).toFixed(2);
          var gd = (normalAmmeterDaily / 30 * Math.random()).toFixed(2);
          var vd = (normalAmmeterDaily / 100 * Math.random()).toFixed(2);
          $scope.datas.result.chartDatas.ammeter.datas.push({
            "val": ad,
            "key": d
          });
          $scope.datas.result.chartDatas.watermeter.datas.push({
            "val": wd,
            "key": d
          });
          $scope.datas.result.chartDatas.gasmeter.datas.push({
            "val": gd,
            "key": d
          });
          $scope.datas.result.chartDatas.vapormeter.datas.push({
            "val": vd,
            "key": d
          });
          $scope.datas.result.dailyList.data.unshift([d, ad, (ad/10000).toFixed(4), wd, (wd/10000).toFixed(4), gd, (gd/10000).toFixed(4), vd, (vd/10000).toFixed(4)]);
      }

      //Date range picker
      $($scope.datas.datePickerDom).daterangepicker({
        startDate: moment($scope.datas.fromDate),
        endDate: moment($scope.datas.toDate),
        locale: {
           format: $scope.datas.fmt
        },
      });

      // 画图表
      $scope.summaryChart = echarts.init(document.getElementById("summaryChart"));
      summaryChartDraw($scope.datas);

      function summaryChartDraw(data) {
        var opt = angular.copy($scope.datas.option);

        // 生成x轴内容
        var xlen = Math.ceil(moment(moment($scope.datas.toDate).format($scope.datas.fmt)).diff(moment($scope.datas.fromDate).format($scope.datas.fmt), 'days', true));
        for(var i=0; i<=xlen; i++) {
            opt.xAxis[0].data.push(moment($scope.datas.fromDate).add('days', i).format($scope.datas.fmt));
        }

        for(var o in data.result.chartDatas) {
            var sd = [];
            for(var i=0; i<=xlen; i++) {
                sd.push(0);
            }
            var d = data.result.chartDatas[o];
            opt.legend.data.push(d.name);

            d.datas.map(function (k) {
                var ind = opt.xAxis[0].data.indexOf(moment(k.key).format($scope.datas.fmt));
                sd[ind] = parseFloat(k.val).toFixed(4);
            });

            var tempSeries = {
                name: d.name,
                type: "bar",
                stack: "总量",
                data: sd
            };
            opt.series.push(tempSeries);
        }
        console.log(opt);
        $scope.summaryChart.setOption(opt, true);
        $scope.summaryChart.resize();
      };

    });

</script>
</body>
</html>