<?php

/**
 * The public-facing functionality of the plugin. 
 *
 * @link       https://wpdeveloper.net/   
 * @since      1.0.0
 * @package    Crowdfundly
 * @subpackage Crowdfundly/public
 * @author     WPDeveloper   
 */
class Crowdfundly_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	private static $static_plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private static $static_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		self::$static_plugin_name = $plugin_name;
		self::$static_version = $version;
		add_action( 'wp_ajax_crowdfundly_update_cart', [$this, 'crowdfundly_update_cart'] );
		add_action( 'wp_ajax_nopriv_crowdfundly_update_cart', [$this, 'crowdfundly_update_cart'] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		global $post;

		if(isset($post->post_content) && 
		(
			has_shortcode( $post->post_content, 'crowdfundly-organization') ||
			has_shortcode( $post->post_content, 'crowdfundly-all-campaigns') ||
			has_shortcode( $post->post_content, 'crowdfundly-campaign')
		)
		) {
			self::load_css();			
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		global $post; 
		if(isset($post->post_content) && 
		(
			has_shortcode( $post->post_content, 'crowdfundly-organization') ||
			has_shortcode( $post->post_content, 'crowdfundly-all-campaigns') ||
			has_shortcode( $post->post_content, 'crowdfundly-campaign')
		)
		) {
			self::load_js();
		}

	}

	/**
	 * Load CSS files
	 *
	 * @since    1.1.3
	 */
	public static function load_css(){

		if( ! class_exists('WooCommerce') || ( class_exists('WooCommerce') && ! is_checkout() ) ) {
			wp_enqueue_style( self::$static_plugin_name . '-bootstrap', CROWDFUNDLY_URL . 'assets/bootstrap/css/bootstrap.min.css', [], self::$static_version, 'all' );
		}			
		wp_enqueue_style( self::$static_plugin_name . '-fontawesome', esc_url('https://pro.fontawesome.com/releases/v5.10.0/css/all.css'), [], self::$static_version, 'all' );
		wp_enqueue_style( self::$static_plugin_name . '-slick', CROWDFUNDLY_URL . 'assets/slick-dist/slick/slick.css', [], self::$static_version, 'all' );
		wp_enqueue_style( self::$static_plugin_name . '-slick-theme', CROWDFUNDLY_URL . 'assets/slick-dist/slick/slick-theme.css', [], self::$static_version, 'all' );
		wp_enqueue_style( self::$static_plugin_name, plugin_dir_url( __FILE__ ) . 'css/crowdfundly-public.css', [], self::$static_version, 'all' );
	}

	/**
	 * Load JS files
	 *
	 * @since    1.1.3
	 */
	public static function load_js(){
		if( ! class_exists('WooCommerce') || class_exists('WooCommerce') && ! is_checkout() ){
			wp_enqueue_script( self::$static_plugin_name . '-bootstrap', CROWDFUNDLY_URL . 'assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), self::$static_version, true ); 
		}

		wp_enqueue_script( self::$static_plugin_name . '-slick', CROWDFUNDLY_URL . 'assets/slick-dist/slick/slick.min.js', array( 'jquery' ), self::$static_version, true );
		wp_enqueue_script( self::$static_plugin_name . 'public', plugin_dir_url( __FILE__ ) . 'js/crowdfundly-public.js', array( 'jquery', self::$static_plugin_name . '-slick' ), self::$static_version, true );
		wp_localize_script( self::$static_plugin_name . 'public', 'crowdfundlyPublicData',
			[
				'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
				'nonce' 		=> wp_create_nonce( 'crowdfundly_public_nonce' ),
				'load_more'		=> __('Load more', 'crowdfundly'),
				'loading'		=> __('Loading...', 'crowdfundly'),
			]
		);
	}

	/**
     * Initialize public functions
     * @since 1.0.0
     * @return void
     */
    public function init()
    {
		if ( Crowdfundly_Settings::hasToken() ) {
			new Crowdfundly_Shortcode();
		}
	}
	
	/**
     * Add to cart redirect for campaign
     * @since 1.0.0
     * @return void
     */	
	public function add_to_cart_redirect( $url ) 
	{
		if( self::matched_cart_items(Crowdfundly_Helper::get_crowdfundly_product_id()) > 0 ){
			$url = wc_get_checkout_url();
		}
		return esc_url($url);
	}

	/**
     * Add to cart redirect for campaign
     * @since 1.0.0
     * @return void
     */	
	public static function matched_cart_items( $product_id ) 
	{
		$count = 0; 
		if ( ! WC()->cart->is_empty() ) {
			foreach(WC()->cart->get_cart() as $cart_item ) {
				$cart_item_ids = array($cart_item['product_id'], $cart_item['variation_id']);
				if( ( is_array($product_id) && array_intersect($product_id, $cart_item_ids) ) 
				|| ( !is_array($product_id) && in_array($product_id, $cart_item_ids) ) ){
					$count++; 
				}				
			}
		}
		return $count; 
	}

	/**
     * all campaigns load more
	 *
     * @return void
     */
	public function crowdfundly_all_campaign_load_more() {
		$security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
		if ( false == $security ) {
			return;
		}

		$column = sanitize_text_field( $_POST['grid_column'] );
		$per_page = sanitize_text_field( $_POST['per_page'] );
		$current_page = sanitize_text_field( $_POST['current_page'] );

		// $organization = Crowdfundly_Settings::get('organization');
		$organization = get_option( 'crowdfundly_user', null );
		$username = isset($organization->username) ? $organization->username : '';

		$url = 'https://api.crowdfundly.io/api/v1/organizations/' . $username . '/active-campaigns/?per_page=' . $per_page . '&page=' . $current_page;
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			echo json_encode($response->get_error_message());
			wp_die();
		}

		$response_body = json_decode( wp_remote_retrieve_body( $response ) );
		$camps = $response_body->data;

		foreach ( $camps as $camp ) :
		?>
			<div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $column ); ?>">
				<a href="<?php echo esc_url( Crowdfundly_Settings::getSingleCampaingPagePermalink($camp->slug) ); ?>" class="campaign-card">
					<?php 
						if( ! empty( $camp->gallery ) ) :
						$logo = $camp->gallery[0]->source_path;
					?>
						<div class="campaign-card__top">
							<div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( $logo ); ?>);"></div>
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_html( $camp->name ); ?>" class="campaign-card__img">                                                
						</div>
					<?php endif; ?>

					<div class="campaign-card__details">
						<h4 class="campaign-card__title">
							<?php echo esc_html( $camp->name ); ?>
						</h4>
						<p class="campaign-card__description">
							<?php echo strip_tags(\Crowdfundly_Helper::get_campaign_story($camp->story, 20)); ?>
						</p>
					</div>
					<div class="campaign-card__footer">
						<div class="progress progress--slim">
							<div class="progress__bar progress__bar--secondary" style="width: <?php  echo esc_html( round(($camp->raised_amount*100)/$camp->target_amount) . '%'); ?>"></div>
						</div>
						<p class="campaign-card__amount">
							<strong><i class="fas fa-hand-holding-usd"></i> <?php printf( '%s %s', round( $camp->raised_amount, 2 ), $camp->currency->currency_code ); ?></strong>
							<?php printf( '%s %s %s', __('OF', 'crowdfundly'), $camp->target_amount, $camp->currency->currency_code ); ?>
						</p>
					</div>
				</a>
			</div>
		<?php
		endforeach;
		wp_die();
	}

	/**
     * Get activites log
     * @since 1.0.0
     * @return void
     */		
	public function crowdfundly_single_campaign_activites_log() 
	{
		$security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
		if ( false == $security ) {
			return;
		}

		$campaign_id = sanitize_text_field( $_POST['camp_id'] );
		$current_page = sanitize_text_field( $_POST['current_page'] );
		if ( ! isset( $campaign_id ) ) return;

		$activitiesSlug = '/' . $campaign_id . '/activities' . '?per_page=3&page=' . $current_page;
		$activities_response = wp_remote_get( Crowdfundly_Api::$get_endpoints['campaign'] . $activitiesSlug );
		$activities = json_decode( wp_remote_retrieve_body( $activities_response ) );

		$activity_items = $activities->data;
		?>

		<?php foreach ( $activity_items as $activity ): 
			$avatar_url = CROWDFUNDLY_PUBLIC_URL . 'images/avatar.png';
			if ( ! $activity->is_anonymous && isset( $activity->donation->avatar ) ) {
				$avatar_url = $activity->donation->avatar;
			}
			?>
			<div class="activity">
				<div class="activity__avatar" style="background-image: url(<?php echo esc_url($avatar_url); ?>);"></div>
				<div class="activity__details">
					<div class="activity__row">
						<div class="activity__name">
							<?php
							$name = isset($activity->donation->full_name) ? $activity->donation->full_name : $activity->donation->name;
							$donorName = $activity->is_anonymous ? __( 'Anonymous Contributor', 'crowdfundly' ) : $name;
							echo esc_html( $donorName );
							?>
							<span class="activity__label">
								<?php _e( 'has contributed', 'crowdfundly' ); ?>
							</span>
						</div>
						<p class="activity__date">
							<?php echo date_i18n( get_option( 'links_updated_date_format' ), strtotime( $activity->created_at ) ); ?>
						</p>
					</div>
					<div class="activity__row">
						<div class="activity__label">
							<?php _e( 'Amount:', 'crowdfundly' ); ?> 
							<span class="activity__value">
								<?php echo esc_html( $activity->currency_code . " " . $activity->donation_amount ); ?>
							</span>
						</div>
					</div>
					<?php if ( isset( $activity->donation->message ) ) : ?>
						<div class="activity__row">
							<p class="activity__message">
								<?php echo $activity->donation->message; ?>
							</p>
						</div>
					<?php endif; ?>           
				</div>
			</div>
		<?php endforeach; ?>

		<?php
		wp_die();
	}

	/**
     * Catch the submitted donation amount
     * @since 1.0.0
     * @return array
     */	
	public function catch_and_save_submited_donation( $cart_item_data, $product_id )
	{
		
		if( isset($_REQUEST['crowdfundly_donation']) ) { 
			$product = wc_get_product( $product_id );
			$cart_item_data['active_price'] = (float) $product->get_price();			
			$cart_item_data['crowdfundly_campaign'] = sanitize_text_field( $_REQUEST['crowdfundly_campaign'] );
			$cart_item_data['crowdfundly_campaign_slug'] = sanitize_text_field( $_REQUEST['crowdfundly_campaign_slug'] );
			$cart_item_data['crowdfundly_campaign_id'] = sanitize_text_field( $_REQUEST['crowdfundly_campaign_id'] );
			$cart_item_data['crowdfundly_donation'] = sanitize_text_field( $_REQUEST['crowdfundly_donation'] );
			$cart_item_data['unique_key'] = md5( microtime().rand() ); // Make each item unique
			$cart_item_data['crowdfundly_currency'] = sanitize_text_field( $_REQUEST['crowdfundly_currency'] );
			$cart_item_data['crowdfundly_currency_symbol'] = sanitize_text_field( $_REQUEST['crowdfundly_csymbol'] );
			if(isset($_REQUEST['crowdfundly_offer_id'])){
				$cart_item_data['crowdfundly_offer_id'] = sanitize_text_field( $_REQUEST['crowdfundly_offer_id'] );				
			}

		}
		return $cart_item_data;

	}

	/**
     * Add donation item meta
     * @since 1.0.0
	 * @params array
     * @return array
     */		
	function add_donation_item_meta($item_id, $values) {

		if(isset($values['crowdfundly_donation']) && !empty($values['crowdfundly_donation'])) {
			wc_add_order_item_meta($item_id, 'crowdfundly_campaign', $values['crowdfundly_campaign']);
			wc_add_order_item_meta($item_id, 'crowdfundly_campaign_id', $values['crowdfundly_campaign_id']);
			wc_add_order_item_meta($item_id, 'crowdfundly_currency', $values['crowdfundly_currency']);	
			wc_add_order_item_meta($item_id, 'crowdfundly_currency_symbol', $values['crowdfundly_csymbol']);
			if(isset($values['crowdfundly_offer_id'])){
				wc_add_order_item_meta($item_id, 'crowdfundly_offer_id', $values['crowdfundly_offer_id']);
			}			
		}
	}	
	
	/**
     * Catch the submitted donation amount
     * @since 1.0.0
     * @return array
     */
	public function add_donation_to_item_price( $cart ) 
	{
	
		if ( is_admin() && ! defined( 'DOING_AJAX' ) )
			return;
		
		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
			return;

		foreach ( $cart->get_cart() as $item ) {
			// Add the donation to the product price
			if ( isset( $item['crowdfundly_donation']) && isset( $item['active_price']) ) {
				$item['data']->set_price( $item['crowdfundly_donation'] );			
			}
	
		}
	}

	/**
     * Disable COD when making a donaction
     * @since 1.0.0
     * @return array
     */	
	public function unset_gateway_by_product( $available_gateways ) 
	{

		global $woocommerce;
		$unset = false;
		if(isset($woocommerce->cart->cart_contents)){
			foreach ( $woocommerce->cart->cart_contents as $key => $values ) {	 		
				if( isset( $values['crowdfundly_donation'] ) ){
					$unset = true;
				}
			}		
			if ( $unset == true ) unset( $available_gateways['cod'] );
		}

		return $available_gateways;
	}
	
	/**
     * Remove additional notes from checkout page when making a donaction 
     * @since 1.0.0
     * @return array
     */		
	public function remove_order_notes( $fields ) 
	{		
		global $woocommerce;
		foreach( $woocommerce->cart->get_cart() as $items ){

			if( isset($items['crowdfundly_donation']) && Crowdfundly_Helper::get_crowdfundly_product_id() == $items['product_id'] ){				
				unset($fields['billing']['billing_company']);
				unset($fields['billing']['billing_address_1']);
				unset($fields['billing']['billing_address_2']);
				unset($fields['billing']['billing_country']);
				unset($fields['billing']['billing_city']);
				unset($fields['billing']['billing_state']);
				unset($fields['billing']['billing_postcode']);
				add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
				unset($fields['order']['order_comments']);
			}
			
		}	
		return $fields;
	}

	/**
     * Load cuopon filter
     * @since 1.0.0
     * @return void
     */		
	public function crowdfundly_coupon_filter(){
		add_filter( 'woocommerce_coupons_enabled', [$this, 'hide_coupon_field_on_cart'] );
	}
	
	/**
     * Hide coupon from the cart when making a donation
     * @since 1.0.0
     * @return false|boolean
     */		
	public function hide_coupon_field_on_cart ( $enabled ) 
	{

		if (is_admin()) return false;
		global $woocommerce;		
		foreach( $woocommerce->cart->get_cart() as $items ){
			if( isset($items['crowdfundly_donation']) && Crowdfundly_Helper::get_crowdfundly_product_id() == $items['product_id'] ){
				return false;
			}
		}
		return $enabled; 
	}

	/**
     * Forcefully stop customer email notification when making a donation
     * @since 1.0.0
     * @return string|boolean
     */		
	public function disable_customer_email_notification_for_donation( $recipient, $order )
	{
		global $woocommerce;
		$items = $order->get_items();
		foreach ( $items as $item ) {
			$product_id = $item['product_id'];
			if ( $product_id == Crowdfundly_Helper::get_crowdfundly_product_id() ) {
				$recipient = '';
			}
			return $recipient;
		}
	}

	/**
     * Check donation product in cart and change currency by SaaS currency
     * @since 1.0.0
     * @return string, string
     */		
	public function change_existing_currency_symbol( $currency_symbol, $currency ) {
		
		if( is_admin() ) return $currency_symbol;
		if( Crowdfundly_Helper::get_crowdfundly_product_id() == get_the_ID() ) {
			$organization = Crowdfundly_Settings::get('organization');	
			$username 		= isset($organization->username)?$organization->username:''; 
			$orgs_info 	 = Crowdfundly_Api::get('organization', [], $username);			
			return isset($orgs_info->currency_symbol)?$orgs_info->currency_symbol:'$';
		} else {
			global $woocommerce;
			$data = !empty($woocommerce->cart->cart_contents) ? $woocommerce->cart->cart_contents:[];
			foreach( $data as $key=>$value ) {			
				if( Crowdfundly_Helper::get_crowdfundly_product_id() == $value['product_id'] ) {
					$organization = Crowdfundly_Settings::get('organization');	
					$username 		= isset($organization->username)?$organization->username:''; 
					$orgs_info 	 = Crowdfundly_Api::get('organization', [], $username);
					return isset($orgs_info->currency_symbol)?$orgs_info->currency_symbol:'$';
				} 
			}
		}
		return $currency_symbol;
	}	

	/**
     * Check donation product in cart and change currency by SaaS currency
     * @since 1.0.0
     * @return string, string
     */				
	public function change_wc_currency_by_saas( $currency ) {
		
		if( is_admin() ) return $currency;
		if( Crowdfundly_Helper::get_crowdfundly_product_id() == get_the_ID() ){
			$organization 	= Crowdfundly_Settings::get('organization');
			$username 		= isset($organization->username)?$organization->username:''; 	
			$orgs_info 	 	= Crowdfundly_Api::get('organization', [], $username);			
			return isset($orgs_info->currency_code)?$orgs_info->currency_code:'USD';
		} else {
			global $woocommerce;
			$data = !empty($woocommerce->cart->cart_contents) ? $woocommerce->cart->cart_contents:[];
			foreach( $data as $key=>$value ) {
				if( Crowdfundly_Helper::get_crowdfundly_product_id() == $value['product_id'] ){
					$organization 	= Crowdfundly_Settings::get('organization');	
					$username 		= isset($organization->username)?$organization->username:''; 
					$orgs_info 	 	= Crowdfundly_Api::get('organization', [], $username);					
					return isset($orgs_info->currency_code)?$orgs_info->currency_code:'USD';
				} 
			}
		}

		return $currency;		
	}	

	/**
     * Check payment is completed
	 * 
     * @since 1.0.0
     * @return string, string
     */	
	public function crowdfundly_donation_complete( $order_id ){   

		$order 				= wc_get_order( $order_id );	
		$order_item_meta_id = 0;
		foreach( $order->get_items() as $item_id => $item){
			$campaignId = $item->get_meta('crowdfundly_campaign_id');			
			$order_item_meta_id = $item_id;
			if ( isset($campaignId) ) {				
				$token 			= Crowdfundly_Settings::get('crowdfundly_option_api_key'); 
				$billingName 	= $order->get_billing_first_name() .' '. $order->get_billing_last_name();
				$billingEmail 	= $order->get_billing_email();			
				$amount 		= $order->get_total();
				$paymentId 		= $order->get_transaction_id();
				$is_anonymous   = !empty( $item->get_meta('crowdfundly_give_anonymously') ) ? $item->get_meta('crowdfundly_give_anonymously'):0;
				
				$body = array( 
					'token' 		=> $token, 
					'campaign_id' 	=> $campaignId,
					'name' 			=> $billingName,
					'email' 		=> $billingEmail,
					'payment_id' 	=> $paymentId,
					'amount' 		=> $amount,
					'is_anonymous'	=> $is_anonymous,
					'tip_amount'	=> 0
				);
				if( ! empty( $item->get_meta('crowdfundly_offer_id') ) ) {
					$body['offer_id']   	   = $item->get_meta('crowdfundly_offer_id');
					$body['shipping_amount']   = $item->get_meta('crowdfundly_shipping_amount');
					$body['shipping_location'] = $item->get_meta('crowdfundly_shipping_location');
				} 
				
				$url = CROWDFUNDLY_APP_URL . '/api/v1/wp/woocommerce-contributions';
				$response = wp_remote_post( esc_url($url), array(
					'method' 		=> 'POST',
					'timeout' 		=> 45,
					// 'redirection' 	=> 5,
					// 'httpversion' 	=> '1.0',
					// 'blocking' 		=> true,
					'headers' 		=> array(),
					'body' 			=> $body,
					'cookies' 		=> array()
					)
				);
				$status_code 		= wp_remote_retrieve_response_code( $response );
				$response_message   = wp_remote_retrieve_response_message( $response );
				if ( $status_code != 200 ) {
					$message =  array(
						'status' => 'error',
						'status_code' => $status_code,
						'error_message' => $response_message, 
					);
				} else {
					$message = $response_message;
				}
				
				if(isset($response) ){
					if($order_item_meta_id !=0){
						wc_add_order_item_meta($order_item_meta_id, 'crowdfundly_transaction_status', $message); 
					}
				}			

			}
		}
	}

	/**
     * Add custom cart field
	 * 
     * @since 1.0.0
     * @return array
     */	
	public function crowdfundly_custom_cart_field($checkout) {
		global $woocommerce;

		foreach( $woocommerce->cart->get_cart() as $items ) {
			if ( isset( $items['crowdfundly_offer_id'] ) ) {
				$campaign = Crowdfundly_Api::get('campaign', [], $items['crowdfundly_campaign_slug']);				

				foreach ( $campaign->offers as $offer ){
					if($offer->id == $items['crowdfundly_offer_id']){
						$shipping_info = json_decode( $offer->shipping_info); 	
						woocommerce_form_field( 'crowdfundly_shipping_amount', array(
							'type'          => 'select',
							'class'         => array( 'form-row-select' ),
							'required'      => true,
							'label'         => __( 'Shipping Location', 'crowdfundly' ),
							'options'       => $this->get_formated_shipping_info($shipping_info, $campaign->currency->symbol, $campaign->currency->currency_code)
							)
						);
						woocommerce_form_field( 'crowdfundly_shipping_address', array(
							'type'          => 'text',
							'class'         => array( 'form-row-wide' ),
							'required'      => true,
							'label'         => __( 'Shipping Address', 'crowdfundly' ),	
							'placeholder' 	=> __( 'Shipping Address', 'crowdfundly' )							
							)
						);	
						woocommerce_form_field( 'crowdfundly_shipping_location', array(
							'type'          => 'hidden',
							'class'         => array( 'form-row-wide' ),
							'required'      => true,						
							)
						);											
					}
				}
				
			}

			if ( isset( $items['crowdfundly_donation'] ) ) {
				woocommerce_form_field( 'crowdfundly_give_anonymously', array(
					'type'      => 'checkbox',
					'class'     => array('input-checkbox'),
					'label'     => __('Give Anonymously?', 'crowdfundly'),
				),  WC()->checkout->get_value( 'crowdfundly_give_anonymously' ) );			
			}
		}
	}

	/**
     * Display formated shipping cost
	 * 
     * @since 1.0.0
     * @return array, string, string
     */		
	public function get_formated_shipping_info($shipping=[], $symobol='$', $currency='USD'){
		$data = [];
		$data[''] = __('Select Shipping Location', 'crowdfundly');
		foreach($shipping as $ship){
			$data[$ship->shippingFee]= $ship->location .'-'.$symobol.number_format($ship->shippingFee,2).' '.$currency;
		}

		return $data;
	}	

	/**
     * Change place order button label
	 * 
     * @since 1.0.0
     * @return string
     */
	public function change_place_order_label( $button_text ) {
		
		if( Crowdfundly_Helper::campaign_product_is_in_cart() ) {
			$button_text = __('Contribute', 'crowdfundly');
		}
		return $button_text;
	 
	}
	
	/**
     * Update order meta based on shipping info
	 * 
     * @since 1.0.0
     * @return int
     */	
	public function give_anonymously_field_update_order_meta( $order_id ) {

		$order 				= wc_get_order( $order_id );	
		$order_item_meta_id = 0;
		foreach( $order->get_items() as $item_id => $item ) {
			$campaignId = $item->get_meta('crowdfundly_campaign_id');			
			$order_item_meta_id = $item_id;
			if ( isset($campaignId) ) {	
				if ( ! empty( $_POST['crowdfundly_give_anonymously'] ) ) {
					wc_add_order_item_meta($order_item_meta_id, 'crowdfundly_give_anonymously', sanitize_text_field($_POST['crowdfundly_give_anonymously'])); 
				}
				if ( ! empty( $_POST['crowdfundly_shipping_amount'] ) ) {
					wc_add_order_item_meta($order_item_meta_id, 'crowdfundly_shipping_amount', sanitize_text_field($_POST['crowdfundly_shipping_amount'])); 
				}
				if ( ! empty( $_POST['crowdfundly_shipping_address'] ) ) {
					wc_add_order_item_meta($order_item_meta_id, 'crowdfundly_shipping_address', sanitize_text_field($_POST['crowdfundly_shipping_address'])); 
				}
				if ( ! empty( $_POST['crowdfundly_shipping_location'] ) ) {
					wc_add_order_item_meta($order_item_meta_id, 'crowdfundly_shipping_location', sanitize_text_field($_POST['crowdfundly_shipping_location'])); 
				}												
			}
		}
		
	
	}
	
	/**
     * Update order meta
	 * 
     * @since 1.0.0
     * @return object
     */	
	public function display_give_anonymously_on_order_edit_pages( $order ){
		$give_anonymously = get_post_meta( $order->get_id(), 'give_anonymously', true );
		if( $give_anonymously == 1 )
			echo '<p><strong>'.__('Is anonymously?').': </strong> <span>'.__('Yes').'</span></p>';
	}
	
	/**
     * Checkout validation
	 * 
     * @since 1.0.0
     * @return object
     */	
	public function checkout_validate( ){
		if( ( isset($_POST['crowdfundly_shipping_location']) && empty($_POST['crowdfundly_shipping_location']) ) || ( isset($_POST['crowdfundly_shipping_amount']) && empty($_POST['crowdfundly_shipping_amount']) ) ){
			wc_add_notice( __( 'Shipping Location is a required field.', 'crowdfundly' ), 'error' );
		}		
	}

	/**
     * Add shipping fee
	 * 
     * @since 1.0.0
     * @return object
     */	
	function add_shipping_fee( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

		$fee = WC()->session->get( 'crowdfundly_shipping_fee' );
		foreach ( WC()->cart->get_cart() as $key =>$item ) {
			// Add the donation to the product price
			if ( isset( $item['crowdfundly_donation']) && isset( $item['crowdfundly_offer_id']) ) {
				if(isset($fee) && $fee != 0 && is_numeric($fee)){
					$cart->add_fee( __('Shipping Fee', 'crowdfundly'), $fee );
				}
			}
		}
		
	}

	/**
     * Update cart 
	 * 
     * @since 1.0.0
     * @return object
     */		
	public function crowdfundly_update_cart() {
		$crowdfundly_shipping_fee = sanitize_text_field($_POST['crowdfundly_shipping_fee']);
		WC()->session->set('crowdfundly_shipping_fee', $crowdfundly_shipping_fee );
		wp_send_json(true);
	}

	/**
     * Remove cart data 
	 * 
     * @since 1.0.0
     * @return object
     */	
	public function crowdfundly_remove_cart_data() {		
		if( function_exists('WC') ){
			WC()->session->__unset('crowdfundly_shipping_fee'); 
		}
	}

	public static function fav_icon() {
		$user = Crowdfundly_Settings::getUser();
		$username = isset( $user->username ) ? $user->username : null;
		$org_page_id = get_option( 'crowdfundly_organization_page_id' );
		$all_camp_page_id = get_option( 'crowdfundly_all_campaigns_page_id' );
		$single_camp_page_id = get_option( 'crowdfundly_single_campaign_page_id' );
		
		if ( $username && ( get_the_ID() == $org_page_id || $all_camp_page_id || $single_camp_page_id ) ) {
			$orgs_info = Crowdfundly_Api::get('organization', [], $username);
			$favicon = ( is_object( $orgs_info ) && is_object( $orgs_info->favicon ) ) ? $orgs_info->favicon->source_path : null;

			if ( $favicon ) {
				printf( '<link rel="%s" href="%s" type="%s" />',
					'shortcut icon',
					esc_url( $favicon ),
					'image/x-icon'
				);
			}
		}
	}

}
