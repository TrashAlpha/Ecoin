<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Penukaran_Koin;
use App\Models\PenukaranSampah;

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
        Relation::morphMap([
            'penukaran_koin' => Penukaran_Koin::class,
            'penukaran_sampah' => PenukaranSampah::class,
            // jika nanti ada entitas lain, tambahkan di sini
        ]);
    }
}
