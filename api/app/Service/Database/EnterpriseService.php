<?php

namespace App\Service\Database;

use UUID;

class EnterpriseService
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

    public function getEnterpriseList($name = "") {
        if(!empty($name)) {
            $where = " and name like '%".$name."%'";
        } else {
            $where = "";
        }
        $sql = "
            select
                *
            from enterprise
            where 1=1 
        ".$where;
        $res = $this->db->select($sql);
        return empty($res) ? [] : $res;
    }

    public function getEnterpriseDetail($id) {

    }

}