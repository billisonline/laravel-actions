<?php

namespace BYanelli\Actions;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $actions = [

    ];

    public function register()
    {
        $this->app->instance('action_manager', new ActionManager($this->app));

        $this->registerActions();
    }

    protected function actionManager(): ActionManager
    {
        return $this->app->make('action_manager');
    }

    protected function registerActions(): void
    {
        $actionManager = $this->actionManager();

        foreach ($this->actions as $key => $action) {
            $name = is_string($key)? $key : $this->formatName($action);

            $actionManager->bind($name, $action);
        }
    }

    protected function formatName(string $val): string
    {
        if (class_exists($val) || interface_exists($val)) {
            $val = class_basename($val);
        }

        return Str::camel($val);
    }
}
