<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpdeveloper.net/
 * @since      1.0.0
 * @package    Crowdfundly
 * @subpackage Crowdfundly/admin
 * @author     WPDeveloper
 */
class Crowdfundly_Admin {
 
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public static $prefix = 'crowdfundly_meta_';
	public static $option_prefix = 'crowdfundly_option_';	

	/**
     * The slug of plugin main page
     * @since 1.0.0
     * @var string
     */
	private $slug = 'crowdfundly-admin';

	private $is_dashboard_page;

	private $is_settings_page;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = (new Crowdfundly_Settings());

		$this->is_dashboard_page = Crowdfundly_Helper::is_current_page(Crowdfundly_Helper::$pages['dashboard']);
		$this->is_settings_page = Crowdfundly_Helper::is_current_page(Crowdfundly_Helper::$pages['settings']);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param 	 none
	 */
	public function enqueue_styles() {

		if ( $this->is_dashboard_page || $this->is_settings_page ) {
			wp_enqueue_style( $this->plugin_name . '-bootstrap', CROWDFUNDLY_URL . 'assets/bootstrap/css/bootstrap.min.css', [], $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-fontawesomes', esc_url('//use.fontawesome.com/releases/v5.12.0/css/all.css'), [], $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/crowdfundly-admin.css', [], $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-eicon', plugin_dir_url( __FILE__ ) . 'css/eicon/style.css', [], $this->version, 'all' );
		}
		
		wp_enqueue_style( $this->plugin_name . '-admin-common-css', plugin_dir_url( __FILE__ ) . 'css/crowdfundly-admin-common.css', [], $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param 	 none
	 */
	public function enqueue_scripts() {

		if ( $this->is_dashboard_page || $this->is_settings_page ) {
			wp_enqueue_script( $this->plugin_name . '-js-cookie', CROWDFUNDLY_URL . 'assets/js-cookie/js.cookie.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name . '-swal', CROWDFUNDLY_ADMIN_URL . 'js/sweetalert.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name . '-form-validate', '//cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name. '-admin-script', plugin_dir_url( __FILE__ ) . 'js/crowdfundly-admin.js', array( 'jquery' ), $this->version, true );
		}


		$site_url 						= site_url();
		$organization_page_slug 		= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_organization_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_organization_slug']:'crowdfundly-organization';
		$organization_url 				= $site_url .'/'.$organization_page_slug;
		$single_camp_page_slug 			= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_single_campaign_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_single_campaign_slug']:'crowdfundly-campaign';
		$single_camp_url 				= $organization_url.'/'.$single_camp_page_slug;

		wp_localize_script( $this->plugin_name . '-admin-script', 'crowdfundlyAuth', 
			[
				'ajax_url' 						=> admin_url( 'admin-ajax.php' ),
				'nonce'    						=> wp_create_nonce( 'crowdfundly_admin_nonce' ),
				'has_bearer_token' 				=> Crowdfundly_Settings::hasToken(),
				'bearer_token' 					=> Crowdfundly_Settings::getToken(),
				'user' 							=> Crowdfundly_Settings::getUser(),
				'is_dashboard_page' 			=> Crowdfundly_Helper::is_current_page(Crowdfundly_Helper::$pages['dashboard']),
				'is_setting_page' 				=> Crowdfundly_Helper::is_current_page(Crowdfundly_Helper::$pages['settings']),
				'countries' 					=> Crowdfundly_Settings::get_countries(),
				'currencies' 					=> Crowdfundly_Settings::get_currencies(),
				'email_login'					=> Crowdfundly_Settings::is_email_log_in(),
				'plugin_url' 					=> admin_url('admin.php?page=crowdfundly-admin' ),
				'logout_api_url'				=> site_url( '?rest_route=/crowdfundly/api/logout/' ),
				'changed_organization'			=> site_url( '?rest_route=/crowdfundly/api/changed-organization/' ),
				'warning'						=> __( 'Warning', 'crowdfundly' ),
				'email_not_found'				=> __( 'Email not Found', 'crowdfundly' ),
				'api_not_provided'				=> __( 'API Key not provided!', 'crowdfundly' ),	
				'success'						=> __( 'Success', 'crowdfundly' ),
				'success_authenticated'			=> __( 'Successfully Authenticated!', 'crowdfundly' ),
				'failed'						=> __( 'Failed', 'crowdfundly' ),
				'failed_authentication'			=> __( 'Authentication failed! Please enter a valid key.', 'crowdfundly' ),							
				'connecting'					=> __( 'Connecting...', 'crowdfundly' ),
				'connect'						=> __( 'Connect', 'crowdfundly' ),
				'success_disconnected'			=> __( 'Successfully Disconnected!', 'crowdfundly' ),
				'disconnecting'					=> __( 'Disconnecting...', 'crowdfundly' ),
				'saving'						=> __( 'Saving...', 'crowdfundly' ),
				'error'							=> __( 'Error', 'crowdfundly' ),
				'save_settings_error'			=> __( 'Someting went wrong', 'crowdfundly' ),
				'save_settings_success'			=> __( 'Settings saved successfully', 'crowdfundly' ),
				'settings_not_saved'			=> __( 'Settings Not Saved!', 'crowdfundly' ),
				'click_ok_to_cont'				=> __( 'Click OK to continue', 'crowdfundly' ),
				'save_settings'					=> __( 'Save Settings', 'crowdfundly' ),
				'site_url'						=> site_url(),
				'organization_url'				=> $organization_url,
				'campaign_url'					=> $single_camp_url,
			]
		);

	}
	
	/**
	 * Handle all ajax call
	 *
	 * @since    1.0.0
	 * @param 	 none
	 */	
	public function ajax_call() {
		add_action('wp_ajax_crowdfundly_connect_api', array( $this, 'crowdfundly_connect_api') );
		add_action('wp_ajax_crowdfundly_disconnect_api', array( $this, 'crowdfundly_disconnect_api') );

		add_action('wp_ajax_crowdfundly_signup_auth', array( $this, 'crowdfundly_signup_auth') );
		add_action('wp_ajax_crowdfundly_email_login_auth', array( $this, 'crowdfundly_email_login_auth') );

		add_action('wp_ajax_crowdfundly_general_settings', array( $this, 'crowdfundly_general_settings') );
	}

	/**
	 * Register builder JavaScript files
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */	
    public function dashboard_scripts()
    {
        if ( Crowdfundly_Settings::hasToken() && $this->is_dashboard_page ) {
            wp_enqueue_style(
                $this->plugin_name  . '-font',
                plugin_dir_url(__FILE__) . 'css/all.css', array(), $this->version, 'all'
            );
			
			wp_enqueue_script( $this->plugin_name . '-vue-1', plugin_dir_url(__FILE__) . 'js/crowdfundly-vue-1.min.js', [], $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-vue-2', plugin_dir_url(__FILE__) . 'js/crowdfundly-vue-2.min.js', [], $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-vue-3', plugin_dir_url(__FILE__) . 'js/crowdfundly-vue-3.min.js', [], $this->version, true );
        }
    }

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */	
    public function settings_scripts()
    {
		if ( $this->is_settings_page ) { 
			wp_enqueue_style( $this->plugin_name, plugin_dir_url(__FILE__) . 'css/crowdfundly-admin-settings.min.css', [], $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-settings', plugin_dir_url(__FILE__) . 'css/crowdfundly-settings.css', [], $this->version, 'all' );
			wp_enqueue_script( $this->plugin_name . '-settings', plugin_dir_url(__FILE__) . 'js/crowdfundly-admin-settings.js', array( 'jquery' ), $this->version, true );
		}
    }

	/**
	 * Register the menu for the admin area.
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */	
	public function menu_page() {

		if( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        // Added main menu page
        add_menu_page(
            'Crowdfundly',
            'Crowdfundly',
            'delete_users',
            $this->slug,
            array( $this, 'main_page' ),
            CROWDFUNDLY_ADMIN_URL . 'images/crowdfundly_icon_gray.png',
            40
        );
        /**
         * Submenu pages
         * defined filter crowdfundly_admin_menu for adding admin menus
         *
         */
        $submenu_pages = apply_filters( 'crowdfundly_admin_menu', array(
            Crowdfundly_Helper::$pages['dashboard']   => array(
                'title'      => __('Crowdfundly Dashboard', 'crowdfundly'),
                'menu_title'      => __('Dashboard', 'crowdfundly'),
                'capability' => 'delete_users',
                'callback'   => array( $this, 'main_page' )
            ),
            Crowdfundly_Helper::$pages['settings']   => array(
                'title'      => __('Crowdfundly Settings', 'crowdfundly'),
                'menu_title' => __('Settings', 'crowdfundly'),
                'capability' => 'delete_users',
                'callback'   => array( $this, 'settings_page' )
			)
        ) );
        // register submenu pages
        foreach ($submenu_pages as $slug => $page){
            add_submenu_page(
                $this->slug,
                $page['title'],
                $page['menu_title'],
                $page['capability'],
                $slug,
                $page['callback']
            );
        }
	}

	/**
	 * Dashboard page
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */	
	public function main_page() {
		// if ( Crowdfundly_Settings::hasToken() && Crowdfundly_Settings::getUser() ) {
		if ( Crowdfundly_Settings::hasToken() ) {
            require_once CROWDFUNDLY_ADMIN_DIR_PATH . 'partials/crowdfundly-dashboard.php';
		} else {
			require_once CROWDFUNDLY_ADMIN_DIR_PATH . 'partials/crowdfunly-sign-in.php';
		}
	}
	
	/**
	 * Setting page
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */
	public function settings_page() {
		// if ( Crowdfundly_Settings::hasToken() && Crowdfundly_Settings::getUser() ) {
		if ( Crowdfundly_Settings::hasToken() ) {
			$this->settings_scripts();
			$settings_args = Crowdfundly_Settings::settings_args();
			$value = Crowdfundly_Settings::get();
			require_once CROWDFUNDLY_ADMIN_DIR_PATH . 'partials/crowdfundly-settings-display.php';
		} else {
			require_once CROWDFUNDLY_ADMIN_DIR_PATH . 'partials/crowdfunly-sign-in.php';
		}
	}

	/**
	 * Connect with server by api key and authenticated
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */
	public function crowdfundly_connect_api() {
		$security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
		if ( false == $security ) {
			return;
		}
		
        $api_key = sanitize_text_field( $_POST['crowdfundly_connect_apikey'] );
		// $authentication_result = Crowdfundly_Api::authenticate($api_key);

		$wp_response = [
			'organization' => null,
			'code' => null,
			'token' => null, 
			'email_login' => false,
			'countries' => null,
			'currencies' => null
		];

		$request = [
            'body' => [ 'token' => $api_key ]
        ];
		$request['headers']['Authorization']  = 'Bearer ' . $api_key;
		$response = wp_remote_post( Crowdfundly_Api::$post_endpoints['authenticate'], $request );
		if (is_wp_error($response)) {
			$message = __('Something went wrong! Please try again later.', 'crowdfundly');
			$return = array('message' => $message);
			wp_send_json_error($return);			
		}

		$wp_response['code'] = wp_remote_retrieve_response_code( $response );
		$response_body = json_decode($response['body']);
		$wp_response['token'] = $response_body->token;

		if ( $wp_response['code'] === 200 ) {
			$org_id = $response_body->organization->id;
			$wp_response['countries'] = $response_body->countries;
			$wp_response['currencies'] = $response_body->currencies;

			$args = array(
				'headers'     => array(
					'Authorization' => 'Bearer ' . $wp_response['token'],
				),
				'timeout' => 800,
			);
			$user_response = wp_remote_get( Crowdfundly_Api::$get_endpoints['user'], $args );
			$user_response_body = json_decode( $user_response['body'] );

			$wp_response['organization'] = $user_response_body->organizations;

			$settings = [ 'crowdfundly_option_api_key' => $api_key, 'token' => $wp_response['token'], 'email_login' => false, 'countries' => $wp_response['countries'], 'currencies' => $wp_response['currencies'] ];
			update_option( 'crowdfundly_settings', $settings );

			if ( ! empty( $user_response_body ) && ! empty( $user_response_body->organizations ) ) {
				foreach ( $user_response_body->organizations as $organization ) {
					if ( $organization->id === $org_id ) {
						$wp_response['organization'] = $organization;
						Crowdfundly_Settings::updateUser($wp_response['organization']);
					}
				}
			}
		}
		
		wp_send_json(
			[
				'code' 					=> $wp_response['code'],
				'email_login' 			=> false,
				'token' 				=> $wp_response['token'],
				'auth' 					=> $response_body,
				'organization' 			=> $wp_response['organization'],
				'countries' 			=> $wp_response['countries'],
				'currencies' 			=> $wp_response['currencies']
			],
			$wp_response['code']
		);
		

	}

	/**
	 * Disconnect api
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */
	public function crowdfundly_disconnect_api()
    {
		$security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
		if ( false == $security ) {
			return;
		}

        delete_option('crowdfundly_settings');
        delete_option('crowdfundly_user');

        wp_send_json([
            'success' => true
        ]);

	}

	public function crowdfundly_signup_auth() {
		$security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
		if ( false == $security ) {
			return;
		}

		$signup_data = $_POST['signupData'];
		
		$url = Crowdfundly_Api::$post_endpoints['signup'];
		$response = wp_remote_post( esc_url( $url ), [
			'headers'     => [ 'Accept' => 'application/json' ],
			'body' => $signup_data,
			'timeout'     => 300,
		] );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code === 200 ) {
			$this->email_login_after_reg($signup_data);

			wp_die();
		}

		// print_r($response);
		wp_send_json( [ 'code' => $response_code, 'response' => $response ], $response_code );
		wp_die();
	}

	public function email_login_after_reg($signup_data) {
		$authData = [];

		$authData['email'] = $signup_data['email'];
		$authData['password'] = $signup_data['password'];
		$authData['type'] = $signup_data['type'];

		$wp_response = [ 
			'user_data' => null,
			'code' => 422,
			'token' => null, 
			'email_login' => false,
			'countries' => null,
			'currencies' => null
		];

		$url = Crowdfundly_Api::$post_endpoints['email_login'];
		$response = wp_remote_post( esc_url( $url ), [
			'headers'     => [ 'Accept' => 'application/json' ],
			'body' => $authData,
			'timeout'     => 500,
		] );
		$wp_response['code'] = wp_remote_retrieve_response_code( $response );
		$response_body = json_decode( $response['body'] );
		$wp_response['token'] = $response_body->access_token;

		if ( $wp_response['code'] === 200 ) {
			$countries_response = wp_remote_get( 'https://api.crowdfundly.app/api/v1/countries' );
			$currencies_response = wp_remote_get( 'https://api.crowdfundly.app/api/v1/currencies' );
			$wp_response['countries'] = json_decode( $countries_response['body'] );
			$wp_response['currencies'] = json_decode( $currencies_response['body'] );

			$settings = [ 'token' => $wp_response['token'], 'email_login' => true, 'countries' => $wp_response['countries'], 'currencies' => $wp_response['currencies'] ];
			update_option( 'crowdfundly_settings', $settings );

			$args = array(
				'headers'     => array(
					'Authorization' => 'Bearer ' . $wp_response['token'],
				),
				'timeout' => 800,
			); 
			$user_response = wp_remote_get( Crowdfundly_Api::$get_endpoints['user'], $args );
			$user_response_body = json_decode( $user_response['body'] );
			$wp_response['user_data'] = !empty( $user_response_body->organizations ) ? $user_response_body->organizations[0] : null;
			if ( $wp_response['user_data'] ) {
				Crowdfundly_Settings::updateUser($wp_response['user_data']);
			}
		}

		wp_send_json( [
			'user' => $wp_response['user_data'],
			'code' => $wp_response['code'],
			'token' => $wp_response['token'], 
			'email_login' => true,
			'countries' => $wp_response['countries'],
			'currencies' => $wp_response['currencies']
		], $wp_response['code'] );
	}

	public function crowdfundly_email_login_auth() {
		$security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
		if ( false == $security ) {
			return;
		}

		$email_login_data = $_POST['emailLoginData'];

		$wp_response = [
			'user_data' => null,
			'code' => null,
			'token' => null, 
			'email_login' => false,
			'countries' => null,
			'currencies' => null
		];

		$url = Crowdfundly_Api::$post_endpoints['email_login'];
		$response = wp_remote_post( esc_url( $url ), [
			'headers'     => [ 'Accept' => 'application/json' ],
			'body' => $email_login_data,
			'timeout'     => 300,
		] );
		$wp_response['code'] = wp_remote_retrieve_response_code( $response );
		$response_body = json_decode($response['body']);

		if ( $wp_response['code'] === 200 ) {
			$countries_response = wp_remote_get( 'https://api.crowdfundly.app/api/v1/countries' );
			$currencies_response = wp_remote_get( 'https://api.crowdfundly.app/api/v1/currencies' );
			$wp_response['countries'] = json_decode( $countries_response['body'] );
			$wp_response['currencies'] = json_decode( $currencies_response['body'] );

			$wp_response['token'] = $response_body->access_token;
			$settings = [ 'token' => $wp_response['token'], 'email_login' => true, 'countries' => $wp_response['countries'], 'currencies' => $wp_response['currencies'] ];
			update_option( 'crowdfundly_settings', $settings );

			$args = array(
				'headers'     => array(
					'Authorization' => 'Bearer ' . $wp_response['token'],
				),
				'timeout' => 800,
			);
			$user_response = wp_remote_get( Crowdfundly_Api::$get_endpoints['user'], $args );
			$user_response_body = json_decode( $user_response['body'] );
			$wp_response['user_data'] = !empty( $user_response_body->organizations ) ? $user_response_body->organizations[0] : null;
			if ( $wp_response['user_data'] ) {
				Crowdfundly_Settings::updateUser($wp_response['user_data']);
			}
		}

		wp_send_json( [ 
			'user' => $wp_response['user_data'],
			'code' => $wp_response['code'],
			'token' => $wp_response['token'], 
			'email_login' => true,
			'countries' => $wp_response['countries'],
			'currencies' => $wp_response['currencies']
		], $wp_response['code'] );

		wp_die();
	}

	/**
	 * Save settings 
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */
	public function crowdfundly_general_settings()
    {
		$security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
		if ( false == $security ) {
			return;
		}
		
		$org_id = get_option('crowdfundly_organization_page_id');
		$all_camp_id = get_option('crowdfundly_all_campaigns_page_id');
		$single_camp_id = get_option('crowdfundly_single_campaign_page_id');
		$page_ids = [ $org_id, $all_camp_id, $single_camp_id ];

		$form_data = wp_unslash($_POST['form_data']);
		$data = [];
		$routes = [];
		foreach ( $form_data as $key => $value ) {
			$data[$value['name']] = $value['value'];
			if ( count( $form_data ) == 5 && $key > 1 ) {
				$routes[] = $value['value'];
			} elseif ( count( $form_data ) == 4 && $key > 0 ) {
				$routes[] = $value['value'];
			} elseif ( count( $form_data ) == 3 ) {
				$routes[] = $value['value'];
			}
		}
		
		if ( ! empty( $routes ) ) {
			foreach ( $routes as $key => $route ) {
				$page = get_post( $page_ids[$key] );
				
				if ( ! empty( $route ) && $page->post_name != $route ) {
					$page_route = strtolower( str_replace( " ", "-", $route ) );
					wp_update_post( [
						'ID' => $page_ids[$key],
						'post_name' => esc_html( $page_route )
					] );
				}
			}
		}

		Crowdfundly_Helper::save_data( Crowdfundly_Helper::builder_data( $data, self::$option_prefix ), self::$option_prefix );

		$site_url 						= site_url();
		$organization_page_slug 		= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_organization_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_organization_slug']:'crowdfundly-organization';
		$organization_url 				= $site_url .'/'.$organization_page_slug;
		$single_camp_page_slug 			= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_single_campaign_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_single_campaign_slug']:'crowdfundly-campaign';
		$single_camp_url 				= $organization_url.'/'.$single_camp_page_slug;

        wp_send_json([
			'success' => true,
			'form_data' => $form_data,
			'organization_url' => $organization_url,
			'campaign_url' => $single_camp_url,
        ]);

	}
	
	/**
	 * Create Product
	 *
	 * @since    1.0.0
	 * @param 	 none 
	 */	
	public function create_product() 
	{

		$organization 	= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_organization_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_organization_slug']:'';
		$all_camp 		= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_all_campaign_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_all_campaign_slug']:'';
		$single_camp 	= isset(Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_single_campaign_slug'])?Crowdfundly_Settings::get()['crowdfundly_option_crowdfundly_single_campaign_slug']:'';
		$automatic_page = isset(Crowdfundly_Settings::get()['crowdfundly_option_disable_automatice_shortcode_page'])?Crowdfundly_Settings::get()['crowdfundly_option_disable_automatice_shortcode_page']:0;				
		
		//Check automatice page create
		if( $automatic_page != 1 ){
			if( !self::the_slug_exists($organization) ) {
				\Crowdfundly_Activator::create_organization_page();
			}
			if( !self::the_slug_exists($all_camp) ) {
				$page_id = get_option('crowdfundly_organization_page_id');
				\Crowdfundly_Activator::create_all_campaigns_page($page_id);
			}
			if( !self::the_slug_exists($single_camp) ) {
				$page_id = get_option('crowdfundly_organization_page_id');
				\Crowdfundly_Activator::create_single_campaign_page($page_id);
			}
		}
		
		$is_enabled_wc_payment = isset(Crowdfundly_Settings::get()['crowdfundly_option_wc_payment'])?Crowdfundly_Settings::get()['crowdfundly_option_wc_payment']:'';
		if( $is_enabled_wc_payment == 1 && class_exists('WooCommerce') ) {

			if( self::the_slug_exists('crowdfundly-campaign-product') ) {
				return;
			}

			$pages = array(
				array(
					'post_title' => __( 'Crowdfundly Campaign Product', 'crowdfundly' ),
					'slug'       => 'crowdfundly-campaign-product',					
					'content'    => __( 'Crowdfundly Campaign Product','crowdfundly' ),					
				),
			); 
			
			if ( $pages ) {
				foreach ( $pages as $page ) {
					$post_id = self::createPage( $page );
					if($post_id){
						$child_product = wc_get_product($post_id);
						$child_product->set_catalog_visibility('hidden');
						$child_product->save();
					}					
				}
			}    			
		}

	}

	/**
     * Create Page
     *
     * @param [type] $page
     * @return void
     */
    private static function createPage( $page ) {

        $page_obj = get_page_by_path( $page['post_title'] );

        if ( ! $page_obj ) {
            $post_id = wp_insert_post( array(
                'post_title'     => $page['post_title'],
                'post_name'      => $page['slug'],
                'post_content'   => $page['content'],
                'post_status'    => 'publish',
                'post_type'      => 'product',
                'comment_status' => 'closed',
            ) );

            if ( $post_id && ! is_wp_error( $post_id ) ) {
				wp_set_object_terms( $post_id, 'simple', 'product_type' );
				update_post_meta( $post_id, '_stock_status', 'instock');
				update_post_meta( $post_id, 'total_sales', '0' );
				update_post_meta( $post_id, '_downloadable', 'no' );
				update_post_meta( $post_id, '_virtual', 'yes' );
				update_post_meta( $post_id, '_regular_price', 1.0 );
				update_post_meta( $post_id, '_sale_price', '' );
				update_post_meta( $post_id, '_purchase_note', '' );
				update_post_meta( $post_id, '_featured', 'no' );
				update_post_meta( $post_id, '_weight', '' );
				update_post_meta( $post_id, '_length', '' );
				update_post_meta( $post_id, '_width', '' );
				update_post_meta( $post_id, '_height', '' );
				update_post_meta( $post_id, '_product_attributes', [] );
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
				update_post_meta( $post_id, '_sale_price_dates_to', '' );
				update_post_meta( $post_id, '_price', 1.0 );
				update_post_meta( $post_id, '_sold_individually', '' );
				update_post_meta( $post_id, '_manage_stock', 'no' );
				update_post_meta( $post_id, '_backorders', 'no' );
				update_post_meta( $post_id, '_stock', '' );				
                return $post_id;
            }
        }

        return false;
    }	

	/**
     * Check slug exists or not
     *
     * @param [type] $post_name
     * @return void
     */
    public static function the_slug_exists($post_name) 
    {
        global $wpdb;
        $table = $wpdb->prefix . 'posts';
        if( $wpdb->get_row($wpdb->prepare("SELECT post_name FROM $table WHERE post_name = '%s'", $post_name), 'ARRAY_A') ) {
            return true;
        } else {
            return false;
        }
    }

	public static function fav_icon() {
		$user = Crowdfundly_Settings::getUser();
		$username = isset( $user->username ) ? $user->username : null;
		$admin_page = isset( $_GET['page'] ) ? Crowdfundly_Helper::is_current_page($_GET['page']) : null;
		// $org_page_id = get_option( 'crowdfundly_organization_page_id' );
		// $all_camp_page_id = get_option( 'crowdfundly_all_campaigns_page_id' );
		// $single_camp_page_id = get_option( 'crowdfundly_single_campaign_page_id' );
		
		if ( $username && $admin_page ) {
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