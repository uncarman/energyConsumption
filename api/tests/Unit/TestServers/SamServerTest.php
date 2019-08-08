<?php

namespace Tests\Unit\TestServers;

use App\Service\Impl\SamServerImpl;
use Tests\TestCase;

class SamServerTest extends TestCase
{

    public function testSamServerFun1Test()
    {
        $server = $this->app->make(SamServerImpl::class);
        $this->assertContains("fun1", $server->fun1());
    }

    public function testSamServerFun2Test()
    {
        $server = $this->app->make(SamServerImpl::class);
        $this->assertContains("fun2", $server->fun2());
    }
}