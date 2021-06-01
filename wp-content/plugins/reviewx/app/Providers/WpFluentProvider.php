<?php


namespace ReviewX\Providers;


use JoulesLabs\Warehouse\Foundation\Provider;

class WpFluentProvider extends Provider
{
    public function booting()
    {
        require_once $this->app->appPath().'Services/WPFluent/wp-fluent.php';
    }
}