<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy;

use Illuminate\Support\ServiceProvider;

class SoapyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(SoapyTub::class, function() {
            return new SoapyTub();
        });
    }
}
