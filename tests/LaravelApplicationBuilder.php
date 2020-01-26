<?php

namespace BYanelli\Actions\Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Support\Arr;

/**
 * @mixin Application
 *
 * @method $this instance($abstract, $instance)
 * @method $this bind($abstract, $concrete, $shared=false)
 * todo: more of these
 */
class LaravelApplicationBuilder
{
    /**
     * @var string|null
     */
    protected $basePath = null;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $bootstrappers = [];

    /**
     * @var array
     */
    protected $deferredAppCalls = [];

    /**
     * @var array
     */
    protected $serviceProviders = [];

    public function withBasePath(string $basePath): self
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function withConfig($config, $values=null): self
    {
        if (is_string($config) && is_array($values)) {
            Arr::set($this->config, $config, $values);

            return $this;
        }

        $this->config = array_merge($this->config, $config);

        return $this;
    }

    public function withBootstrappers($bootstrappers): self
    {
        $bootstrappers = is_array($bootstrappers)? $bootstrappers : func_get_args();

        $this->bootstrappers = array_unique(array_merge($this->bootstrappers, $bootstrappers));

        return $this;
    }

    public function withFacades(array $facades): self
    {
        return (
            $this->withConfig('app.aliases', $facades)
                ->withBootstrappers(RegisterFacades::class)
        );
    }

    public function build(): Application
    {
        $app = new Application($this->basePath);

        Application::setInstance($app);

        $app->instance('config', $config = new Repository($this->config));

        foreach ($this->bootstrappers as $bootstrapper) {
            if (is_string($bootstrapper) && class_exists($bootstrapper)) {
                $bootstrapper = new $bootstrapper;
            }

            if (!is_object($bootstrapper)) {
                throw new \Exception;
            }

            if (!method_exists($bootstrapper, 'bootstrap')) {
                throw new \Exception;
            }

            $bootstrapper->bootstrap($app);
        }

        foreach ($this->serviceProviders as $serviceProvider) {
            $app->register($serviceProvider);
        }

        foreach ($this->deferredAppCalls as [$name, $arguments]) {
            $app->{$name}(...$arguments);
        }

        return $app;
    }

    public function __call($name, $arguments)
    {
        $this->deferredAppCalls[] = [$name, $arguments];

        return $this;
    }

    public function withServiceProviders(array $array)
    {
       $this->serviceProviders = array_unique(array_merge($this->serviceProviders, $array));

       return $this;
    }
}
