<?php

function reviewx_general_settings_args() {
    return array(
        'id'           => 'rx_metabox_wrapper',
        'title'        => __('ReviewX - Advanced Multi-criteria Rating & Reviews for WooCommerce', 'reviewx'),
        'object_types' => array( 'reviewx' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_header'  => false,
        'tabnumber'    => true,
        'layout'       => 'horizontal',
        'tabs'         => apply_filters( 'rx_general_settings_builder_tabs', array(
            
        ))
    );
}