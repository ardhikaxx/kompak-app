<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (auth()->check()) {
                $stokRendahItems = \App\Models\Produk::where('stok', '<=', \Illuminate\Support\Facades\DB::raw('stok_minimum'))
                    ->where('is_active', true)
                    ->orderBy('stok', 'asc')
                    ->limit(5)
                    ->get();
                $stokRendahCount = \App\Models\Produk::where('stok', '<=', \Illuminate\Support\Facades\DB::raw('stok_minimum'))
                    ->where('is_active', true)
                    ->count();
                
                $view->with('stokRendahCount', $stokRendahCount);
                $view->with('stokRendahItems', $stokRendahItems);
            } else {
                $view->with('stokRendahCount', 0);
                $view->with('stokRendahItems', collect());
            }

            // Store Settings
            $storeName = \App\Models\Setting::get('nama_toko', 'KOMPAK UMKM');
            $storeAddress = \App\Models\Setting::get('alamat_toko', 'Jl. Contoh No. 123, Indonesia');
            $storePhone = \App\Models\Setting::get('telepon_toko', '08123456789');
            
            $view->with('storeName', $storeName);
            $view->with('storeAddress', $storeAddress);
            $view->with('storePhone', $storePhone);
        });
    }
}
