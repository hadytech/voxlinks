<?php

/**
 * Check's if the application is in development mode.
 */
if (! function_exists('isDevEnv')) {
	function isDevEnv() {
		return config('app.env') === 'dev';
	}
}

/**
 * playground allows us to run any code within development mode.
 * example:
 * playground(function() {
 *  // any code
 * })
 *
 * will only run if it is in development
 */
if (! function_exists('playground')) {
	function playground($callback) {
		if(isDevEnv()) {
			$callback();
		}
	}
}

/**
 * Bypass for ?? []
 */
if (! function_exists('_get')) {
	function _get($arrayKey,$default = null) {
		if(isset($arrayKey)) {
			return $arrayKey;
		}

		return $default;
	}
}

/**
 * Laravel's dd()
 */
if (! function_exists('dd')) {
	function dd() {
		if(! function_exists('dd')) {
			return;
		}
		array_map(function($x) {
			var_dump($x);
		},
			func_get_args());
		die;
	}
}

if (! function_exists('rx_get_categories')) {
    function rx_get_categories() {
        return wpFluent()->table('term_taxonomy')->leftJoin('terms', function ($query) {
            $query->on('term_taxonomy.term_id', '=', 'terms.term_id');
        })->whereIn('taxonomy', ['product_cat'])->get();
    }
}

if (! function_exists('rx_get_products')) {
    function rx_get_products() {
        return array_map('wc_get_product', get_posts([
            'post_type' => 'product',
            'nopaging'=>true
        ]));
    }
}