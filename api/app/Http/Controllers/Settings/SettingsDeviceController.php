<?php

namespace App\Http\Controllers\Settings;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsDeviceController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request)
    {
        return view('single.settings.device_list');
    }

    public function ajaxDeviceList($buildingId, Request $request) {
        $building_id = $buildingId;
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);
        $collecors =$this->bs->instance("db")->getBuildingCollectors($buildingId);
        $meters =$this->bs->instance("db")->getBuildingMeters($buildingId);
        $deviceList = [];
        if(!empty($building_id)) {

        }
        return makeSuccessMsg([
            "building" => $building,
            "collecors" => $collecors,
            "meters" => $meters,
            "collectorList" => [
                "title" => [
                    "id" => "编号",
                    "type_txt" => "类型",
                    "name" => "名称",
                    "sn" => "SN",
                    "from" => "厂家",
                    "sim" => "sim",
                    "note" => "备注"
                ],
                "data" => $collecors,
            ],
            "meterList" => [
                "title" => [
                    "id" => "编号",
                    "type_txt" => "类型",
                    "name" => "名称",
                    "sn" => "SN",
                    "is_main" => "主表",
                    "rate" => "倍率",
                    "note" => "备注"
                ],
                "data" => $meters
            ],
        ]);
    }
}