<?php
namespace App\Http\Controllers\Api;
use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ApiController extends Controller
{
    protected $bs;
    public function __construct(BuildingServiceApi $bs) {
        parent::__construct();
        $this->bs = $bs;
    }
    public function syncMeterData(Request $request) {
        $type = $request->get("type", "");
        if(!empty($type)) {
            if($type == "ammeter") {
                return $this->syncAmmeterData($request);
            } else if($type == "watermeter") {
                return $this->syncWatermeterData($request);
            } else if($type == "energymeter") {
                return $this->syncEnergymeterData($request);
            } else {
                return makeFailedMsg("类型错误: ".$type);
            }
        } else {
            return makeFailedMsg("缺少类型");
        }
    }
    private function syncAmmeterData(Request $request) {
        $meter_sn = $request->get("meter_sn", "");
        $collector_sn = $request->get("collector_sn", "");
        if(empty($meter_sn)) {
            return makeFailedMsg("缺少表sn号");
        }
        if(empty($request->get("positive_active_power")) || empty($request->get("reverse_active_power"))) {
            return makeFailedMsg("缺少数据");
        }
        $meter = $this->bs->instance("db")->getAmmeterBySn($collector_sn, $meter_sn);
        if($meter) {
            $data = [
                "ammeter_id" => $meter->id,
                "positive_active_power" => $request->get("positive_active_power", 0),
                "reverse_active_power" => $request->get("reverse_active_power", 0),
                "other_data" => $request->get("other_data", ""),
                "recorded_at" => $request->get("record_time", date("Y-m-d H:i:s")),
            ];
            $this->bs->instance("db")->insertAmmeterData($data);
            return makeSuccessMsg();
        } else {
            return makeFailedMsg("没有对应表: meter_sn:".$meter_sn." collector_sn:".$collector_sn);
        }
    }
    private function syncWatermeterData(Request $request) {
        $meter_sn = $request->get("meter_sn", "");
        $collector_sn = $request->get("collector_sn", "");
        if(empty($meter_sn)) {
            return makeFailedMsg("缺少表sn号");
        }
        if(empty($request->get("indication"))) {
            return makeFailedMsg("缺少数据");
        }
        $meter = $this->bs->instance("db")->getWatermeterBySn($collector_sn, $meter_sn);
        if($meter) {
            $data = [
                "watermeter_id" => $meter->id,
                "indication" => $request->get("indication", 0),
                "other_data" => $request->get("other_data", ""),
                "recorded_at" => $request->get("record_time", date("Y-m-d H:i:s")),
            ];
            $this->bs->instance("db")->insertWatermeterData($data);
            return makeSuccessMsg();
        } else {
            return makeFailedMsg("没有对应表: meter_sn:".$meter_sn." collector_sn:".$collector_sn);
        }
    }
    private function syncEnergymeterData(Request $request) {
        $meter_sn = $request->get("meter_sn", "");
        $collector_sn = $request->get("collector_sn", "");
        if(empty($meter_sn)) {
            return makeFailedMsg("缺少表sn号");
        }
        if(empty($request->get("indication"))) {
            return makeFailedMsg("缺少数据");
        }
        $meter = $this->bs->instance("db")->getEnergymeterBySn($collector_sn, $meter_sn);
        if($meter) {
            $data = [
                "energymeter_id" => $meter->id,
                "indication" => $request->get("indication", 0),
                "other_data" => $request->get("other_data", ""),
                "recorded_at" => $request->get("record_time", date("Y-m-d H:i:s")),
            ];
            $this->bs->instance("db")->insertEnergymeterData($data);
            return makeSuccessMsg();
        } else {
            return makeFailedMsg("没有对应表: ammeter_sn:".$meter_sn." collector_sn:".$collector_sn);
        }
    }
}