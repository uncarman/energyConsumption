<?php

namespace App\Service;

use App\Service\Database\SystemService as sysDb;

class EnterpriseServiceApi {

    private $sysDb;

    ////////////////////// 实例化 service ////////////////////////////
    function instance($serv, $type=null) {
        if($serv == "epDb") {
            $this->epDb = empty($this->epDb) ? new epDb() : $this->epDb;
            return $this->epDb;
        } else {
            throw new \Exception("没有对应的service服务:",$serv);
        }
    }

}