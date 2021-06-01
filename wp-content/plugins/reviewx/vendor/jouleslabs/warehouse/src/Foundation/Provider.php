<?php

namespace JoulesLabs\Warehouse\Foundation;

use JoulesLabs\Warehouse\Foundation\Application;

abstract class Provider
{
    /**
     * $app \Framework\Foundation\Application
     *
     * @var null
     */
    protected $app = null;

    /**
     * Build the instance
     *
     * @param \JoulesLabs\Warehouse\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Booted method for any provider
     */
    public function booted()
    {
        // ...
    }

    /**
     * Abstract booting method for provider
     */
    abstract public function booting();
}
