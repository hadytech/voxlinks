<?php

if (!function_exists('dd')) {
    function dd() {
        foreach (func_get_args() as $value) {
            echo '<pre>';
            print_r($value);
            echo '</pre><br>';
        }
        die;
    }
}

if (! function_exists('app')) {
    function app($key = null) {
        if ($key) {
            return \JoulesLabs\Warehouse\Facade\App::make($key);
        }
        return \JoulesLabs\Warehouse\Facade\App::make();
    }
}

if (!function_exists('assets')) {
    function assets($path, $vendor = false) {
        return $vendor ? app()->vendorUrl($path) : app()->assetUrl($path);
    }
}

if (! function_exists('config')) {
    function config($path, $default = null) {
        return array_get(app('config'), $path, $default);
    }
}

if (!function_exists('view')) {
    function view($path, $args = []) {
        return (\JoulesLabs\Warehouse\Facade\View::make($path, $args, false));
    }
}

if (!function_exists('vendor_view')) {
    function vendor_view($path, $args = []) {
        return (\JoulesLabs\Warehouse\Facade\View::make($path, $args, true));
    }
}

if (! function_exists('data_get')) {
    function data_get($data, $accessor, $default = null) {
        if (is_array($data)) {
            return array_get($data, $accessor, $default);
        }
        return $default;
    }
}

if (! function_exists('array_get')) {
    function array_get($data, $accessor, $default = null ) {
        $accessorArray = explode('.', $accessor);
        $firstKey = array_shift($accessorArray);
        $value = $data[$firstKey];
        foreach($accessorArray as $key) {
            if (isset($value[$key])) {
                return $default;
            }
            $value = $value[$key];
        }
        return $value;
    }
}