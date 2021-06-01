<?php

namespace JoulesLabs\Warehouse\View;

class View
{
    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function make($path, $data = [], $vendor = false)
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);

        if ($vendor) {
            $file = $this->app->vendorPath($path).'.php';
        } else {
            $file = $this->app->viewPath($path) . '.php';
        }

        if (file_exists($file)) {
            ob_start();
            extract($data);
            include $file;
            return ob_get_clean();
        }

        throw new \InvalidArgumentException("The view file [$file] doesn't exists!");
    }

    public function render($path, $data = [])
    {
        echo $this->make($path, $data);
    }
}
