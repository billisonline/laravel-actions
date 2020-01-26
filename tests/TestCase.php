<?php

namespace BYanelli\Actions\Tests;

use BYanelli\Actions\Action;
use BYanelli\Actions\Tests\TestApp\Providers\ActionServiceProvider;
use Illuminate\Foundation\Application;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @var Application
     */
    protected $app;

    public function configureApp()
    {
        $this->app = (
            (new LaravelApplicationBuilder)
                ->withBasePath(__DIR__.DIRECTORY_SEPARATOR.'TestApp')
                ->withFacades([
                    'Action' => Action::class,
                ])
                ->withServiceProviders([
                    ActionServiceProvider::class,
                ])
                ->build()
        );
    }

    public function setUp()
    {
        $this->configureApp();
    }
}
