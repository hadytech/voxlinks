<?php 

add_action('plugins_loaded', 'rvx_oxygen_woocommerce_init');
function rvx_oxygen_woocommerce_init() {

  // check if Oxygen installed and active
  if ( !class_exists('OxygenElement') ) {
    return;
  }

  require_once('RvxOxyWooEl.php');
  require_once('RvxOxyElement.php');
  $RvxOxyElement = new RvxOxyElement();
}