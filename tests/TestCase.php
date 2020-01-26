<?php

namespace BYanelli\Actions\Tests;

use BYanelli\Actions\Action;
use BYanelli\Actions\ActionManager;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\RegisterFacades;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function configureApp()
    {
        $app = Application::setInstance(new Application(__DIR__.DIRECTORY_SEPARATOR.'/TestApp'));

        $app->instance('config', $config = new Repository([
            'app' => [
                'aliases' => [
                    'Action' => Action::class,
                ]
            ]
        ]));

        $app->instance('action_manager', new ActionManager($app));

        (new RegisterFacades())->bootstrap($app);
    }

    public function setUp()
    {
        $this->configureApp();
    }
}
