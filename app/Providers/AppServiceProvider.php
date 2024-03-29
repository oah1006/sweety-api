<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        Relation::enforceMorphMap([
            'staff' => 'App\Models\Staff',
            'user' => 'App\Models\User',
            'customer' => 'App\Models\Customer',
            'attachment' => 'App\Models\Attachment',
            'product' => 'App\Models\Product',
            'store' => 'App\Models\Store'
        ]);
    }
}
