<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service\Impl\SamServerImpl;


class SamController extends Controller
{
    private $samServer;

    function __construct()
    {
        parent::__construct();
        $this->samServer = $this->app->make(SamServerImpl::class);
    }

    public function fun1 () {
        return $this->samServer->fun1();
    }

    public function fun2 () {
        return $this->samServer->fun2();
    }
}