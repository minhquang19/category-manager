<?php

namespace VCComponent\Laravel\Category\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class CategoryAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('view-category', 'VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface@ableToShow');
        Gate::define('create-category', 'VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface@ableToCreate');
        Gate::define('update-category', 'VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface@ableToUpdate');
        Gate::define('delete-category', 'VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface@ableToDelete');
        //
    }
}
