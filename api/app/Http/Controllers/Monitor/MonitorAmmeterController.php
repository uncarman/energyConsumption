<?php

namespace App\Http\Controllers\Monitor;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonitorAmmeterController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request)
    {
        return view('single.monitor.ammeter');
    }

    public function ammeterByType(Request $request)
    {
        return view('single.monitor.ammeter_by_type');
    }

    public function ajaxAmmeterSummary($buildingId, Request $request) {
        $from = $request->get("from", date("Y-m-01"));
        $to = $request->get("to", date("Y-m-d"));
        $compareToYear = $request->get("compareTo", date("Y", strtotime("-1 years")));
        $lastMonth = date("Y-m", strtotime("-1 months"));
        $compareToFrom = date($compareToYear."-m-d" , strtotime($from));
        $compareToTo = date($compareToYear."-m-d" , strtotime($to));
        $type = $request->get("type", "day");
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);
        $feePolicy = !empty(json_decode($building->fee_policy, true)) ? json_decode($building->fee_policy, true) : [];
        $types = $this->bs->instance("db")->getBuildingGroupTypes();
        // 总用电量
        $env = [
            "coal" => 0.325,
            "co2" => 0.9171,
            "so2" => 0.0023,
            "nox" => 0.0037,
            "smoke" => 0.0004,
            "tree" => 0.9171 / 18.334,
        ];
        $totalVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId);
        $currentMonthVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y-m"), "month");
        $lastMonthVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, $lastMonth, "month");
        $currentYearVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, date("Y"), "year");
        $compareToYearVal = $this->bs->instance("db")->buildingAmmeterSummary($buildingId, $compareToYear, "year");
        // 根据type显示图表数据
        $chartDatas = $this->bs->instance("db")->buildingAmmeterSummaryDatas($buildingId, $type, $from, $to);
        $chartDatas = [
            "datas" => array_map(function($d){
                return [
                    "val" => $d->val,
                    "key" => $d->record_date
                ];
            }, $chartDatas),
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "kwh",
            "prop_area" => $building->area,
            "name" => "用电量",
            "area" => $building->area,
            "coal" => $env["coal"],
            "co2" => $env["co2"],
            "fee_policy" => $feePolicy["ammeter"],
        ];
        $chartCompareDatas = $this->bs->instance("db")->buildingAmmeterSummaryDatas($buildingId, $type, $compareToFrom, $compareToTo);
        $chartCompareDatas = [
            "datas" => array_map(function($d){
                return [
                    "val" => $d->val,
                    "key" => $d->record_date
                ];
            }, $chartCompareDatas),
            "key" => "record_date",
            "val" => "useValue",
            "unit" => "kwh",
            "prop_area" => $building->area,
        ];
        //$summaryDatas = $this->bs->instance("db")->buildingAmmeterSummaryDatas($buildingId, $lastYear);
        //$summaryDatasMonthly = $this->bs->instance("db")->buildingAmmeterGroupsSummaryMonth($buildingId, $from, $to);
        $res = [
            "from" => $from,
            "to" => $to,
            "building" => $building,
            "types" => $types,
            "typeGroups" => [],
            "old" => [
                $totalVal, $currentMonthVal, $lastMonthVal, $currentYearVal, $compareToYearVal
            ],
            "summaryData" => [
                "internationalValue" => 0.15,  // 国际能耗标准值

                "totalName" => "总用电量",
                "totalUnit" => "kwh",
                "total" => $totalVal->val,
                "totalCompareMonth" => $lastMonthVal->val > 0 ? ($currentMonthVal->val-$lastMonthVal->val)*100/$currentMonthVal->val : "0",
                "totalCompareYear" => $compareToYearVal->val > 0 ? ($currentYearVal->val-$compareToYearVal->val)*100/$currentYearVal->val : "0",

                "total1Name" => "当量标煤(吨)",
                "total1Unit" => "吨",
                "total1" => $totalVal->val * $env["coal"],
                "totalCompare1Month" => $lastMonthVal->val > 0 ? ($currentMonthVal->val-$lastMonthVal->val)*100/$currentMonthVal->val : "0",
                "totalCompare1Year" => $compareToYearVal->val > 0 ? ($currentYearVal->val-$compareToYearVal->val)*100/$currentYearVal->val : "0",

                "total2Name" => "累计碳排放量(吨)",
                "total2Unit" => "吨",
                "total2" => $totalVal->val * $env["co2"],
                "totalCompare2Month" => $lastMonthVal->val > 0 ? ($currentMonthVal->val-$lastMonthVal->val)*100/$currentMonthVal->val : "0",
                "totalCompare2Year" => $compareToYearVal->val > 0 ? ($currentYearVal->val-$compareToYearVal->val)*100/$currentYearVal->val : "0",

                "total3Name" => "能耗密度",
                "total3Unit" => "kwh/m2",
                "total3" => $totalVal->val / $building->area,
                "totalCompare3Month" => $lastMonthVal->val > 0 ? ($currentMonthVal->val-$lastMonthVal->val)*100/$currentMonthVal->val : "0",
                "totalCompare3Year" => $compareToYearVal->val > 0 ? ($currentYearVal->val-$compareToYearVal->val)*100/$currentYearVal->val : "0",

                "total4Name" => "费用",
                "total4Unit" => "元",
                "total4" => $totalVal->val * $feePolicy["ammeter"],
                "totalCompare4Month" => $lastMonthVal->val > 0 ? ($currentMonthVal->val-$lastMonthVal->val)*100/$currentMonthVal->val : "0",
                "totalCompare4Year" => $compareToYearVal->val > 0 ? ($currentYearVal->val-$compareToYearVal->val)*100/$currentYearVal->val : "0",
            ],

            "chartDatas" => $chartDatas,
            "chartCompareDatas" => $chartCompareDatas,

            "totalVal" => $totalVal->val,
            //"compareTotalVal" => $compareTotalVal,
        ];

        return makeSuccessMsg($res);
    }

    public function ajaxAmmeterGroupsSummaryDaily($buildingId, $groupTypeId, Request $request)
    {
        $from = $request->get("from", date("Y-m-01"));
        $to = $request->get("to", date("Y-m-d"));
        $parentId = $request->get("pid", 0);
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);
        $types = $this->bs->instance("db")->getBuildingGroupTypes();
        $typeGroups = $this->bs->instance("db")->getBuildingGroups($buildingId, $groupTypeId);
        $groups = $this->bs->instance("db")->buildingAmmeterGroupsSummaryDaily($buildingId, $groupTypeId, $parentId, $from, $to);
        $res = [
            "from" => $from,
            "to" => $to,
            "building" => $building,
            "types" => $types,
            "typeGroups" => $typeGroups,
            "dailyDatas" => [],
            "summaryDatas" => [],
        ];
        $keys = [];
        array_map(function ($g) use (&$res, &$keys) {
            // 格式图表数据
            if(in_array($g->name, $keys)) {
                $ind = array_search($g->name, $keys);
                $res["dailyDatas"][$ind]["datas"][] = [
                    "val" => $g->val,
                    "key" => $g->record_date
                ];
            } else {
                $res["dailyDatas"][] = [
                    "datas" => [
                        [
                            "val" => $g->val,
                            "key" => $g->record_date
                        ]
                    ],
                    "key" => "record_date",
                    "val" => "useValue",
                    "unit" => "kwh",
                    "prop_area" => $g->prop_area,
                    "prop_num" => $g->prop_num,
                    "name" => $g->name,
                    "gid" => $g->id,
                ];
                array_push($keys, $g->name);
            }
        } , $groups);
        return makeSuccessMsg($res);
    }
}