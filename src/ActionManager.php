<?php

namespace BYanelli\Actions;

use Illuminate\Container\Container;

class ActionManager
{
    /**
     * @var array
     */
    private $bindings = [];

    /**
     * @var Container
     */
    private $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function bind(string $name, $action)
    {
        $this->bindings[$name] = $action;
    }

    public function call(string $name, array $params)
    {
        if (!isset($this->bindings[$name])) {
            throw new \Exception;
        }

        $action = $this->bindings[$name];

        $callable = $this->makeCallable($action);

        return $this->app->call($callable, $params);
    }

    private function makeCallable($action): callable
    {
        // todo: support array callables like [SomeClass::class, 'someStaticMethod'] or [$instance, 'someMethod']
        // todo: support special container callables like `SomeClass@someMethod`

        if (
            is_string($action)
            && ($this->app->has($action) || class_exists($action))
        ) {
            $action = $this->app->make($action);
        }

        if (!is_callable($action)) {
            throw new \Exception;
        }

        return $action;
    }


}
