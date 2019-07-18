<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.app', function ($view) {
            $view->with('contact', \App\Contact::first());
        });

        view()->composer('layouts.admin', function ($view) {
            $view->with('contact', \App\Contact::first());
        });

        view()->composer('layouts.admin', function ($view) {
            $count_order = \App\Order::where('order_status','1')->count();
            $view->with('order', $count_order);
        });

        view()->composer('layouts.admin', function ($view) {
            $count_request_change = \App\RequestChangeOwner::where('request_change_owner_status','0')->count();
            $view->with('request_change', $count_request_change);
        });

        view()->composer('layouts.admin', function ($view) {
            $count_request_install = \App\InstallMicrochip::where('install_microchip_status','0')->count();
            $view->with('request_install', $count_request_install);
        });


        view()->composer('layouts.deliveryman', function ($view) {
            $view->with('contact', \App\Contact::first());
        });

        view()->composer('layouts.deliveryman', function ($view) {
            $count_new_order = \App\Order::where('order_status','0')->where('order_deliveryman', Auth::user()->name)->count();
            $view->with('new_order', $count_new_order);
        });

        view()->composer('layouts.deliveryman', function ($view) {
            $count_error_order = \App\Order::where('order_status','2')->where('order_deliveryman', Auth::user()->name)->count();
            $view->with('error_order', $count_error_order);
        });
    }
}
