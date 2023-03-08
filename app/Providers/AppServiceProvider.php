<?php

namespace App\Providers;

use App\Repositories\CategoryMySQLRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionMySQLRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserMySQLRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->app->bind(UserRepository::class, UserMySQLRepository::class);
        $this->app->bind(CategoryRepository::class, CategoryMySQLRepository::class);
        $this->app->bind(TransactionRepository::class, TransactionMySQLRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
