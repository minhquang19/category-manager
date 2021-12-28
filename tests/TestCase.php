<?php

namespace VCComponent\Laravel\Category\Test;

use Cviebrock\EloquentSluggable\ServiceProvider;
use Dingo\Api\Provider\LaravelServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use VCComponent\Laravel\Category\Providers\CategoryRouteProvider;
use VCComponent\Laravel\Category\Providers\CategoryServiceProvider;
// use VCComponent\Laravel\User\Providers\UserComponentEventProvider;
// use VCComponent\Laravel\User\Providers\UserComponentProvider;
// use VCComponent\Laravel\User\Providers\UserComponentRouteProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return HaiCS\Laravel\Generator\Providers\GeneratorServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelServiceProvider::class,
            CategoryRouteProvider::class,
            CategoryServiceProvider::class,
            ServiceProvider::class,
            \Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
            \Illuminate\Auth\AuthServiceProvider::class,
            // UserComponentEventProvider::class,
            // UserComponentProvider::class,
            // UserComponentRouteProvider::class,

        ];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withFactories(__DIR__ . '/../tests/Stubs/Factory');
        $this->loadMigrationsFrom(__DIR__ . '/../src/database/migrations');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:TEQ1o2POo+3dUuWXamjwGSBx/fsso+viCCg9iFaXNUA=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('jwt.secret', '5jMwJkcDTUKlzcxEpdBRIbNIeJt1q5kmKWxa0QA2vlUEG6DRlxcgD7uErg51kbBl');
        $app['config']->set('auth.providers.users.model', \VCComponent\Laravel\User\Entities\User::class);
        $app['config']->set('user', ['namespace' => 'user-management']);
        $app['config']->set('repository.cache.enabled', false);

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

        $app['config']->set('api', [
            'standardsTree' => 'x',
            'subtype' => '',
            'version' => 'v1',
            'prefix' => 'api',
            'domain' => null,
            'name' => null,
            'conditionalRequest' => true,
            'strict' => false,
            'debug' => true,
            'errorFormat' => [
                'message' => ':message',
                'errors' => ':errors',
                'code' => ':code',
                'status_code' => ':status_code',
                'debug' => ':debug',
            ],
            'middleware' => [
            ],
            'auth' => [
            ],
            'throttling' => [
            ],
            'transformer' => \Dingo\Api\Transformer\Adapter\Fractal::class,
            'defaultFormat' => 'json',
            'formats' => [
                'json' => \Dingo\Api\Http\Response\Format\Json::class,
            ],
            'formatsOptions' => [
                'json' => [
                    'pretty_print' => false,
                    'indent_style' => 'space',
                    'indent_size' => 2,
                ],
            ],
        ]);

    }
    public function assertValidation($response, $field, $error_message)
    {
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            "errors" => [
                $field => [
                    $error_message,
                ],
            ],
        ]);
    }
}
