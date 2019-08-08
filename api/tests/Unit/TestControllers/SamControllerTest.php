<?php

namespace Tests\Unit\TestControllers;

use App\Service\Impl\SamServerImpl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\SamController;
use Tests\FakeServers\FakeSamServer;

class SamControllerTest extends TestCase
{
    public function testSamControllerFun1Test()
    {
        $stub = $this->createMock(SamServerImpl::class);
        $stub->method('fun1')->will($this->returnValue("fake_fun1"));
        $this->app->singleton(SamServerImpl::class, function () use ($stub) {
            return $stub;
        });
        $samController = new SamController();
        $this->assertEquals($samController->fun1(), "fake_fun1");
    }

    public function testSamControllerFun2Test()
    {
        $stub = $this->createMock(SamServerImpl::class);
        $stub->method('fun2')->will($this->returnValue("fake_fun2"));
        $this->app->singleton(SamServerImpl::class, function () use ($stub) {
            return $stub;
        });
        $samController = new SamController();
        $this->assertEquals($samController->fun2(), "fake_fun2");
    }
}
