<?php

namespace Templately;

class Loader {
    /**
     * All usable actions will add here.
     * @var array
     */
    private static $actions = [];
    /**
     * All usable filters will added here.
     * @var array
     */
    private static $filters = [];

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param string $hook          The name of the WordPress action that is being registered.
     * @param object $component     A reference to the instance of the object on which the action is defined.
     * @param string $callback      The name of the function definition on the $component.
     * @param int    $priority      Optional. The priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public static function add_action($tag, $component, $function_to_add, $priority = 10, $accepted_args = 1) {
        self::$actions = self::add(self::$actions, $tag, $component, $function_to_add, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param string $hook          The name of the WordPress filter that is being registered.
     * @param object $component     A reference to the instance of the object on which the filter is defined.
     * @param string $callback      The name of the function definition on the $component.
     * @param int    $priority      Optional. The priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public static function add_filter($tag, $component, $function_to_add, $priority = 10, $accepted_args = 1) {
        self::$filters = self::add(self::$filters, $tag, $component, $function_to_add, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @access   private
     * @param  array  $hooks         The collection of hooks that is being registered (that is, actions or filters).
     * @param  string $hook          The name of the WordPress filter that is being registered.
     * @param  object $component     A reference to the instance of the object on which the filter is defined.
     * @param  string $callback      The name of the function definition on the $component.
     * @param  int    $priority      The priority at which the function should be fired.
     * @param  int    $accepted_args The number of arguments that should be passed to the $callback.
     * @return array  The collection of actions and filters registered with WordPress.
     */
    private static function add($hooks, $tag, $component, $function_to_add, $priority, $accepted_args) {
        $hooks[] = array(
            'hook'          => $tag,
            'component'     => $component,
            'callback'      => $function_to_add,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );
        return $hooks;
    }

    /**
     * Register the filters and actions with WordPress.
     */
    public static function run() {
        if (!empty(self::$filters)) {
            foreach (self::$filters as $hook) {
                add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
            }
        }
        if (!empty(self::$actions)) {
            foreach (self::$actions as $hook) {
                add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
            }
        }
    }
}
