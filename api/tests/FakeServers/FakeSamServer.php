<?php

namespace Tests\FakeServers;

use App\Service\Impl\SamServerImpl;

class FakeSamServer implements SamServerImpl {

    public $result_fun1 = "";
    public $result_fun2 = "";

    function fun1() {
        return $this->result_fun1;
    }
    function fun2() {
        return $this->result_fun2;
    }
}