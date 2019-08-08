<?php

namespace App\Http\Controllers\Building;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs) {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index($building_id, Request $request) {
        return view('building.groups', compact("building_id"));
    }

    public function ajaxGroupTree(Request $request) {
        $building_id = $request->get("bid", "");
        $res = [];
        $tmp = [];
        if(!empty($building_id)) {
            $group_types = $this->bs->instance("db")->getBuildingGroupTypes($building_id);
            if(!empty($group_types)) {
                foreach ($group_types as $group) {
                    $_res = [
                        "id" => "-".$group->group_type,
                        "name" => $group->tcname,
                        "children" => []
                    ];
                    $datas = $this->bs->instance("db")->getBuildingGroups($building_id, $group->group_type);
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
        return makeSuccessMsg($res);
    }
}
