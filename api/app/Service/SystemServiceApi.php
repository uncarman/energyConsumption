<?php

namespace App\Service;

use App\Service\Database\SystemService as sysDb;

class SystemServiceApi {

    private $sysDb;

    ////////////////////// 实例化 service ////////////////////////////
    function instance($serv, $type=null) {
        if($serv == "sysDb") {
            $this->sysDb = empty($this->sysDb) ? new sysDb() : $this->sysDb;
            return $this->sysDb;
        } else {
            throw new \Exception("没有对应的service服务:",$serv);
        }
    }

}