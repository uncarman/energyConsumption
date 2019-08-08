<?php

namespace App\Http\Controllers\Building;

use App\Service\BuildingServiceApi;
use App\Service\Utils\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuildingController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs) {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request) {
        $name = $request->get('name', "");
        $currPage = $request->get('page', 1);
        $buildings = new PageService($this->bs->instance("db")->getBuildingList($name), 15, $currPage);
        return view('building.index', compact("buildings"));
    }

    public function show($id) {
        $building = $this->bs->instance("db")->getBuildingDetail($id);
        return view('building.view', compact("building"));
    }

    public function edit($id) {
        $building = $this->bs->instance("db")->getBuildingDetail($id);
        return view('building.edit', compact("building"));
    }

    public function create($id) {
        $building = $this->bs->instance("db")->getBuildingDetail($id);
        return view('building.create');
    }

    public function ajaxTableData($table_name, Request $request) {
        $currPage = $request->get('page', 1);
        $datas = new PageService($this->ss->instance("sysDb")->getTableData($table_name), 15, $currPage);
        return makeSuccessMsg($datas);
    }



    public function update(Request $request, $id) {
        $building = $this->bs->instance("db")->getBuildingDetail($id);
    }

    public function destroy($id) {
        //
    }
}
