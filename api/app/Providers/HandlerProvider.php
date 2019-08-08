<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class HandlerProvider extends ServiceProvider
{
    function __construct($app) {
        parent::__construct($app);
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Service\Impl\SamServerImpl',
            'App\Service\SamServer'
        );
    }
}
