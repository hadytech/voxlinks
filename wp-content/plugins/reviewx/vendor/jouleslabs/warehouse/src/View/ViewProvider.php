<?php

namespace JoulesLabs\Warehouse\View;

use JoulesLabs\Warehouse\Foundation\Provider;

class ViewProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     */
    public function booting()
    {
        $this->app->bind('view', function ($app) {
            return new View($app);
        }, 'View', View::class);
    }
}
