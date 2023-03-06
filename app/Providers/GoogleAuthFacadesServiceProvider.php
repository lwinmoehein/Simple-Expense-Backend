<?php

namespace App\Providers;

use App\Services\GoogleAuth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class GoogleAuthFacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        App::bind('googleAuth',function() {
            return new  GoogleAuth();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
