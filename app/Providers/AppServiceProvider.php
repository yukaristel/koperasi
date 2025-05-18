<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use App\Models\Kecamatan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $menus = Menu::where('parent_id', 0)
                ->where('aktif', 'Y')
                ->orderBy('sort')
                ->with('child')
                ->get();
                
                $kec = Kecamatan::where('id', 1)->first();
            if (session()->has('lokasi')) {
                $kec = Kecamatan::where('id', session('lokasi'))->first();
            }

            $view->with([
                'menus' => $menus,
                'kec' => $kec,
            ]);
        });
    }
}
