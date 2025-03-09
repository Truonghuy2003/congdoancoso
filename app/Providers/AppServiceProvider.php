<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ChuDe;
use Illuminate\Support\Facades\View;

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
        //
        $chude = ChuDe::all();
        View::share('chude', $chude);
    }
}
