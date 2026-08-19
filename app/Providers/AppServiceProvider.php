<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // 1. Wajib di-import

use App\Models\User;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use App\Policies\DashboardPolicy;
use App\Policies\ProdukPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\ItemPenjualanPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => DashboardPolicy::class,
        Produk::class => ProdukPolicy::class,
        Penjualan::class => PenjualanPolicy::class,
        ItemPenjualan::class => ItemPenjualanPolicy::class,
    ];

    /**
     * Register any application services.
     */
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

        // 2. Registrasikan seluruh array $policies ke Gate
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}