<?php

namespace BYanelli\Actions\Tests\TestApp\Providers;

use BYanelli\Actions\ActionServiceProvider as BaseServiceProvider;
use BYanelli\Actions\Tests\TestApp\Actions\TestInvokableAction;

class ActionServiceProvider extends BaseServiceProvider
{
    protected $actions = [
        TestInvokableAction::class,
    ];
}
