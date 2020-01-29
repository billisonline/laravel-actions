<?php

namespace BYanelli\Actions;

use Illuminate\Container\Container;

class ActionCallable
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var Container
     */
    private $app;

    public function __construct(callable $callable, Container $app)
    {
        $this->callable = $callable;
        $this->app = $app;
    }

    public function __invoke(...$params)
    {
        $cb = $this->callable;

        return $cb(...$params);
    }

    public function call(array $params)
    {
        return $this->__invoke(...$params);
    }

    public function callWith(array $params)
    {
        return $this->app->call($this->callable, $params);
    }
}
