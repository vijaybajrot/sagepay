<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Services\Sage\SagePay;
use Services\Sage\SagepayFormApi as SageApi;
use Services\Sage\SagepaySettings;

class SagePayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SagePay',function (){
            return new SagePay(
                new SageApi(
                    new SagepaySettings(config("sage"))
                )
            );
        });
    }
}
