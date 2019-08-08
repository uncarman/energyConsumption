<?php

namespace App\Http\Controllers\Settings;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsSummaryController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request)
    {
        return view('single.settings.summary');
    }

    public function groupView(Request $request)
    {
        return view('single.settings.group_view');
    }

    public function groupEdit(Request $request)
    {
        return view('single.settings.group.edit');
    }

    public function ajaxGroupTree($buildingId, Request $request) {
        $building_id = $buildingId;
        $building = $this->bs->instance("db")->getBuildingDetail($buildingId);
        $res = [];
        $tmp = [];
        if(!empty($building_id)) {
            $group_types = $this->bs->instance("db")->getBuildingGroupTypes($building_id);
            if(!empty($group_types)) {
                foreach ($group_types as $group) {
                    $_res = [
                        "id" => "-".$group->id,
                        "name" => $group->name,
                        "children" => []
                    ];
                    $datas = $this->bs->instance("db")->getBuildingGroups($building_id, $group->id);
                    if (!empty($datas)) {
                        foreach ($datas as $d) {
                            if ($d->parent_id == 0) {
                                $tmp[$d->id] = [];
                                $_res["children"][] = [
                                    "id" => $d->id,
                                    "name" => $d->name,
                                    "children" => $tmp[$d->id]
                                ];
                            } else {
                                $tmp[$d->parent_id][] = [
                                    "id" => $d->id,
                                    "name" => $d->name,
                                    "children" => []
                                ];
                            }
                        }
                    }
                    // 将$tmp给$res
                    if (!empty($tmp)) {
                        foreach ($_res["children"] as &$r) {
                            $r["children"] = $tmp[$r["id"]];
                        }
                    }
                    $res[] = $_res;
                }
            }
        }
        return makeSuccessMsg([
            "building" => $building,
            "groups" => $res
        ]);
    }
}