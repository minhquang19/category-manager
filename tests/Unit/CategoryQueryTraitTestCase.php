<?php

namespace VCComponent\Laravel\Category\Test\Unit;

use VCComponent\Laravel\Category\Test\Stubs\Models\Category;
use VCComponent\Laravel\Category\Test\TestCase;

class CategoryQueryTraitTestCase extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('category.namespace', 'category-management');
        $app['config']->set('category.models', [
            'category' => \VCComponent\Laravel\Category\Test\Stubs\Models\Category::class,

        ]);
        $app['config']->set('category.transformers', [
            'category' => \VCComponent\Laravel\Category\Transformers\CategoryTransformer::class,
        ]);
        $app['config']->set('category.auth_middleware', [
            'admin' => [
                'middleware' => 'auth',
                'except' => [],
            ],
            'frontend' => [
                'middleware' => '',
            ],
        ]);
    }
}
