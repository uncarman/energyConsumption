<?php

namespace App\Http\Controllers\Gather;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GatherController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function map(Request $request)
    {
        return view('multiple.map');
    }

    public function list(Request $request)
    {
        return view('multiple.list');
    }

    public function ajaxBuildingList(Request $request) {
        $userId = $this->getUser()["id"];
        $buildings = $this->bs->instance("db")->getUserBuildingList($userId);
        return makeSuccessMsg([
            "buildingList" => [
                "title" => [
                    "id" => "编号",
                    "photo" => "图片",
                    "name" => "名称",
                    "address" => "地址",
                    "area" => "面积",
                    "capacity_text" => "用能概述",
                    "status" => "状态",
                    "type" => "类型",
                    "note" => "备注",
                ],
                "data" => $buildings
            ]
        ]);
    }

}