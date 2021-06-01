<?php

namespace Templately;

class Base {
    protected static $_instance = null;
    /**
     * Get Instance of Called Class
     *
     * @return void
     */
    public static function get_instance(){
        if( static::$_instance === null ) {
            $class = get_called_class();
            static::$_instance = new $class;
        }
        return static::$_instance;
    }
}
