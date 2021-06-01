<?php

if ( ! class_exists( 'ET_Builder_Module_Tabs' ) ) {
	return;
}

$module_files = glob( __DIR__ . '/modules/*/*.php' );

// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
		require_once $module_file;
	}
}

add_filter( 'et_fb_current_page_params', 'rvx_fb_current_page_params' );
function rvx_fb_current_page_params($data){

	$exclude_woo = wp_doing_ajax() || ! et_is_woocommerce_plugin_active() || 'latest' === ET_Builder_Module_Helper_Woocommerce_Modules::get_product_default();
	$data['woocommerceComponents'] = $exclude_woo ? array() : rvx_fb_current_page_woocommerce_components();
	$data['woocommerceTabs'] 		= et_builder_tb_enabled() && et_is_woocommerce_plugin_active() ?
	\ET_Builder_Module_Helper_Woocommerce_Modules::get_default_tab_options() : et_fb_woocommerce_tabs();		
	$data['woocommerce'] = array(
			'inactive_module_notice' => esc_html__(
				'Preview Unavailable. After saving the settings, please check the frontend to see the changes.',
				'reviewx'
			)
		);
	return $data;
}


function rvx_fb_current_page_woocommerce_components() {

	$is_product_cpt        = 'product' === get_post_type();
	$is_tb                 = et_builder_tb_enabled();
	$cpt_has_wc_components = $is_product_cpt || $is_tb;
	$has_wc_components     = et_is_woocommerce_plugin_active() && $cpt_has_wc_components;

	if ( $has_wc_components && $is_tb ) {
		// Set upsells ID for upsell module in TB.
		ET_Theme_Builder_Woocommerce_Product_Variable_Placeholder::set_tb_upsells_ids();

		// Force set product's class to ET_Theme_Builder_Woocommerce_Product_Variable_Placeholder in TB.
		add_filter( 'woocommerce_product_class', 'et_theme_builder_wc_product_class' );

		// Set product categories and tags in TB.
		add_filter( 'get_the_terms', 'et_theme_builder_wc_terms', 10, 3 );

		// Use Divi's image placeholder in TB.
		add_filter( 'woocommerce_single_product_image_thumbnail_html', 'et_builder_wc_placeholder_img' );

	}

	$woocommerce_components = ! $has_wc_components ? array() : array(
		'et_pb_wc_add_to_cart'      => ET_Builder_Module_Woocommerce_Add_To_Cart::get_add_to_cart(),
		'et_pb_wc_additional_info'  => ET_Builder_Module_Woocommerce_Additional_Info::get_additional_info(),
		'et_pb_wc_breadcrumb'       => ET_Builder_Module_Woocommerce_Breadcrumb::get_breadcrumb(),
		'et_pb_wc_cart_notice'      => ET_Builder_Module_Woocommerce_Cart_Notice::get_cart_notice(),
		'et_pb_wc_description'      => ET_Builder_Module_Woocommerce_Description::get_description(),
		'et_pb_wc_images'           => ET_Builder_Module_Woocommerce_Images::get_images(),
		'et_pb_wc_meta'             => ET_Builder_Module_Woocommerce_Meta::get_meta(),
		'et_pb_wc_price'            => ET_Builder_Module_Woocommerce_Price::get_price(),
		'et_pb_wc_rating'           => ET_Builder_Module_Woocommerce_Rating::get_rating(),
		'et_pb_wc_reviews'          => ET_Builder_Module_Woocommerce_Reviews::get_reviews_html(),
		'rvx_et_pb_wc_reviews'      => RVX_Builder_Module_Woocommerce_Reviews::get_tabs(),
		'et_pb_wc_stock'            => ET_Builder_Module_Woocommerce_Stock::get_stock(),
		'et_pb_wc_tabs'             => ET_Builder_Module_Woocommerce_Tabs::get_tabs(),
		'rvx_et_pb_wc_tabs'         => RVX_Builder_Module_Woocommerce_Tabs::get_tabs(),
		'et_pb_wc_title'            => ET_Builder_Module_Woocommerce_Title::get_title(),
		'et_pb_wc_related_products' => ET_Builder_Module_Woocommerce_Related_Products::get_related_products(),
		'et_pb_wc_upsells'          => ET_Builder_Module_Woocommerce_Upsells::get_upsells(),
	);

	return $woocommerce_components;	
}
