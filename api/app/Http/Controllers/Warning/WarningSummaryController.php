<?php

namespace App\Http\Controllers\Warning;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WarningSummaryController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request)
    {
        return view('single.warning.summary');
    }

    public function alertSettings(Request $request)
    {
        return view('single.warning.alert_settings');
    }

    public function ajaxWarning($buildingId, Request $request) {
        $from = $request->get("from", date("Y-m-01"));
        $to = $request->get("to", date("Y-m-d"));
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);

        $warningList = [];
        $ammaters = $this->bs->instance("db")->getBuildingAmmeters($buildingId);
        $ind = max([rand(1, count($ammaters)-1), 0]) ;
        $rand_ammeter = $ammaters[$ind];
        for($i=1; $i<10; $i++) {
            $actual_use = rand(100, 500);
            $plant_use = $actual_use - rand(10, 50);
            $warningList[] = [
                "id" => 10000+$i,
                "type" => "能耗计划",
                "recorded_at" => date("Y-m-d H:i:s", strtotime("-$i days")+rand(0,10000)),
                "device_name" => $rand_ammeter->name,
                "device_type" => $rand_ammeter->type,
                "plant_use" => $plant_use,
                "actual_use" => $actual_use,
                "present" => round(($actual_use - $plant_use) / $actual_use * 100, 2) . "%",
            ];
        }

        $types = $this->bs->instance("db")->getBuildingGroupTypes();

        $res = [
            "from" => $from,
            "to" => $to,
            "types" => $types,
            "warningSummary" => [
                [
                    "name" => "电",
                    "unDealNum" => 2,
                    "monthNum" => 2,
                    "totalNum" => 5,
                ],
                [
                    "name" => "水",
                    "unDealNum" => 0,
                    "monthNum" => 0,
                    "totalNum" => 0,
                ],
                [
                    "name" => "天然气",
                    "unDealNum" => 0,
                    "monthNum" => 0,
                    "totalNum" => 0,
                ],
                [
                    "name" => "蒸汽",
                    "unDealNum" => 0,
                    "monthNum" => 0,
                    "totalNum" => 0,
                ],
                [
                    "name" => "室内环境",
                    "unDealNum" => 0,
                    "monthNum" => 0,
                    "totalNum" => 0,
                ]
            ],
            "warningList" => [
                "title" => [
                    "id" => "序号",
                    "type" => "报警类型",
                    "recorded_at" => "报警时间",
                    "device_name" => "设备名称",
                    "device_type" => "设备类型",
                    "plant_use" => "计划使用(kwh)",
                    "actual_use" => "实际使用(kwh)",
                    "present" => "超出比例",
                ],
                "data" => $warningList,
            ]
        ];
        return makeSuccessMsg($res);
    }

    public function ajaxAlertList($buildingId, Request $request) {
        $from = $request->get("from", date("Y-m-01"));
        $to = $request->get("to", date("Y-m-d"));
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);

        $res = [
            "warningList" => [
                "title" => [
                    "id" => "序号",
                    "type_txt" => "报警类型",
                    "name" => "管理员",
                    "sendTo" => "发送",
                    "from" => "最早时间",
                    "to" => "最晚时间",
                    "span" => "时间间隔(分钟)",
                    "status" => "状态",
                ],
                "data" => [
                    [
                        "id" => 1,
                        "type" => "email",
                        "type_txt" => "邮件",
                        "name" => "老王",
                        "sendTo" => "sam@123.com",
                        "from" => "08:00",
                        "to" => "21:00",
                        "span" => "60",
                        "status" => "正常",
                    ],
                    [
                        "id" => 1,
                        "type" => "sms",
                        "type_txt" => "短信",
                        "name" => "老王",
                        "sendTo" => "15821111111",
                        "from" => "08:00",
                        "to" => "21:00",
                        "span" => "60",
                        "status" => "正常",
                    ]
                ],
            ]
        ];
        return makeSuccessMsg($res);
    }

}