<?php

namespace JoulesLabs\Warehouse\Request;

use JoulesLabs\Warehouse\Foundation\Provider;

class RequestProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     */
    public function booting()
    {
        $this->app->bindSingleton('request', function ($app) {
            return new Request($app, $_GET, $_POST, $_FILES);
        }, 'Request', Request::class);
    }
}
