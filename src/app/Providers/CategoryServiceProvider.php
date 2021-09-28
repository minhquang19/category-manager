<?php

namespace VCComponent\Laravel\Category\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use VCComponent\Laravel\Category\Categories\Category;
use VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface;
use VCComponent\Laravel\Category\Contracts\ViewCategoryDetailControllerInterface;
use VCComponent\Laravel\Category\Contracts\ViewCategoryListControllerInterface;
use VCComponent\Laravel\Category\Http\Controllers\Web\CategoryDetailController as ViewCategoryDetailController;
use VCComponent\Laravel\Category\Http\Controllers\Web\CategoryListController as ViewCategoryListController;
use VCComponent\Laravel\Category\Policies\CategoryPolicy;
use VCComponent\Laravel\Category\Repositories\CategoryRepository;
use VCComponent\Laravel\Category\Repositories\CategoryRepositoryEloquent;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');

        $this->publishes([
            __DIR__ . '/../../config/category.php' => config_path('category.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'category-manager');

        Schema::defaultStringLength(191);
    }

    /**
     * Register any package services
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->registerControllers();
        $this->registerPolicies();
        $this->app->singleton('moduleCategory.category', function () {
            return new Category();
        });

        $this->app->register(CategoryAuthServiceProvider::class);
    }

    private function registerControllers()
    {
        $this->app->bind(ViewCategoryListControllerInterface::class, ViewCategoryListController::class);
        $this->app->bind(ViewCategoryDetailControllerInterface::class, ViewCategoryDetailController::class);
    }

    private function registerPolicies()
    {
        $this->app->bind(CategoryPolicyInterface::class, CategoryPolicy::class);
    }
}
