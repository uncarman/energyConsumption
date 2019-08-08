<?php

namespace App\Service;

use App\Service\Impl\SamServerImpl;

class SamServer implements SamServerImpl {

    public function fun1() {
        echo __CLASS__."fun1";
        return __CLASS__."fun1";
    }

    public function fun2() {
        echo __CLASS__."fun2";
        return __CLASS__."fun2";
    }
}