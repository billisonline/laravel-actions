<?php

namespace BYanelli\Actions;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin ActionManager
 */
class Action extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'action_manager';
    }
}
