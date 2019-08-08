<?php

namespace App\Http\Controllers\Statistics;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsSummaryController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request)
    {
        return view('single.statistics.summary');
    }

    public function summaryFee(Request $request)
    {
        return view('single.statistics.summary_fee');
    }

    public function ajaxMeterSummary($buildingId, Request $request) {
        $from = $request->get("from", date("Y-m-01"));
        $to = $request->get("to", date("Y-m-d"));
        $compareToYear = $request->get("compareTo", date("Y", strtotime("-1 years")));
        $lastMonth = date("Y-m", strtotime("-1 months"));
        $compareToFrom = date($compareToYear."-m-d" , strtotime($from));
        $compareToTo = date($compareToYear."-m-d" , strtotime($to));
        $type = $request->get("type", "day");
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);
        $feePolicy = !empty(json_decode($building->fee_policy, true)) ? json_decode($building->fee_policy, true) : [];
        // 总用电量
        $env = [
            "coal" => 0.325,
            "co2" => 0.9171,
            "so2" => 0.0023,
            "nox" => 0.0037,
            "smoke" => 0.0004,
            "tree" => 0.9171 / 18.334,
        ];
        $ammeterTotalVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $ammeterCurrentMonthVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $ammeterLastMonthVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $ammeterCurrentYearVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $ammeterCompareToYearVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        $watermeterTotalVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $watermeterCurrentMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $watermeterLastMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $watermeterCurrentYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $watermeterCompareToYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        $gasmeterTotalVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $gasmeterCurrentMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $gasmeterLastMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $gasmeterCurrentYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $gasmeterCompareToYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        $vapormeterTotalVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $vapormeterCurrentMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $vapormeterLastMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $vapormeterCurrentYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $vapormeterCompareToYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        // 根据type显示图表数据
        $ammeterChartDatas = $this->bs->instance("db")->buildingAmmeterSummaryDatas($buildingId, $type, $from, $to);
        $ammeterChartDatas = [
            "datas" => array_map(function($d) use ($feePolicy){
                return [
                    "val" => $d->val * $feePolicy["ammeter"],
                    "key" => $d->record_date
                ];
            }, $ammeterChartDatas),
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "kwh",
            "prop_area" => $building->area,
            "name" => "电量",
            "area" => $building->area,
            "fee_policy" => $feePolicy["ammeter"],
        ];

        $watermeterChartDatas = [
            "datas" => [],
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "吨",
            "prop_area" => $building->area,
            "name" => "水量",
            "area" => $building->area,
            "fee_policy" => $feePolicy["watermeter"],
        ];
        $gasmeterChartDatas = [
            "datas" => [],
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "立方米",
            "prop_area" => $building->area,
            "name" => "燃气量",
            "area" => $building->area,
            "fee_policy" => $feePolicy["gasmeter"],
        ];
        $vapormeterChartDatas = [
            "datas" => [],
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "吨",
            "prop_area" => $building->area,
            "name" => "蒸汽费",
            "area" => $building->area,
            "fee_policy" => $feePolicy["vapormeter"],
        ];

        // TODO sql 直接输出
        $dailyDatas = array_map(function($d) use ($feePolicy, $building){
            return [
                $d["key"],
                round($d["val"], 2),
                round($d["val"] / $building->area, 2),
                0,0,0,0,0,0
            ];
        }, $ammeterChartDatas["datas"]);

        $res = [
            "from" => $from,
            "to" => $to,
            "building" => $building,
            "summaryData" => [
                "internationalValue" => 0.15,  // 国际能耗标准值

//                "totalName" => "总用费用",
//                "totalUnit" => "元",
//                "total" => $ammeterTotalVal->val + 0 + 0 + 0,
//                "totalCompareMonth" => $ammeterLastMonthVal->val > 0 ? ($ammeterCurrentMonthVal->val-$ammeterLastMonthVal->val)*100/$ammeterCurrentMonthVal->val : "0",
//                "totalCompareYear" => $ammeterCompareToYearVal->val > 0 ? ($ammeterCurrentYearVal->val-$ammeterCompareToYearVal->val)*100/$ammeterCurrentYearVal->val : "0",

                "total1Name" => "总电量",
                "total1Unit" => "kwh",
                "total1" => $ammeterTotalVal->val,
                "totalCompare1Month" => $ammeterLastMonthVal->val > 0 ? ($ammeterCurrentMonthVal->val-$ammeterLastMonthVal->val)*100/$ammeterCurrentMonthVal->val : "0",
                "totalCompare1Year" => $ammeterCompareToYearVal->val > 0 ? ($ammeterCurrentYearVal->val-$ammeterCompareToYearVal->val)*100/$ammeterCurrentYearVal->val : "0",

                "total2Name" => "总水量",
                "total2Unit" => "吨",
                "total2" => 0,
                "totalCompare2Month" => 0,
                "totalCompare2Year" => 0,

                "total3Name" => "总燃气量",
                "total3Unit" => "立方米",
                "total3" => 0,
                "totalCompare3Month" => 0,
                "totalCompare3Year" => 0,

                "total4Name" => "总蒸汽量",
                "total4Unit" => "吨",
                "total4" => 0,
                "totalCompare4Month" => 0,
                "totalCompare4Year" => 0,
            ],

            "chartDatas" => [
                "ammeter" => $ammeterChartDatas,
                "watermeter" => $watermeterChartDatas,
                "gasmeter" => $gasmeterChartDatas,
                "vapormeter" => $vapormeterChartDatas,
            ],
            "totalVal" => [
                [
                    "name" => "总电量",
                    "val" => $ammeterTotalVal->val,
                ],
                [
                    "name" => "总水量",
                    "val" => 0,
                ],
                [
                    "name" => "总燃气量",
                    "val" => 0,
                ],
                [
                    "name" => "总蒸汽量",
                    "val" => 0,
                ],
            ],
            "dailyList" => [
                "title" => ["日期", "总电量", "总电量密度", "总水量", "总水量密度", "总燃气量", "总燃气量密度", "总蒸汽量", "总蒸汽量密度"],
                "data" => $dailyDatas,
            ]
            //"compareTotalVal" => $compareTotalVal,
        ];

        return makeSuccessMsg($res);
    }

    public function ajaxMeterSummaryFee($buildingId, Request $request) {
        $from = $request->get("from", date("Y-m-01"));
        $to = $request->get("to", date("Y-m-d"));
        $compareToYear = $request->get("compareTo", date("Y", strtotime("-1 years")));
        $lastMonth = date("Y-m", strtotime("-1 months"));
        $compareToFrom = date($compareToYear."-m-d" , strtotime($from));
        $compareToTo = date($compareToYear."-m-d" , strtotime($to));
        $type = $request->get("type", "day");
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);
        $feePolicy = !empty(json_decode($building->fee_policy, true)) ? json_decode($building->fee_policy, true) : [];
        // 总用电量
        $env = [
            "coal" => 0.325,
            "co2" => 0.9171,
            "so2" => 0.0023,
            "nox" => 0.0037,
            "smoke" => 0.0004,
            "tree" => 0.9171 / 18.334,
        ];
        $ammeterTotalVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $ammeterCurrentMonthVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $ammeterLastMonthVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $ammeterCurrentYearVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $ammeterCompareToYearVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        $watermeterTotalVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $watermeterCurrentMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $watermeterLastMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $watermeterCurrentYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $watermeterCompareToYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        $gasmeterTotalVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $gasmeterCurrentMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $gasmeterLastMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $gasmeterCurrentYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $gasmeterCompareToYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        $vapormeterTotalVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $vapormeterCurrentMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $vapormeterLastMonthVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $vapormeterCurrentYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $vapormeterCompareToYearVal = 0; //$this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");

        // 根据type显示图表数据
        $ammeterChartDatas = $this->bs->instance("db")->buildingAmmeterSummaryDatas($buildingId, $type, $from, $to);
        $ammeterChartDatas = [
            "datas" => array_map(function($d) use ($feePolicy){
                return [
                    "val" => $d->val * $feePolicy["ammeter"],
                    "key" => $d->record_date
                ];
            }, $ammeterChartDatas),
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "元",
            "prop_area" => $building->area,
            "name" => "电费",
            "area" => $building->area,
            "fee_policy" => $feePolicy["ammeter"],
        ];

        $watermeterChartDatas = [
            "datas" => [],
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "元",
            "prop_area" => $building->area,
            "name" => "水费",
            "area" => $building->area,
            "fee_policy" => $feePolicy["watermeter"],
        ];
        $gasmeterChartDatas = [
            "datas" => [],
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "元",
            "prop_area" => $building->area,
            "name" => "燃气费",
            "area" => $building->area,
            "fee_policy" => $feePolicy["gasmeter"],
        ];
        $vapormeterChartDatas = [
            "datas" => [],
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "元",
            "prop_area" => $building->area,
            "name" => "蒸汽费",
            "area" => $building->area,
            "fee_policy" => $feePolicy["vapormeter"],
        ];

        // TODO sql 直接输出
        $dailyDatas = array_map(function($d) use ($feePolicy, $building){
            return [
                $d["key"],
                round($d["val"] * $feePolicy["ammeter"], 2),
                round($d["val"] * $feePolicy["ammeter"] / $building->area, 2),
                round($d["val"] * $feePolicy["ammeter"], 2),
                round($d["val"] * $feePolicy["ammeter"] / $building->area, 2),
                0,0,0,0,0,0
            ];
        }, $ammeterChartDatas["datas"]);

        $res = [
            "from" => $from,
            "to" => $to,
            "building" => $building,
            "summaryData" => [
                "internationalValue" => 0.15,  // 国际能耗标准值

                "totalName" => "总用费用",
                "totalUnit" => "元",
                "total" => $ammeterTotalVal->val * $feePolicy["ammeter"] + 0 + 0 + 0,
                "totalCompareMonth" => $ammeterLastMonthVal->val > 0 ? ($ammeterCurrentMonthVal->val-$ammeterLastMonthVal->val)*100/$ammeterCurrentMonthVal->val : "0",
                "totalCompareYear" => $ammeterCompareToYearVal->val > 0 ? ($ammeterCurrentYearVal->val-$ammeterCompareToYearVal->val)*100/$ammeterCurrentYearVal->val : "0",

                "total1Name" => "总电费",
                "total1Unit" => "元",
                "total1" => $ammeterTotalVal->val * $feePolicy["ammeter"] + 0 + 0 + 0,
                "totalCompare1Month" => $ammeterLastMonthVal->val > 0 ? ($ammeterCurrentMonthVal->val-$ammeterLastMonthVal->val)*100/$ammeterCurrentMonthVal->val : "0",
                "totalCompare1Year" => $ammeterCompareToYearVal->val > 0 ? ($ammeterCurrentYearVal->val-$ammeterCompareToYearVal->val)*100/$ammeterCurrentYearVal->val : "0",

                "total2Name" => "总水费",
                "total2Unit" => "元",
                "total2" => 0,
                "totalCompare2Month" => 0,
                "totalCompare2Year" => 0,

                "total3Name" => "总燃气费",
                "total3Unit" => "元",
                "total3" => 0,
                "totalCompare3Month" => 0,
                "totalCompare3Year" => 0,

                "total4Name" => "总蒸汽费",
                "total4Unit" => "元",
                "total4" => 0,
                "totalCompare4Month" => 0,
                "totalCompare4Year" => 0,
            ],

            "chartDatas" => [
                "ammeter" => $ammeterChartDatas,
                "watermeter" => $watermeterChartDatas,
                "gasmeter" => $gasmeterChartDatas,
                "vapormeter" => $vapormeterChartDatas,
            ],
            "totalVal" => [
                [
                    "name" => "总电费",
                    "val" => $ammeterTotalVal->val * $feePolicy["ammeter"],
                ],
                [
                    "name" => "总水费",
                    "val" => 0,
                ],
                [
                    "name" => "总燃气费",
                    "val" => 0,
                ],
                [
                    "name" => "总蒸汽费",
                    "val" => 0,
                ],
            ],
            "dailyList" => [
                "title" => ["日期", "总费用", "总费用密度", "总电费", "总电费密度", "总水费", "总水费密度", "总燃气费", "总燃气费密度", "总蒸汽费", "总蒸汽费密度"],
                "data" => $dailyDatas,
            ]
            //"compareTotalVal" => $compareTotalVal,
        ];

        return makeSuccessMsg($res);
    }

}