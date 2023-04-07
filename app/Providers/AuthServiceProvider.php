<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Store;
use App\Policies\CategoryPolicy;
use App\Policies\CouponPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\StaffPolicy;
use App\Policies\StorePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Customer::class => CustomerPolicy::class,
        Staff::class => StaffPolicy::class,
        Category::class => CategoryPolicy::class,
        Store::class => StorePolicy::class,
        Product::class => ProductPolicy::class,
        Coupon::class => CouponPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
