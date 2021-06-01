<?php

namespace Templately;

use Elementor\User;
use Templately\Helper;

class Elementor {
	protected static $_instance = null;

	public static function get_instance() {
		if ( static::$_instance === null ) {
			static::$_instance = new static;
		}

		return static::$_instance;
	}

	public function __construct() {
		API::get_instance();
		if ( class_exists( '\Elementor\Plugin' ) ) {
			Loader::add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
			Loader::add_action( 'elementor/editor/before_enqueue_scripts', $this, 'enqueue_scripts' );
		}
		Loader::add_action( 'admin_enqueue_scripts', $this, 'admin_scripts', 99 );
		Loader::add_action( 'enqueue_block_editor_assets', $this, 'admin_scripts', 99 );
		Loader::add_action( 'enqueue_block_editor_assets', $this, 'enqueue_styles', 99 );
	}

	public function enqueue_styles() {
		\wp_enqueue_style( 'templately-editor', TEMPLATELY_URL . 'assets/css/editor.css', [], TEMPLATELY_VERSION );
	}

	public function is_editor() {
		return is_admin() && isset( $_GET['action'] ) && 'elementor' === $_GET['action'];
	}

	public function is_elementor() {
		return isset( $_GET['action'] ) && 'elementor' === $_GET['action'];
	}

	private function get_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	public function admin_scripts( $hook ) {
		if ( ! in_array( $hook, array ( 'toplevel_page_templately', 'post-new.php', 'post.php' ) ) ) {
			return;
		}
		$this->enqueue_scripts( 'admin' );
	}

	protected function editor_platform() {
		global $current_screen;
		$editor = 'elementor';
		if ( isset( $_GET['action'] ) && 'elementor' === $_GET['action'] ) {
			$editor = 'elementor';
		}
		if ( $current_screen->is_block_editor() && ! ( isset( $_GET['action'] ) && 'elementor' === $_GET['action'] ) ) {
			$editor = 'gutenberg';
		}
		if ( $current_screen->base === 'toplevel_page_templately' ) {
			$editor = 'templately';
		}

		return $editor;
	}

	public function enqueue_scripts( $hook = '' ) {
		$categories = API::get_categories();
		global $current_screen;
		$suffix = ! ( defined( 'TEMPLATELY_SCRIPT_DEBUG' ) && TEMPLATELY_SCRIPT_DEBUG ) ? '.min' : '';
		\wp_enqueue_script(
			'templately-editor',
			TEMPLATELY_URL . "assets/js/templately{$suffix}.js",
			[ 'wp-i18n', 'wp-element', 'wp-components' ],
			\filemtime( TEMPLATELY_PATH . "assets/js/templately{$suffix}.js" ), $hook === 'admin'
		);

		\wp_set_script_translations( 'templately-editor', 'templately', TEMPLATELY_PATH . 'languages' );
		\wp_localize_script( 'templately-editor', 'TemplatelyAdmin', array (
			'url'             => \home_url( '/' ),
			'site_url'        => \home_url( '/' ),
			'api_nonce'       => \wp_create_nonce( 'wp_rest' ),
			'rest_url'        => get_rest_url() . 'templately/v1/',
			'ip_address'      => $this->get_ip(),
			'nonce'           => \wp_create_nonce( 'templately_nonce' ),
			'platform'        => $this->editor_platform(),
			'is_block_editor' => $current_screen->is_block_editor(),
			'is_elementor'    => $this->is_elementor(),
			'is_editor'       => $this->is_editor(),
			'is_admin'        => is_admin(),
			'admin'           => DB::get_user_specific_login_meta( '_templately_connect_data', [] ),
			'post_id'         => get_the_ID(),
			'default_image'   => \TEMPLATELY_ASSETS . 'images/cloud-item.svg',
			'not_found'       => \TEMPLATELY_ASSETS . 'images/no-item-found.png',
			'no_items'        => \TEMPLATELY_ASSETS . 'images/no-items.png',
			'loadingImage'    => \TEMPLATELY_ASSETS . 'images/loading-logo.gif',
			'templates'       => self::templates(),
			'reusable_blocks' => $this->reusable_blocks(),
			'is_logged_in'    => DB::get_user_specific_login_meta( '_templately_connected' ),
			'user_can_logout' => Login::user_can_logout(),
			'is_global_login' => Login::already_signedin_globally(),
			'is_linked_login' => Login::get_link_my_account(),
			'cloud_map'       => DB::get_option( '_templately_cloud_map', [] ),
			'categories'      => array (
				'blocks' => isset( $categories['item_categories'] ) ? $categories['item_categories'] : [],
				'packs'  => isset( $categories['pack_categories'] ) ? $categories['pack_categories'] : [],
				'pages'  => isset( $categories['page_categories'] ) ? $categories['page_categories'] : []
			),
			'cloud_activity'  => DB::get_user_specific_login_meta( '_templately_cloud_last_activity', array (
				'labels' => 'My Clouds',
				'value'  => 'clouds'
			) ),
			'platform_exists' => array (
				'gutenberg' => $this->platform_exists( 'gutenberg' ),
				'elementor' => $this->platform_exists( 'elementor' ),
			),
			'current_url' => admin_url('admin.php?page=templately'),
			'prettyurl' => $this->prettyurl(),
			'items_count' => API::get_items_count()
		) );

		if ( $hook !== 'admin' ) {
			\wp_enqueue_script(
				'templately-frontend-editor',
				TEMPLATELY_URL . "assets/js/editor{$suffix}.js",
				[ 'jquery', 'wp-i18n' ],
				\filemtime( TEMPLATELY_PATH . "assets/js/editor{$suffix}.js" ),
				true
			);
			\wp_set_script_translations( 'templately-frontend-editor', 'templately', TEMPLATELY_PATH . 'languages' );
		}

		\wp_enqueue_style( 'templately-poppins',
			'//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700', [], TEMPLATELY_VERSION
		);
		if ( ! defined( 'TEMPLATELY_SCRIPT_DEBUG' ) || ( defined( 'TEMPLATELY_SCRIPT_DEBUG' ) && ! TEMPLATELY_SCRIPT_DEBUG ) ) {
			\wp_enqueue_style( 'templately-style',
				TEMPLATELY_URL . 'assets/css/templately.css', [ 'templately-poppins' ], TEMPLATELY_VERSION
			);
		}
	}

	public function prettyurl(){
		if( isset( $_GET['t_route'] ) && ! empty( $_GET['t_route'] ) ) {
			$t_route = trim( $_GET['t_route'] );
			if( isset( $_GET['preview'] ) && $_GET['preview'] == true ) {
				$t_route .= '?preview=true';
			}

			return $t_route;
		}
		return '';
	}

	/**
	 * Platform Exists or Not
	 *
	 * @return void
	 */
	protected function platform_exists( $platform = 'elementor' ) {
		// $platform = isset( $_POST['platform'] ) ? trim( sanitize_text_field( $_POST['platform'] ) ) : 'elementor';
		if ( $platform === 'gutenberg' ) {
			$wp_version = get_bloginfo( 'version' );
			if ( version_compare( $wp_version, '5.0.0', '>=' ) ) {
				return true;
			} else {
				if ( \is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
					return true;
				} else {
					return false;
				}
			}
		}

		if ( $platform === 'elementor' ) {
			if ( \is_plugin_active( 'elementor/elementor.php' ) ) {
				return true;
			} else {
				return false;
			}
		}

		return false;
	}

	/**
	 * Get all saved templates from elementor library
	 * @return void
	 */
	public static function templates( $initial = true, $params = [] ) {
		$args = array (
			'post_type'   => 'elementor_library',
			'numberposts' => 10,
			'paged'       => 1,
		);
		if ( ! $initial ) {
			$args['paged'] = isset( $params['page'] ) ? $params['page'] : 1;
		}
		$templates      = new \WP_Query( $args );
		$templates_list = $templates->posts;
		$templateList   = array ();

		if ( count( $templates_list ) > 0 ) :
			$date_format = get_option( 'date_format', 'F j, Y' );
			foreach ( $templates_list as $post ) {
				$templateList[] = array (
					'id'          => $post->ID,
					'title'       => $post->post_title,
					'date'        => date( $date_format, strtotime( $post->post_date ) ),
					'type'        => ucwords( \get_post_meta( $post->ID, '_elementor_template_type', true ) ),
					'created_by'  => \get_the_author_meta( 'user_nicename', $post->post_author ),
					'preview_url' => \get_permalink( $post->ID ),
					'export_url'  => self::get_export_link( $post->ID ),
				);
			}
		endif;
		wp_reset_postdata();
		wp_reset_query();

		return array (
			'current_page' => $templates->query_vars['paged'],
			'total_page'   => $templates->max_num_pages,
			'items'        => $templateList,
		);
	}

	/**
	 * Get all saved templates from elementor library
	 * @return void
	 */
	public function reusable_blocks() {
		$templates    = new \WP_Query( array (
			'post_type' => 'wp_block'
		) );
		$templateList = array ();
		if ( $templates->have_posts() ) :
			$date_format = get_option( 'date_format', 'F j, Y' );
			foreach ( $templates->posts as $post ) {
				$templateList[] = array (
					'id'          => $post->ID,
					'title'       => $post->post_title,
					'date'        => date( $date_format, strtotime( $post->post_date ) ),
					'type'        => '',
					'created_by'  => \get_the_author_meta( 'user_nicename', $post->post_author ),
					'preview_url' => '',
					'export_url'  => '',
				);
			}
		endif;
		wp_reset_postdata();
		wp_reset_query();

		return $templateList;
	}

	/**
	 * From Elementor It Self!
	 *
	 * @param template id $template_id
	 *
	 * @return void
	 */
	private static function get_export_link( $template_id ) {
		return \add_query_arg(
			[
				'action'         => 'elementor_library_direct_actions',
				'library_action' => 'export_template',
				'source'         => 'local',
				'_nonce'         => \wp_create_nonce( 'elementor_ajax' ),
				'template_id'    => $template_id,
			],
			\admin_url( 'admin-ajax.php' )
		);
	}
}