<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider AS ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Policies\Dashboardpolicy;
use App\Models\Produk;
use App\Policies\Produkpolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => Dashboardpolicy::class,
        Produk::class => Produkpolicy::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
