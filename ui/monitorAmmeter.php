
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
        总用电概述
        <small><?php echo date("Y-m-d"); ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="monitor.php"><i class="fa fa-files-o"></i> 总体用能概述</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> 总用电概述</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="monitorAmmeter.php" data-toggle="tab">总用电概述</a></li>
          <li><a href="monitorAmmeterByType.php?type=1">按能耗分项监测</a></li>
          <li><a href="monitorAmmeterByType.php?type=2">按建筑区域监测</a></li>
          <li><a href="monitorAmmeterByType.php?type=3">按组织机构监测</a></li>
          <li><a href="monitorAmmeterByType.php?type=4">按自定义分类监测</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="summary">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <div class="info-box bg-aqua">
                      <div class="info-box-content">
                        <span class="info-box-text">总用电量(kw)</span>
                        <span class="info-box-number">310,303.20</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description pull-left">
                          环比: 0.00%
                        </span>
                        <span class="progress-description pull-right">
                          2018年同比: 0.00%
                        </span>
                        <div class="clearfixed"></div>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
   
                  <div class="col-md-3">
                    <div class="info-box bg-green">
                      <div class="info-box-content">
                        <span class="info-box-text">当量标煤(吨)</span>
                        <span class="info-box-number">100,848.54</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description pull-left">
                          环比: 0.00%
                        </span>
                        <span class="progress-description pull-right">
                          2018年同比: 0.00%
                        </span>
                        <div class="clearfixed"></div>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="info-box bg-yellow">
                      <div class="info-box-content">
                        <span class="info-box-text">能耗密度(kwh/m2)</span>
                        <span class="info-box-number">31.03</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description pull-left">
                          环比: 0.00%
                        </span>
                        <span class="progress-description pull-right">
                          2018年同比: 0.00%
                        </span>
                        <div class="clearfixed"></div>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="info-box bg-red">
                      <div class="info-box-content">
                        <span class="info-box-text">费用(元)</span>
                        <span class="info-box-number">263,757.72</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description pull-left">
                          环比: 0.00%
                        </span>
                        <span class="progress-description pull-right">
                          2018年同比: 0.00%
                        </span>
                        <div class="clearfixed"></div>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> 按时间区间概况</h3>

                    <div class="pull-right disabled form-inline">
                      查询条件:
                      <input type="text" class="form-control mr10" id="reservation">
                      <select class="form-control mr10">
                          <option>按日</option>
                          <option>按月</option>
                          <option>按年</option>
                      </select>
                      同比数据:
                      <select class="form-control _compareTos mr10">
                          <option>2018</option>
                      </select>
                      <button ng-click="refresh_datas();" class="btn btn-primary"><spam class="glyphicon glyphicon-refresh"></spam> 更新</button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="chart">
                      <div id="dailyChart" style="height:400px;"></div>
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
          </div>

          <!-- /.tab-pane -->
          <div class="tab-pane" id="type1">
          </div>

          <!-- /.tab-pane -->
          <div class="tab-pane" id="type2">
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="type3">
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="type4">
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>

      <div class="clearfixed"></div>
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
          query: {
            type: "day",
          },
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
      $scope.datas.result = monitorAmmeterSummary.result;
      $scope.datas.result.chartDatas.datas = [];
      $scope.datas.result.chartCompareDatas.datas = [];
      $scope.datas.result.dailyList.data = [];
      //  根据日期生成随机数据
      var normalAmmeterDaily = 2;
      var xlen = Math.ceil(moment(moment($scope.datas.toDate).format($scope.datas.fmt)).diff(moment($scope.datas.fromDate).format($scope.datas.fmt), 'days', true));
      for(var i=0; i<=xlen; i++) {
          var d = moment($scope.datas.fromDate).add('days', i).format($scope.datas.fmt);
          var ad = (normalAmmeterDaily * Math.random()).toFixed(2);
          var acd = (normalAmmeterDaily * Math.random()).toFixed(2);
          $scope.datas.result.chartDatas.datas.push({
            "val": ad,
            "key": d
          });
          $scope.datas.result.chartCompareDatas.datas.push({
            "val": acd,
            "key": d
          });
          $scope.datas.result.dailyList.data.unshift([d, ad, (ad*0.325).toFixed(4), (ad/10000).toFixed(4), (ad*0.85).toFixed(4)]);
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
      $scope.dailyChart = echarts.init(document.getElementById("dailyChart"));
      summaryChartDraw($scope.datas);

      function summaryChartDraw(data) {
        var opt = angular.copy($scope.datas.option);

        // 生成x轴内容
        var fmt = "YYYY-MM-DD";
        if($scope.datas.query.type == "hour") { fmt = "DD-HH" }
        else if($scope.datas.query.type == "day") { fmt = "YYYY-MM-DD" }
        else if($scope.datas.query.type == "month") { fmt = "YYYY-MM" }
        else if($scope.datas.query.type == "year") { fmt = "YYYY" }
        var xlen = Math.ceil(moment(moment($scope.datas.toDate).format(fmt)).diff(moment($scope.datas.fromDate).format(fmt), $scope.datas.query.type, true));
        var sd = [], sd2 = [], sd3 = [];
        for(var i=0; i<=xlen; i++) {
            opt.xAxis[0].data.push(moment($scope.datas.fromDate).add($scope.datas.query.type, i).format(fmt));
            sd.push(0);
            sd2.push(0);
            sd3.push($scope.datas.result.summaryData.internationalValue);
        }

        var r = 1;
        var ds = data.result.chartDatas;
        if($scope.datas.selectSummaryChartType == 0) { r = 1; }
        else if ($scope.datas.selectSummaryChartType == 1) { r = 1 / ds.area; }
        else if ($scope.datas.selectSummaryChartType == 2) { r = ds.coal; }
        else if ($scope.datas.selectSummaryChartType == 3) { r = ds.co2; }
        else if ($scope.datas.selectSummaryChartType == 4) { r = ds.fee_policy; }
        // 生成当前柱状图数据
        opt.legend.data[0] = "能耗密度kwh/m2";
        ds.datas.map(function (k) {
            var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
            sd[ind] = parseFloat(k.val * r).toFixed(4);
        });
        opt.series[0] = {
            name: opt.legend.data[0],
            type:'bar',
            data: sd,
        };

        // 生成对比折现图数据
        opt.legend.data[1] = $("._compareTos option:selected").text();
        var ds2 = data.result.chartCompareDatas;
        ds2.datas.map(function (k) {
            var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
            sd2[ind] = parseFloat(k.val * r).toFixed(4);
        });
        opt.series[1] = {
            name: opt.legend.data[1],
            type:'line',
            data: sd2,
        };

        // 生成国际值数据
        opt.legend.data[2] = "国际值";
        ds2.datas.map(function (k) {
            var ind = opt.xAxis[0].data.indexOf(moment(k.key).format(fmt));
            sd2[ind] = parseFloat(k.val * r).toFixed(4);
        });
        opt.series[2] = {
            name: opt.legend.data[2],
            type:'line',
            symbol: 'none',
            data: sd3,
        };

        console.log(opt);
        $scope.dailyChart.setOption(opt, true);
        $scope.dailyChart.resize();
        return data;
    };

    });

</script>
</body>
</html>