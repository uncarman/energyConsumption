<?php

namespace App\Service\Database;

use UUID;

class BuildingService
{
    protected $db;

    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $this->db = \DB::connection();
        }
    }

    public function getUserBuildingList($userId, $name="") {
        if (!empty($name)) {
            $where = " and b.name like '%" . $name . "%'";
        } else {
            $where = "";
        }
        $sql = "
            select
                b.*
            from building_base b
            LEFT JOIN user_building_map bm on bm.building_id = b.id
            where bm.user_id = :userId
        " . $where;
        $res = $this->db->select($sql, ["userId" => $userId]);
        return empty($res) ? [] : $res;
    }

    public function getBuildingList($name = "")
    {
        if (!empty($name)) {
            $where = " and name like '%" . $name . "%'";
        } else {
            $where = "";
        }
        $sql = "
            select
                b.*
            from building_base b
            where 1=1 
        " . $where;
        $res = $this->db->select($sql);
        return empty($res) ? [] : $res;
    }

    public function getBuildingDetail($id)
    {
        $sql = "
            select
                *
            from building_base
            where id=:id 
        ";
        $res = $this->db->select($sql, ["id" => $id]);
        return empty($res) ? [] : head($res);
    }

    public function getBuildingCollectors($buildingId) {
        $sql = "
            select
                c.*,
                'collector' as type,
                '采集器' as type_txt
            from collector c
            where build_id=:buildingId 
                and status = '正常'
        ";
        $res = $this->db->select($sql, ["buildingId" => $buildingId]);
        return empty($res) ? [] : $res;
    }

    public function getBuildingMeters($buildingId) {
        $sql = "
        select
        *
        FROM (
            select
                a.build_id as bid,
                a.id as id,
                a.name as name,
                a.sn as sn,
                a.collector_id as cid,
                a.is_main as is_main,
                a.rate as rate,
                a.note as note,
                'ammeter' as type,
                '电表' as type_txt
            from ammeter a
            where a.status = '正常'
            UNION
            select
                w.build_id as bid,
                w.id as id,
                w.name as name,
                w.sn as sn,
                w.collector_id as cid,
                w.is_main as is_main,
                w.rate as rate,
                w.note as note,
                'watermeter' as type,
                '水表' as type_txt
            from watermeter w
            where w.status = '正常'
        ) totalmeter where totalmeter.bid = :buildingId
        ";
        $res = $this->db->select($sql, ["buildingId" => $buildingId]);
        return empty($res) ? [] : $res;
    }

    public function getAmmeterBySn($collectorSn, $meterSn)
    {
        $sql = "
            SELECT
                a.*
            from ammeter a 
            LEFT JOIN collector c on a.collector_id = c.id
              where a.sn =:meterSn  and c.sn = :collectorSn
       ";
        $res = $this->db->select($sql, ["meterSn" => $meterSn, "collectorSn" => $collectorSn]);
        return empty($res) ? [] : head($res);
    }

    public function insertAmmeterData($params)
    {
        return $this->db->table("ammeter_data")
            ->insert(["ammeter_id" => $params['ammeter_id'],
                "positive_active_power" => $params['positive_active_power'],
                "reverse_active_power" => $params['reverse_active_power'],
                "other_data" => $params['other_data'],
                "recorded_at" => $params['recorded_at'],
            ]);
    }

    public function getWatermeterBySn($collectorSn, $meterSn)
    {
        $sql = "
            SELECT
                a.*
            from watermeter a 
            LEFT JOIN collector c on a.collector_id = c.id
              where a.sn =:meterSn  and c.sn = :collectorSn
       ";
        $res = $this->db->select($sql, ["meterSn" => $meterSn, "collectorSn" => $collectorSn]);
        return empty($res) ? [] : head($res);
    }

    public function insertWatermeterData($params)
    {
        return $this->db->table("watermeter_data")
            ->insert(["watermeter_id" => $params['watermeter_id'],
                "indication" => $params['indication'],
                "other_data" => $params['other_data'],
                "recorded_at" => $params['recorded_at'],
            ]);
    }

    public function getEnergymeterBySn($collectorSn, $meterSn)
    {
        $sql = "
            SELECT
                a.*
            from energymeter a 
            LEFT JOIN collector c on a.collector_id = c.id
              where a.sn =:meterSn  and c.sn = :collectorSn
       ";
        $res = $this->db->select($sql, ["meterSn" => $meterSn, "collectorSn" => $collectorSn]);
        return empty($res) ? [] : head($res);
    }

    public function insertEnergymeterData($params)
    {
        return $this->db->table("energymeter_data")
            ->insert(["energymeter_id" => $params['energymeter_id'],
                "indication" => $params['indication'],
                "other_data" => $params['other_data'],
                "recorded_at" => $params['recorded_at'],
            ]);
    }


    // 综合数据


    public function getUserBuildingSummary($userId, $type)
    {
        if ($type == "ammeter") {
            return $this->getUserBuildingAmmeterSummary($userId);
        } else if ($type == "watermeter") {
            return $this->getUserBuildingWatermeterSummary($userId);
        } else if ($type == "energymeter") {
            return $this->getUserBuildingEnergymeterSummary($userId);
        }
        return [];
    }

    public function getUserBuildingAmmeterSummary($userId)
    {
        $sql = "
            select 
                sum(g.diff) as total
            from (
                SELECT
                    max(ad.positive_active_power) - min(ad.positive_active_power) as diff,
                    am.build_id,
                    am.id
                from ammeter_data ad
                right join (
                        select
                            a.*
                        from ammeter a
                        LEFT JOIN user_building_map bm on bm.building_id = a.build_id
                        where a.is_main = 1 and a.status = '正常' and bm.user_id = :userId
                ) am on am.id = ad.ammeter_id
                group by am.build_id, am.id
            ) g
       ";
        $res = $this->db->select($sql, ["userId" => $userId]);
        return empty($res) ? [] : head($res);
    }

    public function getUserBuildingWatermeterSummary($userId)
    {
        $sql = "
            select 
                sum(g.diff) as total
            from (
                SELECT
                    max(ad.indication) - min(ad.indication) as diff,
                    am.build_id,
                    am.id
                from watermeter_data ad
                right join (
                        select
                            a.*
                        from watermeter a
                        LEFT JOIN user_building_map bm on bm.building_id = a.build_id
                        where a.is_main = 1 and a.status = '正常' and bm.user_id = :userId
                ) am on am.id = ad.watermeter_id
                group by am.build_id, am.id
            ) g
       ";
        $res = $this->db->select($sql, ["userId" => $userId]);
        return empty($res) ? [] : head($res);
    }

    public function getUserBuildingEnergymeterSummary($userId)
    {
        $sql = "
            select 
                sum(g.diff) as total
            from (
                SELECT
                    max(ad.indication) - min(ad.indication) as diff,
                    am.build_id,
                    am.id
                from energymeter_data ad
                right join (
                        select
                            a.*
                        from energymeter a
                        LEFT JOIN user_building_map bm on bm.building_id = a.build_id
                        where a.is_main = 1 and a.status = '正常' and bm.user_id = :userId
                ) am on am.id = ad.energymeter_id
                group by am.build_id, am.id
            ) g
       ";
        $res = $this->db->select($sql, ["userId" => $userId]);
        return empty($res) ? [] : head($res);
    }

    // 用户所有表数据
    public function getUserMeters($userId, $type)
    {
        if ($type == "ammeter") {
            return $this->getUserAmmeters($userId);
        } else if ($type == "watermeter") {
            return $this->getUserWatermeters($userId);
        } else if ($type == "energymeter") {
            return $this->getUserEnergymeters($userId);
        }
        return [];
    }

    public function getUserAmmeters($userId)
    {
        $sql = "
            select
              a.*,
              b.*,
              ad.*
            from ammeter a
            LEFT JOIN user_building_map bm on bm.building_id = a.build_id
            LEFT JOIN building_base b on b.id = a.build_id
            LEFT JOIN (
                SELECT
                    ammeter_id,
                    max(positive_active_power) - min(positive_active_power) as total_power
                from ammeter_data
              group by ammeter_id
            ) ad on ad.ammeter_id = a.id
            where a.is_main = 1 and a.status = '正常' and bm.user_id = :userId
       ";
        $res = $this->db->select($sql, ["userId" => $userId]);
        return empty($res) ? [] : $res;
    }


    // 用户所有表数据
    public function getMeterDatas($deviceId, $type, $dateType, $from, $to)
    {
        if ($type == "ammeter") {
            return $this->getAmmeterDatas($deviceId, $type, $dateType, $from, $to);
        } else if ($type == "watermeter") {
            return $this->getWatermeterDatas($deviceId, $type, $dateType, $from, $to);
        } else if ($type == "energymeter") {
            return $this->getEnergymeterDatas($deviceId, $type, $dateType, $from, $to);
        }
        return [];
    }

    public function getAmmeterDatas($deviceId, $type, $dateType, $from, $to)
    {
        if ($dateType == "hour") {
            return $this->getAmmeterDatasByHour($deviceId, $type, $dateType, $from, $to);
        } else if ($dateType == "day") {
            return $this->getWatermeterDatasByDay($deviceId, $type, $dateType, $from, $to);
        } else if ($dateType == "month") {
            return $this->getEnergymeterDatasByMonth($deviceId, $type, $dateType, $from, $to);
        } else if ($dateType == "year") {
            return $this->getEnergymeterDatasByYear($deviceId, $type, $dateType, $from, $to);
        }
        return [];
    }
    public function getAmmeterDatasByHour($deviceId, $from, $to) {
        $where = "";
        if(!empty($from)) {
            $where = " and ammeter_data.recorded_at >= '".$from."' ";
        }
        if(!empty($to)) {
            $where = " and ammeter_data.recorded_at < '".$to."' ";
        }
        $sql = "
            select
              a.id,
              a.rate,
              b.id as bid,
              b.area,
              ad.*
            from ammeter a
            LEFT JOIN building_base b on b.id = a.build_id
            RIGHT JOIN (
                SELECT
                    ammeter_data.ammeter_id,
                    DATE_FORMAT(ammeter_data.recorded_at,'%Y-%m-%d %H:00:00') as date_time,
                    max(positive_active_power) - min(positive_active_power) as total_power
                from ammeter_data
                where ammeter_data.ammeter_id = :deviceId
                ".$where."
                group by ammeter_data.ammeter_id, DATE_FORMAT(ammeter_data.recorded_at,'%Y-%m-%d %H')
            ) ad on ad.ammeter_id = a.id
            where a.is_main = 1 and a.status = '正常'
            order by ad.date_time asc
       ";
        $res = $this->db->select($sql, ["deviceId" => $deviceId]);
        return empty($res) ? [] : $res;
    }


    // 楼宇所有表数据
    public function getBuildingAmmeters($building_id) {
        $sql = "
        select
            a.*,
            'ammeter' as type
        from ammeter as a
        where a.build_id = :buildingId
        ";
        $res = $this->db->select($sql, ["buildingId" => $building_id]);
        return empty($res) ? [] : $res;
    }


    // 跟组相关
    public function getBuildingGroupTypes() {
        $sql = "
            select
                tc.id, tc.val as name
            from type_category tc
            where tc.type='device_group_type'
        ";
        $res = $this->db->select($sql);
        return empty($res) ? [] : $res;
    }

    public function getBuildingGroups($building_id, $group_type) {
        $sql = "
            select
                dg.*
            from device_group dg
            where building_id = :buildingId and group_type = :groupType
            order by dg.parent_id asc, dg.id asc
        ";
        $res = $this->db->select($sql, ["buildingId" => $building_id, "groupType" => $group_type]);
        return empty($res) ? [] : $res;
    }


    // 电表数据汇总
    public function buildingAmmeterSummary($building_id, $date=null, $type=null) {
        // 根据 ammeter 中 is_main 来确认总表
        if(empty($date)) {
            // 所有数据
            $sql = "
                SELECT
                    sum(ad.val * a.rate) as val
                from ammeter a 
                    LEFT JOIN (
                        SELECT
                            ammeter_id,
                            max(positive_active_power) - min(positive_active_power) as val
                        from ammeter_data
                        GROUP BY ammeter_id
                    ) ad on ad.ammeter_id = a.id and a.status = '正常' and a.build_id=:buildingId and a.is_main = 1
            ";
            $res = $this->db->select($sql, ["buildingId" => $building_id]);
        } else {
            if($type == "year") {
                $dateFrom = $date;
                $dateTo = date("Y", strtotime("$date-01 +1 years"));
            } else if($type == "month") {
                $dateFrom = $date;
                $dateTo = date("Y-m", strtotime("+1 months $date"));
            }
            $sql = "
                SELECT
                    sum(IFNULL(ad.val,0) * a.rate) as val
                from ammeter a 
                    LEFT JOIN (
                        SELECT
                                ammeter_id,
                                max(positive_active_power) - min(positive_active_power) as val
                        from ammeter_data
                        where recorded_at >= :dateFrom and recorded_at < :dateTo
                        GROUP BY ammeter_id
                    ) ad on ad.ammeter_id = a.id and a.status = '正常' and a.build_id=:buildingId and a.is_main = 1
            ";
            $res = $this->db->select($sql, ["buildingId" => $building_id, "dateFrom" => $dateFrom, "dateTo" => $dateTo]);
        }
        return empty($res) ? [] : head($res);
    }

    public function buildingAmmeterSummaryDatas($building_id, $type, $from, $to) {
        $dateFrom = $from;
        if($type == "hour") {
            $groupType = "%Y-%m-%d %h";
            $dateTo = date("Y-m-d H", strtotime("+1 hours $to"));
        } else if($type == "day") {
            $groupType = "%Y-%m-%d";
            $dateTo = date("Y-m-d", strtotime("+1 days $to"));
        } else if($type == "month") {
            $groupType = "%Y-%m";
            $dateTo = date("Y-m", strtotime("+1 months $to"));
        } else {
            $groupType = "%Y";
            $dateTo = date("Y", strtotime("+1 years $to"));
        }
        $sql = "
        SELECT
              sum(IFNULL(ad.val,0) * a.rate) as val,
              ad.record_date
        from ammeter a 
            right JOIN (
                SELECT
                    ammeter_id,
                    max(positive_active_power) - min(positive_active_power) as val,
                    DATE_FORMAT(recorded_at, '".$groupType."') as record_date
                from ammeter_data
                where recorded_at >= :dateFrom and recorded_at <= :dateTo
                    GROUP BY ammeter_id, DATE_FORMAT(recorded_at, '".$groupType."')
            ) ad on ad.ammeter_id = a.id and a.status = '正常' and a.build_id=:buildingId and a.is_main = 1
        group by ad.record_date
        ";
        $res = $this->db->select($sql, ["buildingId" => $building_id, "dateFrom" => $dateFrom, "dateTo" => $dateTo]);
        return empty($res) ? [] : $res;
    }

    // 按日期输出类别内的电表总和
    public function buildingAmmeterGroupsSummaryDaily($buildingId, $groupTypeId, $parentId, $from, $to) {
        if(empty($buildingId) || empty($groupTypeId)) {
            return [];
        }

        if($parentId == 0) {
            // 获取当前类型下大类汇总
            $sql = "
                SELECT
                    t.id,
                    max(t.gname) as name,
                    max(t.prop_area) as prop_area,
                    max(t.prop_num) as prop_num,
                    sum(t.val) as val,
                    t.record_date
                from (
                    SELECT
                        dgp.id,
                        dgp.name as gname,
                        dgp.prop_area,
                        dgp.prop_num,
                        a.name as aname,
                        a.sn,
                        a.rate,
                        a.note,
                        ad.val * a.rate as val,
                        ad.record_date
                    from device_group dg
                        LEFT JOIN device_group dgp on dg.parent_id = dgp.id
                        LEFT JOIN device_group_map dgm on dg.id = dgm.device_group_id
                        LEFT JOIN ammeter a on a.id = dgm.device_id and dgm.device_type = 'ammeter'
                        LEFT JOIN (
                            SELECT
                                ammeter_id,
                                max(positive_active_power) - min(positive_active_power) as val,
                                DATE_FORMAT(recorded_at, '%Y-%m-%d') as record_date
                            from ammeter_data
                            GROUP BY ammeter_id, DATE_FORMAT(recorded_at, '%Y-%m-%d')
                        ) ad on ad.ammeter_id = a.id
                    where dg.building_id = :buildingId and dg.group_type = :groupType
                        and a.status = '正常' and dgp.parent_id = :parentId
                        and ad.record_date >= :from and ad.record_date <= :to
                ) t
                GROUP BY t.id, t.record_date
                ORDER BY t.id asc, t.record_date asc
           ";
        } else {
            // 获取当前类型下某个大类下的子类汇总
            $sql = "
                SELECT
                    t.id,
                    max(t.gname) as name,
                    max(t.prop_area) as prop_area,
                    max(t.prop_num) as prop_num,
                    sum(t.val) as val,
                    t.record_date
                from (
                    SELECT
                        dg.id,
                        dg.name as gname,
                        dg.prop_area,
                        dg.prop_num,
                        a.name as aname,
                        a.sn,
                        a.rate,
                        a.note,
                        ad.val * a.rate as val,
                        ad.record_date
                    from device_group dg
                        LEFT JOIN device_group_map dgm on dg.id = dgm.device_group_id
                        LEFT JOIN ammeter a on a.id = dgm.device_id and dgm.device_type = 'ammeter'
                        LEFT JOIN (
                            SELECT
                                ammeter_id,
                                max(positive_active_power) - min(positive_active_power) as val,
                                DATE_FORMAT(recorded_at, '%Y-%m-%d') as record_date
                            from ammeter_data
                            GROUP BY ammeter_id, DATE_FORMAT(recorded_at, '%Y-%m-%d')
                        ) ad on ad.ammeter_id = a.id
                    where dg.building_id = :buildingId and dg.group_type = :groupType
                        and a.status = '正常' and dg.parent_id=:parentId
                        and ad.record_date >= :from and ad.record_date <= :to
                ) t
                GROUP BY t.id, t.record_date
                ORDER BY t.id asc, t.record_date asc
            ";
        }
        $res = $this->db->select($sql, [
            "buildingId" => $buildingId,
            "groupType" => $groupTypeId,
            "parentId" => $parentId,
            "from" => $from, "to" => $to
        ]);
        return empty($res) ? [] : $res;
    }

}