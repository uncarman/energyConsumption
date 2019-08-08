<?php

namespace App\Service;

use App\Service\Database\BuildingService as bdDb;

class BuildingServiceApi {

    private $bdDb;

    ////////////////////// 实例化 service ////////////////////////////
    function instance($serv, $type=null) {
        if($serv == "db") {
            $this->bdDb = empty($this->bdDb) ? new bdDb() : $this->bdDb;
            return $this->bdDb;
        } else {
            throw new \Exception("没有对应的service服务:",$serv);
        }
    }

}