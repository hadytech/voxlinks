<?php

/**
 * Declare common (backend|frontend) global functions here
 * but try not to use any global functions unless you need.
 */

if (! function_exists('view_v1')) {
    function view_v1($path, $args = []) {
        extract($args);
        include REVIEWX_PARTIALS_PATH . $path;
    }
}

if (! function_exists('request_filled')) {
    function request_filled($key, $default = null) {
        return array_key_exists($key, $_REQUEST) ? $_REQUEST[$key] : $default;
    }
}

if (! function_exists('build_url')) {
    function build_url(array $elements) {
        $e = $elements;
        return
            (isset($e['host']) ? (
                (isset($e['scheme']) ? "$e[scheme]://" : '//') .
                (isset($e['user']) ? $e['user'] . (isset($e['pass']) ? ":$e[pass]" : '') . '@' : '') .
                $e['host'] .
                (isset($e['port']) ? ":$e[port]" : '')
            ) : '') .
            (isset($e['path']) ? $e['path'] : '/') .
            (isset($e['query']) ? '?' . (is_array($e['query']) ? http_build_query($e['query'], '', '&') : $e['query']) : '') .
            (isset($e['fragment']) ? "#$e[fragment]" : '')
        ;
    }
}

if (! function_exists('view_v1')) {
    function view_v1($path, $args = []) {
        extract($args);
        include REVIEWX_PARTIALS_PATH . $path;
    }
}