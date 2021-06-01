<?php

class RvxOxyWooEl extends OxyEl {

    function init() {
        
        $this->El->useAJAXControls();
        $this->setAssetsPath( OXY_WOO_ASSETS_PATH );
    }

    function render($options, $defaults, $content) {

        if (method_exists($this, 'wooTemplate')) {

            global $product;
            $product = wc_get_product();
            if ($product != false) {
                call_user_func($this->wooTemplate($options));
            }

        }
        
    }

    function class_names() {
        return array('oxy-woo-element');
    }

    function woo_button_place() {
        return "other";
    }

    function button_place() {
        
        $woo_button_place = $this->woo_button_place();
        
        if ($woo_button_place) {
            return "woo::".$woo_button_place;
        }

        return "";
    }

}
