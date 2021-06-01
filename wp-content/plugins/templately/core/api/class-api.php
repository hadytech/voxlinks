<?php

namespace Templately;

use Elementor\Plugin as ElementorPlugin;
use Elementor\TemplateLibrary\Source_Local;

class API {
	/**
	 * Instance of API
	 * @var API
	 */
	protected static $_instance = null;
	/**
	 * Templately API $url
	 * @var string
	 */
	protected static $url = 'https://app.templately.com/api/plugin';
	/**
	 * API Trigger Time;
	 * @var integer
	 */
	protected $trigger_time = null;

	/**
	 * Get the instance of API
	 * @return void
	 */
	public static function get_instance() {
		if ( static::$_instance === null ) {
			static::$_instance = new static;
		}

		return static::$_instance;
	}

	/**
	 * Will Invoked When The API Instanciated.
	 */
	public function __construct() {
		Loader::add_action( 'wp_ajax_get_templately', $this, 'get_templately' );
	}
	/**
	 * Checking the template eligibility for import.
	 */
	public function is_eligible_for_import( $template, $types = [ 'page', 'section' ] ){
		if( ! \is_plugin_active( 'elementor-pro/elementor-pro.php' ) &&
			isset( $template['type'] ) &&
			! in_array( $template['type'], $types, true ) ) {
			Helper::send_error( [
				'message' => 'You have to install/activate <a href="http://wpdeveloper.net/go/elementor" target="_blank">Elementor PRO</a> to import ' . ucwords($template['type']) . ' Blocks.',
				'type' => 'html'
			] );
		}
	}
	/**
	 * Get API Key
	 * @return void
	 */
	public function get_api() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );

		return ! empty( $api_key ) || is_string( $api_key ) ? $api_key : null;
	}

	/**
	 * AJAX actions
	 * @return void
	 */
	public function get_templately() {
		RequirementInstaller::raise_limits();

		if ( empty( $_POST ) || ! check_admin_referer( 'templately_nonce', 'nonce' ) ) {
			Helper::send_error( __( 'Something went wrong. Nonce Issue.', 'templately' ) );
		}
		$content_type = isset( $_POST['content_type'] ) ? \strtolower( sanitize_text_field( $_POST['content_type'] ) ) : false;
		if ( ! $content_type ) {
			Helper::send_error( __( 'Something went wrong.', 'templately' ) );
		}

		$this->trigger_time = DB::get_option( '_templately_trigger', false );

		switch ( $content_type ) {
			case 'install_requirements' :
				$data = $this->install_requirements();
				break;
			case 'platform_exists' :
				$data = $this->platform_exists();
				break;
			case 'verification_done' :
				$data = $this->verification_done();
				break;
			case 'get_dependencies' :
				$data = $this->get_dependencies();
				break;
			case 'get_templates' :
				$data = $this->get_templates();
				break;
			case 'blocks' :
				$data = $this->get_items();
				break;
			case 'pages' :
				$data = $this->get_items( 'pages' );
				break;
			case 'packs' :
				$data = $this->get_items( 'packs' );
				break;
			case 'search' :
				$data = $this->getItemsOrPacks();
				break;
			case 'check_dependency' :
				$data = $this->check_dependency();
				break;
			case 'template_content' :
				$origin = isset( $_POST['source'] ) ? sanitize_text_field( $_POST['source'] ) : 'remote';
				$data   = $this->insert_template( $origin );
				break;
			case 'save_template' :
				$args = $this->ready_args( $_POST );
				$data = $this->save_template( $args );
				break;
			case 'push_to_cloud' :
				$id        = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : null;
				$file_type = isset( $_POST['file_type'] ) ? sanitize_text_field( $_POST['file_type'] ) : 'elementor';
				$data      = $this->push_to_cloud( $id, $file_type );
				break;
			case 'remove_from_cloud' :
				$id   = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : null;
				$data = $this->remove_from_cloud( $id );
				break;
			case 'delete_template' :
				$data = $this->delete_template();
				break;
			case 'clouds_sync' :
				$data = $this->clouds_sync();
				break;
			case 'template_export' :
				$data = $this->template_export();
				break;
			case 'get_item' :
				$data = $this->get_item();
				break;
			case 'get_tags':
				$data = $this->get_tags();
				break;
			case 'set_favourite' :
				$data = $this->set_favourite();
				break;
			case 'set_unfavourite' :
				$data = $this->set_favourite( true );
				break;
			case 'import_to_library' :
				$data = $this->import_to_library();
				break;
			case 'create_page' :
				$data = $this->create_page();
				break;
			case 'get_workspace' :
				$data = $this->get_workspace();
				break;
			case 'edit_workspace' :
				$data = $this->create_or_edit_workspace( true );
				break;
			case 'add_files_to_workspace' :
				$data = $this->add_files_to_workspace( true );
				break;
			case 'delete_workspace' :
				$data = $this->delete_workspace();
				break;
			case 'create_workspace' :
				$data = $this->create_or_edit_workspace();
				break;
			case 'workspace_details' :
				$data = $this->workspace_details();
				break;
			case 'copy_or_move' :
				$data = $this->copy_or_move();
				break;
			case 'cloud_usage_limit' :
				$data = $this->cloud_usage_limit();
				break;
			case 'create_user' :
				$data = $this->create_user();
				break;
			case 'login_user' :
				$data = $this->login_user();
				break;
			case 'logout' :
				$data = $this->logout();
				break;
		}
		// send success message to api.
		Helper::send_success( $data );
	}
	/**
	 * Collect IP from request.
	 */
	private static function get_ip() {
		$ip = '127.0.0.1'; // Local IP
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	/**
	 * This method will responbile for making ready arguments for Save Template
	 *
	 * @param array $posted_data
	 *
	 * @return void
	 */
	protected function ready_args( $posted_data = array () ) {
		if ( empty( $posted_data ) ) {
			return [];
		}

		$args              = [];
		$args['content']   = isset( $posted_data['content'] ) ? wp_unslash( $posted_data['content'] ) : [];
		$args['post_id']   = intval( $posted_data['post_id'] );
		$args['file_type'] = $posted_data['file_type'];
		$args['source']    = $posted_data['source'];
		$args['type']      = $posted_data['type'];
		if ( isset( $posted_data['workspaceActivity'] ) ) {
			$args['workspaceActivity'] = \json_decode( wp_unslash( $posted_data['workspaceActivity'] ), true );
		}
		if ( isset( $posted_data['thumbnail'] ) && ! empty( $posted_data['thumbnail'] ) ) {
			$args['thumbnail'] = $posted_data['thumbnail'];
		}
		$args['title'] = wp_strip_all_tags( $posted_data['title'] );

		return $args;
	}

	public function save_template( $args = array () ) {

		if ( empty( $args ) ) {
			// $error_message = $data->get_error_message();
			Helper::send_error( __( "Something Went Wrong", 'templately' ) );
		}
		if ( empty( $args['content'] ) ) {
			Helper::send_error( __( "There is nothing to save in your template.", 'templately' ) );
		}
		if ( ! isset( $args['post_id'] ) ) {
			Helper::send_error( __( "No ID found to save your template.", 'templately' ) );
		}

		if ( isset( $args['workspaceActivity'] ) ) {
			DB::update_user_specific_login_meta( '_templately_cloud_last_activity', $args['workspaceActivity'] );
		}

		$saved_template = ElementorPlugin::$instance->templates_manager->save_template( $args );
		$connected      = DB::get_user_specific_login_meta( '_templately_connected' );
		if ( $connected ) {
			if ( is_array( $saved_template ) && isset( $saved_template['template_id'] ) ) {
				$pushed_template = $this->push_to_cloud( $saved_template['template_id'], $args['file_type'], $args );
			}

			return $pushed_template;
		}

		return $saved_template;
	}
	public static function get_items_count(){
		$templately_item_counts = DB::get_transient( 'templately_item_counts' );
		if( $templately_item_counts !== false ) {
			return $templately_item_counts;
		}

		$defaults = [
			'items' => [
				'total' => '1153',
				'starter' => '781',
				'pro' => '372',
			],
			'blocks' => [
				'total' => '473',
				'starter' => '337',
				'pro' => '136',
			],
			'pages' => [
				'total' => '680',
				'starter' => '444',
				'pro' => '236',
			],
			'packs' => [
				'total' => '128',
				'starter' => '89',
				'pro' => '39',
			],
		];

		$data  = Query::get( '{ getCounts{ key, value } }' );
		if ( is_wp_error( $data ) ) {
			DB::set_transient('templately_item_counts', $defaults );
			return $defaults;
		}
		if( isset( $data['data']['getCounts'] ) ) {
			$new_array = [
				'items' => [],
				'blocks' => [],
				'pages' => [],
				'packs' => [],
			];
			array_walk( $data['data']['getCounts'], function( $item ) use ( &$new_array ) {
				$new_key = explode('-', $item['key']);
				if( count( $new_key ) === 2 ) {
					if( isset( $new_array[ $new_key[1] ] )) {
						$new_array[ $new_key[1] ] = array_merge( $new_array[ $new_key[1] ], [  $new_key[0] => $item['value'] ] );
						$temp_array = $new_array[ $new_key[1] ];
						unset( $temp_array['total'] );
						$new_array[ $new_key[1] ]['total'] = array_sum( $temp_array );
					}
				}
			});
			DB::set_transient('templately_item_counts', $new_array );
			return $new_array;
		}
	}
	/**
	 * Get all categories
	 * @return void
	 */
	public static function get_categories() {
		$categories = DB::get_transient( 'templately_categories' );
		if ( $categories !== false ) {
			return $categories;
		}
		$query = '{ groupedCategories { item_categories { id, name, parent }, page_categories{ id, name, parent }, pack_categories{ id, name, parent } } }';
		$data  = Query::get( $query );
		if ( is_wp_error( $data ) ) {
			Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
		}
		$parentChildListedCategories = $newCategories = $new_category_list = [];
		if ( ! empty( $data['data']['groupedCategories'] ) ) {
			foreach ( $data['data']['groupedCategories'] as $singleCatKey => $singleCategories ) {
				array_walk( $singleCategories, function ( $value, $key ) use ( &$parentChildListedCategories ) {
					if ( isset( $value['id'] ) && is_null( $value['parent'] ) ) {
						$parentChildListedCategories[ $value['id'] ] = $value;
					}
				} );
				array_walk( $singleCategories, function ( $value, $key ) use ( &$parentChildListedCategories ) {
					if ( isset( $value['id'] ) && ! is_null( $value['parent'] ) ) {
						if ( isset( $parentChildListedCategories[ $value['parent'] ] ) ) {
							$parentChildListedCategories[ $value['parent'] ]['child'][] = $value;
						} else {
							$parentChildListedCategories[ $value['id'] ] = $value;
						}
					}
				} );

				$newCategories[ $singleCatKey ] = $parentChildListedCategories;
				$parentChildListedCategories    = [];
			}

			foreach ( $newCategories as $k => $v ) {
				$new_category_list[ $k ] = [];
				foreach ( $v as $kk => $vv ) {
					if ( $kk === 'id' || $kk === 'parent' ) {
						$new_category_list[ $k ][] = intval( $vv );
					} else {
						$new_category_list[ $k ][] = $vv;
					}
				}
			}
		}

		DB::set_transient( 'templately_categories', $new_category_list );

		return $new_category_list;
	}

	public function get_dependencies() {
		$dependencies = DB::get_transient( 'templately_dependencies' );
		if ( $dependencies !== false ) {
			return $dependencies;
		}
		$query = '{ dependencies{ id, name, icon, is_pro, platform } }';
		$data  = Query::get( $query );
		if ( is_wp_error( $data ) ) {
			Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
		}
		if ( isset( $data['errors'], $data['errors'][0], $data['errors'][0]['message'] ) ) {
			Helper::send_error( $data['errors'][0]['message'] );
		}
		if ( isset( $data['data'], $data['data']['dependencies'] ) ) {
			DB::set_transient( 'templately_dependencies', $data['data']['dependencies'] );

			return $data['data']['dependencies'];
		}

		Helper::send_error( __( 'Something went wrong with fetching dependencies data.', 'templately' ) );
	}

	/**
	 * Get all items for every type
	 *
	 * @param string $type
	 *
	 * @return void
	 */
	private function get_items( $type = 'items' ) {
		$pagenum      = isset( $_POST['pagenum'] ) ? intval( $_POST['pagenum'] ) : 1;
		$platform     = isset( $_POST['platform'] ) ? strtolower( $_POST['platform'] ) : 'elementor';
		$per_page     = isset( $_POST['per_page'] ) ? intval( $_POST['per_page'] ) : 48;
		$package_type = isset( $_POST['plan_type'] ) ? trim( strtolower( $_POST['plan_type'] ) ) : false;
		$platform     = $platform === 'templately' ? 'elementor' : $platform;
		$category_id  = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'] ) : false;
		$dependencies = isset( $_POST['dependencies'] ) ? json_encode( trim( $_POST['dependencies'] ) ) : false;
		$tag_id       = isset( $_POST['tag_id'] ) ? json_encode( trim( $_POST['tag_id'] ) ) : false;

		switch ( $package_type ) {
			case "all":
				$plan_type = 1;
				break;
			case "starter":
				$plan_type = 2;
				break;
			case "pro":
				$plan_type = 3;
				break;
			default:
				$plan_type = 1;
				break;
		}

		$query = sprintf(
			'{ %s( %s page: %s, per_page: %s, platform: "%s"%s%s%s ) { total_page, current_page, data { id, name, rating, type, slug, favourite_count, %s thumbnail, price, author{ display_name, name, joined }, category{ id, name } } } }',
			$type,
			( $category_id ) ? 'category_id: ' . $category_id . ',' : '',
			$pagenum,
			$per_page,
			esc_attr( $platform ),
			( $plan_type === 1 || $plan_type === false ) ? '' : "plan_type: $plan_type",
			( $dependencies == false || $dependencies == '' ) ? '' : "dependencies: $dependencies",
			( $tag_id === false ) ? '' : "tag_id: $tag_id",
			( $type === 'packs' ) ? '' : 'dependencies{ id, name, slug, icon, is_pro, link, plugin_file, plugin_original_slug },'
		);

		$data = Query::get( $query );
		if ( is_wp_error( $data ) ) {
			Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
		}

		if ( isset( $data['errors'], $data['errors'][0], $data['errors'][0]['message'] ) ) {
			Helper::send_error( $data['errors'][0]['message'] );
		}

		if ( isset( $data['data'], $data['data'][ $type ] ) ) {
			return $data['data'][ $type ];
		}
	}

	/**
	 * Get Items or Packs for Search
	 *
	 * @param string $type
	 *
	 * @return void
	 */
	private function getItemsOrPacks() {
		$pagenum  = isset( $_POST['pagenum'] ) ? intval( $_POST['pagenum'] ) : 1;
		$platform = isset( $_POST['platform'] ) ? strtolower( $_POST['platform'] ) : 'elementor';
		$platform = $platform === 'templately' ? 'elementor' : $platform;
		$search   = isset( $_POST['search'] ) ? strtolower( $_POST['search'] ) : '';

		$category_id  = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'] ) : false;
		$dependencies = isset( $_POST['dependencies'] ) ? json_encode( trim( $_POST['dependencies'] ) ) : false;
		$tag_id       = isset( $_POST['tag_id'] ) ? json_encode( trim( $_POST['tag_id'] ) ) : false;
		$types       = isset( $_POST['query_type'] ) ? trim( $_POST['query_type'] ) : 'block';

		$query    = sprintf(
			'{ getItemsAndPacks( page: %s, search: "%s", per_page: 48, platform: "%s", query_type: "%s", %s%s%s ) { data { id, name, rating, type, slug, favourite_count, thumbnail, price, author{ display_name, name, joined }, category{ id, name } } } }',
			$pagenum,
			$search,
			esc_attr( $platform ),
			$types,
			$category_id !== false && $category_id !== 'all' ?  "category_id: $category_id," : '',
			$dependencies !== false ?  "dependencies: $dependencies," : '',
			! empty( $tag_id ) ?  "tag_id: $tag_id" : ''
		);

		$data = Query::get( $query );
		if ( is_wp_error( $data ) ) {
			Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
		}
		if ( isset( $data['data'], $data['data']['getItemsAndPacks'] ) ) {
			$this->data = [];
			if( isset( $data['data']['getItemsAndPacks']['data'] ) && ! empty( $data['data']['getItemsAndPacks']['data'] ) ) {
				array_walk( $data['data']['getItemsAndPacks']['data'], function( $item ) {
					$item['id'] = intval(\str_replace( " {$item['type']}", '', $item['id']));
					$this->data[] = $item;
				});
			}
			return $this->data;
		}
	}

	/**
	 * Get template content
	 *
	 * @param string $origin
	 * @param integer $id
	 *
	 * @return void
	 */
	public static function get_template_content( $args, $import = false ) {
		if ( isset( $args['item_id'] ) && ! empty( $args['item_id'] ) ) {
			$id = $args['item_id'];
		}
		if ( isset( $args['origin'] ) && ! empty( $args['origin'] ) ) {
			$origin = $args['origin'];
		} else {
			$origin = 'remote';
		}

		if ( isset( $args['file_type'] ) && ! empty( $args['file_type'] ) ) {
			$item_type = $args['file_type'];
		}

		if ( is_null( $id ) ) {
			Helper::send_error( __( 'Something went wrong.', 'templately' ) );
		}
		/**
		 * Item will come from remote server.
		 */
		if ( $origin === 'remote' || $origin === 'cloud' ) {
			$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
			if ( ! $api_key ) {
				Helper::send_error( __( 'Activate Your Account!', 'templately' ) );
			}
			$query = '{ itemContent( id: ' . $id . ', api_key: "' . $api_key . '" ){ status, message, data } }';
			if ( $origin === 'cloud' ) {
				$query = '{ myCloudInsert( file_id: ' . $id . ', api_key: "' . $api_key . '", file_type: "' . $item_type . '" ) }';
			}
			$data = Query::get( $query );
			if ( is_wp_error( $data ) ) {
				Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
			}
			if ( $origin === 'remote' ) {
				if ( isset( $data['data'], $data['data']['itemContent'], $data['data']['itemContent']['status'] ) ) {
					if ( $data['data']['itemContent']['status'] == 'error' ) {
						Helper::send_error( $data['data']['itemContent']['message'] );
					}
					if ( $data['data']['itemContent']['status'] == 'required-pro-acc' ) {
						Helper::send_error( array (
							'errorCode' => 'required_pro',
							'message'   => $data['data']['itemContent']['message'],
						) );
					}
				}

				if ( isset( $data['data'], $data['data']['itemContent'], $data['data']['itemContent']['data'] ) ) {
					$data = json_decode( $data['data']['itemContent']['data'], true );
					if ( isset( $args['is_editor'] ) && $args['is_editor'] == true ) {
						return $data;
					} else {
						// Helper::send_error( array(
						//     'errorCode' => 'required_elementor_pro',
						//     'message' => __( "Type: {$data['type']} needs Elementor Pro to import.", 'templately' ),
						// ) );
					}

					return $data;
				}
			}
			if ( $origin === 'cloud' ) {
				$data = json_decode( $data['data']['myCloudInsert'], true );

				return $data;
			}
			if ( $import ) {
				return null;
			}
			Helper::send_error( __( 'Something went wrong!', 'templately' ) );
		}
		/**
		 * Item will come from local WP Installation.
		 */
		if ( $origin === 'local' ) {
			$data = Query::getFromLibrary( $id );
			if ( isset( $data['content'] ) ) {
				return $data;
			}
		}
		Helper::send_error( __( 'Something went wrong!', 'templately' ) );
	}

	/**
	 * This Method is responsible for Inserting Template
	 *
	 * @param string $origin
	 *
	 * @return void
	 */
	public function insert_template( $origin = 'remote' ) {
		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : null;
		if ( is_null( $id ) ) {
			Helper::send_error( __( 'Templates ID Not Found.', 'templately' ) );
		}
		$is_editor    = isset( $_POST['is_editor'] ) ? $_POST['is_editor'] === "true" : null;
		$default_args = array (
			'editor_post_id' => false,
			'item_id'        => $id,
			'origin'         => $origin
		);
		if ( ! is_null( $is_editor ) ) {
			$default_args['is_editor'] = $is_editor;
		}
		if ( isset( $_POST['file_type'] ) && ! empty( $_POST['file_type'] ) ) {
			$default_args['file_type'] = sanitize_text_field( $_POST['file_type'] );
		}
		if ( isset( $default_args['file_type'] ) && $default_args['file_type'] === 'gutenberg' ) {
			$template = self::get_template_content( $default_args );
			if( is_string( $template )) {
				$template = \json_decode( \wp_unslash( $template ), true );
			}
		}
		if ( isset( $default_args['file_type'] ) && $default_args['file_type'] === 'elementor' ) {
			$importer = new Importer;
			$template = $importer->get_data( $default_args );
		}

		return isset( $template['content'] ) ? $template : Helper::send_error( __( 'There is no Template Content to be inserted.', 'templately' ) );
	}

	private function cloud_push( $name, $data, $item_type = 'elementor', $args = array () ) {
		if ( empty( $name ) ) {
			Helper::send_error( __( "Name can't be empty.", 'templately' ) );
		}
		if ( $item_type === 'elementor' ) {
			if ( empty( $data ) || ! is_array( $data ) ) {
				Helper::send_error( __( "Data has to be an array.", 'templately' ) );
			}
			if ( ! isset( $data['content'] ) || ( isset( $data['content'] ) && empty( $data['content'] ) ) ) {
				Helper::send_error( __( "There is no data to push.", 'templately' ) );
			}
		}

		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );

		if ( empty( $api_key ) ) {
			Helper::send_error( __( "API Key is not found, try to re-login.", 'templately' ) );
		}
		// if( $item_type === 'elementor' ) {
		// }
		$data = wp_slash( \json_encode(
			$data, JSON_UNESCAPED_LINE_TERMINATORS | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
		) );

		$response = Query::push( $name, $data, $api_key, $item_type, $args );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}
		if ( isset( $response['errors'] ) ) {
			Helper::send_error( $response['errors'][0]['message'] );
		}

		$cloud_item = json_decode( $response['data']['pushToMyCloud']['data'] );
		if ( isset( $cloud_item->myCloud_item ) ) {
			$cloud_map = DB::get_option( '_templately_cloud_map', [] );
			$id        = $args['id'];

			if ( ! isset( $cloud_map[ $id ] ) ) {
				$cloud_map[] = array (
					'template_id'   => $id,
					'cloud_item_id' => intval( $cloud_item->myCloud_item ),
				);
			}
			DB::update_option( '_templately_cloud_map', $cloud_map );
		}

		return $response['data']['pushToMyCloud'];
	}

	/**
	 * Push to Cloud
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	private function push_to_cloud( $id = null, $item_type = 'elementor', $args = [] ) {
		if ( isset( $_POST['workspace_id'] ) ) {
			$args['workspace_id'] = intval( $_POST['workspace_id'] );
		}

		if ( $item_type === 'elementor' ) {
			if ( $id === null ) {
				Helper::send_error( __( 'ID not found to push the item in cloud.', 'templately' ) );
			}
			$data = Query::getFromLibrary( $id );

			if ( ! empty( $data ) && isset( $data['content'] ) ) {
				$name       = \get_the_title( $id );
				$args['id'] = $id;

				return $this->cloud_push( $name, $data, $item_type, $args );
			}
		}

		if ( $item_type === 'gutenberg' ) {
			$name = isset( $_POST['title'] ) && ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
			$data = isset( $_POST['data'] ) && ! empty( $_POST['data'] ) ? $_POST['data'] : '';

			return $this->cloud_push( $name, $data, 'gutenberg', $args );
		}

		Helper::send_error( __( 'Something went wrong', 'templately' ) );
	}

	/**
	 * This method is responsible for Removing item from Cloud
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	private function remove_from_cloud( $id = null ) {
		if ( is_null( $id ) ) {
			Helper::send_error( __( 'ID not found to remove Template from Cloud.', 'templately' ) );
		}
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( ! $api_key ) {
			Helper::send_error( __( 'You have no rights to delete file from Cloud. You have to logged in first', 'templately' ) );
		}

		$from     = isset( $_POST['remove_from'] ) && ! empty( $_POST['remove_from'] ) ? trim( $_POST['remove_from'] ) : 'cloud';
		$response = Query::remove_cloud_item( $id, $api_key, $from );

		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}

		if ( $from === 'cloud' ) {
			$response = $response['data']['removeFromMyCloud'];
		} else {
			$response = $response['data']['deleteWorkspaceFile'];
		}

		if ( isset( $response['status'] ) && $response['status'] != 'success' ) {
			Helper::send_error( __( 'Something went wrong.', 'templately' ) );
		}

		if ( $from === 'cloud' ) {
			$cloud_map = DB::get_option( '_templately_cloud_map', [] );
			if ( ! empty( $cloud_map ) ) {
				$new_cloud_map = array_filter( $cloud_map, function ( $value ) use ( $id ) {
					return $value['cloud_item_id'] != $id;
				} );
				DB::update_option( '_templately_cloud_map', array_values( $new_cloud_map ) );
			}

			$users_data = DB::get_user_specific_login_meta( '_templately_connect_data', [] );
			if ( array_key_exists( 'clouds', $users_data ) && array_key_exists( 'files', $users_data['clouds'] ) ) {
				$new_users_data                = array_filter( $users_data['clouds']['files'], function ( $value ) use ( $id ) {
					return $value['id'] != $id;
				} );
				$users_data['clouds']['files'] = array_values( $new_users_data );
				DB::update_user_specific_login_meta( '_templately_connect_data', $users_data );
			}

			return $id;
		}

		return $response;
	}

	/**
	 * Template Export
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	public function template_export( $id = null ) {
		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : null;
		if ( $id === null ) {
			Helper::send_error( __( 'Something went wrong.', 'templately' ) );
		}

		return ElementorPlugin::$instance->templates_manager->export_template( array (
			'source'      => 'local',
			'template_id' => $id
		) );
	}

	/**
	 * Check Dependency for Items
	 * @return void
	 */
	protected function check_dependency() {
		$dependencies           = json_decode( wp_unslash( $_POST['dependency'] ) );
		$not_active_plugin_list = [];
		$all_plugins            = Helper::get_plugins();
		if ( ! \is_plugin_active( 'elementor/elementor.php' ) ) {
			$elementor_plugin              = new \stdClass();
			$elementor_plugin->name        = __( 'Elementor', 'templately' );
			$elementor_plugin->plugin_file = 'elementor/elementor.php';
			$elementor_plugin->plugin_original_slug = 'elementor';
			$elementor_plugin->slug        = 'elementor';
			$elementor_plugin->is_pro      = false;
			$not_active_plugin_list[]      = $elementor_plugin;
		}

		if ( ! empty( $dependencies ) && is_array( $dependencies ) ) {
			foreach ( $dependencies as $dependency ) {
				if ( is_null( $dependency->plugin_file ) ) {
					continue;
				}
				if ( ! \is_plugin_active( $dependency->plugin_file ) ) {
					if ( $dependency->is_pro ) {
						if ( isset( $all_plugins[ $dependency->plugin_file ] ) ) {
							unset( $dependency->is_pro );
							$dependency->message      = __( 'You have the plugin installed.', 'templately' );
							$not_active_plugin_list[] = $dependency;
						} else {
							$not_active_plugin_list[] = $dependency;
						}
					} else {
						$not_active_plugin_list[] = $dependency;
					}
				}
			}
		}
		Helper::send_success( array (
			'dependency' => $not_active_plugin_list
		) );
	}

	/**
	 * This Method is responsible for Get Item from Server.
	 * @return void
	 */
	protected function get_item() {
		$slug = isset( $_POST['slug'] ) ? trim( sanitize_text_field( $_POST['slug'] ) ) : false;
		if ( ! $slug ) {
			Helper::send_error( __( 'Something went wrong.', 'templately' ) );
		}
		$type = isset( $_POST['type'] ) ? trim( sanitize_text_field( $_POST['type'] ) ) : 'block';

		$query = '';
		if ( $type === 'block' ) {
			$query = '{ items( slug: "' . $slug . '" ) { data { slug, rating, type, downloads, dependencies{ id, icon, name, slug, is_pro, link, plugin_file, plugin_original_slug }, live_url, name, id, retina_ready, documentation_ready, features, favourite_count, thumbnail, price, pack{ name, slug }, author{ display_name, name, profile_photo, joined }, tags{ name, id }, category{ name, id } } } }';
		}
		if ( $type === 'pack' ) {
			$query = '{
                packs( slug: "' . $slug . '" ) {
                    data { name, id, slug, rating, downloads, favourite_count, thumbnail, price, author{ display_name, name, profile_photo, joined }, tags{ name, id }, category{ name, id },
                    items {
                        slug, type, live_url, name, downloads, rating, id, dependencies{ id, icon, name, slug, is_pro, link, plugin_file, plugin_original_slug }, retina_ready, documentation_ready, features, favourite_count, thumbnail, price, pack{ name, slug }, author{ display_name, name, profile_photo, joined }, tags{ name, id }, category{ name, id } } }
                }
            }';
		}

		if ( $type === 'page' ) {
			$query = '{ pages( slug: "' . $slug . '" ) { data { slug, type, rating, downloads, dependencies{ id, icon, name, slug, is_pro, link, plugin_file, plugin_original_slug }, live_url, name, id, retina_ready, documentation_ready, features, favourite_count, thumbnail, price,  pack{ name, slug }, author{ display_name, name, joined, profile_photo }, tags{ name, id }, category{ name, id } } } }';
		}

		$data = Query::get( $query );
		if ( \is_wp_error( $data ) ) {
			Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
		}
		if ( $type === 'block' ) {
			if ( isset( $data['data'], $data['data']['items'] ) ) {
				return $data['data']['items']['data'];
			}
		}
		if ( $type === 'page' ) {
			if ( isset( $data['data'], $data['data']['pages'] ) ) {
				return $data['data']['pages']['data'];
			}
		}
		if ( $type === 'pack' ) {
			if ( isset( $data['data'], $data['data']['packs'] ) ) {
				return $data['data']['packs']['data'];
			}
		}
		Helper::send_error( __( 'Something went wrong!', 'templately' ) );
	}

	/**
	 * This Method is responsible for Get Items tag from Server.
	 * @return void
	 */
	protected function get_tags() {
		$tags = DB::get_transient( 'templately_tags' );
		if ( $tags !== false ) {
			return $tags;
		}

		$query = '{ tags { id, name } }';
		$data  = Query::get( $query );

		if ( \is_wp_error( $data ) ) {
			Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
		}

		if ( isset( $data['data'], $data['data']['tags'] ) ) {
			DB::set_transient( 'templately_tags', $data['data']['tags'] );

			return $data['data']['tags'];
		}

		Helper::send_error( __( 'Something went wrong with fetching dependencies data.', 'templately' ) );
	}


	/**
	 * This Methods Helps to Import Template in Library
	 * @return void
	 */
	public function import_to_library() {
		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : false;
		if ( ! $id ) {
			Helper::send_error( __( 'Something went wrong!', 'templately' ) );
		}
		$title = isset( $_POST['title'] ) ? trim( sanitize_text_field( $_POST['title'] ) ) : '';

		$importer          = new Importer;
		$template          = $importer->get_data( array (
			'editor_post_id' => false,
			'item_id'        => $id
		) );
		/**
		 * Checking the template eligibility for import.
		 */
		$this->is_eligible_for_import( $template );

		$imported_template = $importer->import_templately( $template );
		if ( is_wp_error( $imported_template ) ) {
			Helper::send_error( 'Error Code: ' . $imported_template->get_error_code() . ', Message: ' . $imported_template->get_error_message() );
		}
		if ( ! is_wp_error( $imported_template ) && is_array( $imported_template ) ) {
			return array (
				'post_id'             => $imported_template['template_id'],
				'edit_link'           => get_edit_post_link( $imported_template['template_id'], 'internal' ),
				'elementor_edit_link' => ElementorPlugin::$instance->documents->get( $imported_template['template_id'] )->get_edit_url(),
				'visit'               => $imported_template['url']
			);
		}
		Helper::send_error( __( 'Something went wrong with Import!', 'templately' ) );
	}

	/**
	 * This Method is Responsible for Create A Page From a Template.
	 * also its used to Import Template
	 *
	 * @param boolean $is_import
	 *
	 * @return void
	 */
	public function create_page() {
		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : false;
		if ( ! $id ) {
			Helper::send_error( __( 'Something went wrong!', 'templately' ) );
		}
		$title    = isset( $_POST['title'] ) ? trim( sanitize_text_field( $_POST['title'] ) ) : '';
		$platform = isset( $_POST['platform'] ) ? trim( $_POST['platform'] ) : 'elementor';
		if ( $platform === 'elementor' ) {
			$importer      = new Importer;
			$template_data = $importer->get_data( array (
				'editor_post_id' => false,
				'item_id'        => $id
			) );
			if ( ! empty( $title ) ) {
				$template_data['page_title'] = $title;
			}
			/**
			 * Checking the template eligibility for import.
			 */
			$this->is_eligible_for_import( $template_data );
			$inserted_ID = $importer->create_page( $template_data );
		}

		if ( $platform === 'gutenberg' ) {
			$inserted_ID = self::get_template_content( array (
				'origin'  => 'remote',
				'item_id' => $id,
			) );

			if ( isset( $inserted_ID['content'] ) ) {
				$inserted_ID = wp_insert_post( array (
					'post_status'  => 'draft',
					'post_type'    => 'page',
					'post_title'   => $title,
					'post_content' => $inserted_ID['content'],
				) );
			}
		}

		if ( is_wp_error( $inserted_ID ) ) {
			Helper::send_error( 'Error Code: ' . $inserted_ID->get_error_code() . ', Message: ' . $inserted_ID->get_error_message() );
		}

		if ( $inserted_ID && ! is_wp_error( $inserted_ID ) ) {
			return array (
				'post_id'             => $inserted_ID,
				'edit_link'           => get_edit_post_link( $inserted_ID, 'internal' ),
				'elementor_edit_link' => $platform === 'elementor' ? ElementorPlugin::$instance->documents->get( $inserted_ID )->get_edit_url() : false,
				'visit'               => get_permalink( $inserted_ID )
			);
		}

		Helper::send_error( __( 'Something went wrong!', 'templately' ) );
	}

	/**
	 * This Method is responsible for Check User Exists or Not and Make them Logged in to Server
	 * to collect profiles data and the API Key.
	 *
	 * @param boolean $login
	 *
	 * @return void
	 */
	public function login_user() {
		$errors  = [];

		$global_signin = isset( $_POST['global_signin'] ) ? filter_var( $_POST['global_signin'], FILTER_VALIDATE_BOOLEAN) : false;
		if( $global_signin ) {
			Login::set_user_login_choice( get_current_user_id(), $global_signin );
		} else {
			Login::set_link_my_account();
		}

		$withApi = isset( $_POST['withApi'] ) ? trim( $_POST['withApi'] ) === 'true' : false;

		if ( $withApi ) {
			$api_key = sanitize_text_field( trim( $_POST['api_key'] ) );
			if ( empty( $api_key ) ) {
				$errors['api_key'] = __( 'API Key Field Cannot be Empty.', 'templately' );
			}
			$query = \sprintf(
				'mutation{ connectWithApiKey( api_key : "%s", site_url : "%s", ip: "%s" ){ status, message, user { id, first_name, last_name, name, profile_photo, is_verified, api_key, my_cloud { limit, usages, name, last_pushed, files{ data { id, name, thumbnail, medium_thumbnail, preview }, current_page, total_page }}, email, favourites { id, type }, joined, plan, plan_expire_at }}}',
				$api_key,
				\home_url( '/' ),
				self::get_ip()
			);
		} else {
			$email = sanitize_text_field( trim( $_POST['email'] ) );
			if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
				$errors['email'] = __( 'Make sure you have given a valid email address.', 'templately' );
			}
			$password = sanitize_text_field( trim( $_POST['password'] ) );
			if ( empty( $password ) ) {
				$errors['password'] = __( 'Password Field Cannot be Empty.', 'templately' );
			}
			$query = \sprintf(
				'mutation{ connect( email : "%s", password : "%s", site_url : "%s", ip: "%s" ){ status, message, user { id, first_name, last_name, name, plan, plan_expire_at, profile_photo, is_verified, api_key, email, favourites { id, type }, joined, my_cloud { limit, usages, name, last_pushed, files{ data { id, name, thumbnail, medium_thumbnail, preview }, current_page, total_page }}}}}',
				$email,
				$password,
				\home_url( '/' ),
				self::get_ip()
			);
		}


		$api_response = Query::get( $query );

		if ( is_wp_error( $api_response ) ) {
			Helper::send_error( $api_response->get_error_code() . ': ' . $api_response->get_error_message() );
		}
		if ( isset( $api_response['errors'] ) ) {
			Helper::send_error( __( 'Something went wrong. Maybe Invalid Credentials.', 'templately' ) );
		}
		if ( $withApi ) {
			$api_response = $api_response['data']['connectWithApiKey'];
			if ( isset( $api_response['status'] ) && $api_response['status'] !== 'success' ) {
				Helper::send_error( $api_response['message'] );
			}

			return $this->user_data( $api_response );
		} else {
			$api_response = $api_response['data']['connect'];
			if ( isset( $api_response['status'] ) && $api_response['status'] !== 'success' ) {
				Helper::send_error( $api_response['message'] );
			}

			return $this->user_data( $api_response );
		}
		Helper::send_error( __( 'Something went wrong', 'templately' ) );
	}

	public function create_user() {
		$errors     = [];
		$first_name = sanitize_text_field( trim( $_POST['first_name'] ) );
		$last_name  = sanitize_text_field( trim( $_POST['last_name'] ) );

		if( Login::already_signedin_globally() ) {
			Login::set_link_my_account();
		} else {
			Login::set_user_login_choice( get_current_user_id(), true );
		}

		if ( empty( $first_name ) ) {
			$errors['first_name'] = __( 'First Name Can\'t be Empty.', 'templately' );
		}
		if ( empty( $last_name ) ) {
			$errors['last_name'] = __( 'Last Name Can\'t be Empty.', 'templately' );
		}
		$email = sanitize_text_field( trim( $_POST['email'] ) );
		if ( empty( $email ) ) {
			$errors['email'] = __( 'Email Field Can\'t be Empty.', 'templately' );
		}
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$errors['email'] = __( 'Make sure you have given a valid email address.', 'templately' );
		}
		$password = sanitize_text_field( trim( $_POST['password'] ) );
		if ( empty( $password ) ) {
			$errors['password'] = __( 'Password Field Can\'t be Empty.', 'templately' );
		}
		if ( ! empty( $errors ) ) {
			Helper::send_error( $errors );
		}

		$query        = \sprintf(
			'mutation{ createUser( first_name : "%s", last_name : "%s", email : "%s", password : "%s", site_url : "%s", ip: "%s" ){ status, message, user { id, name, first_name, last_name, plan, plan_expire_at, profile_photo, api_key, email, joined, is_verified}}}',
			$first_name,
			$last_name,
			$email,
			$password,
			\home_url( '/' ),
			self::get_ip()
		);
		$api_response = Query::get( $query );
		if ( is_wp_error( $api_response ) ) {
			Helper::send_error( $api_response->get_error_code() . ': ' . $api_response->get_error_message() );
		}

		if ( isset( $api_response['errors'] ) ) {
			if ( isset( $api_response['errors'][0]['extensions'] ) && isset( $api_response['errors'][0]['extensions']['validation'] ) ) {
				Helper::send_error( $api_response['errors'][0]['extensions']['validation'] );
			}
			Helper::send_error( 'Something went wrong.' );
		}

		$api_response = $api_response['data']['createUser'];
		if ( isset( $api_response['status'] ) && $api_response['status'] !== 'success' ) {
			Helper::send_error( $api_response['message'] );
		}

		return $this->user_data( $api_response, true );
	}

	/**
	 * Helper Function for checkNVerify methods
	 *
	 * @param array $api_response
	 *
	 * @return void
	 */
	protected function user_data( $api_response, $create_user = false, $raw = false ) {
		if ( isset( $api_response ) && ! is_null( $api_response ) ) {
			$user_data = $api_response;
			$userState = [];
			if ( isset( $user_data['user'], $user_data['user']['favourites'] ) ) {
				$favourites = [
					'item' => [],
					'pack' => []
				];
				array_walk( $user_data['user']['favourites'], function ( $value ) use ( &$favourites ) {
					if ( ! is_null( $value ) ) {
						if ( ! in_array( $value['id'], isset( $favourites[ $value['type'] ] ) ? $favourites[ $value['type'] ] : [] ) ) {
							$favourites[ $value['type'] ][] = $value['id'];
						}
					}
				} );
				$userState['favourites'] = $favourites;
			}

			if ( isset( $user_data['user'], $user_data['user']['id'] ) ) {
				$userState['id'] = intval( $user_data['user']['id'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['first_name'] ) ) {
				$userState['first_name'] = sanitize_text_field( $user_data['user']['first_name'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['profile_photo'] ) ) {
				$userState['profile_photo'] = sanitize_text_field( $user_data['user']['profile_photo'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['last_name'] ) ) {
				$userState['last_name'] = sanitize_text_field( $user_data['user']['last_name'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['name'] ) ) {
				$userState['name'] = sanitize_text_field( $user_data['user']['name'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['email'] ) ) {
				$userState['email'] = sanitize_text_field( $user_data['user']['email'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['plan'] ) ) {
				$userState['plan'] = sanitize_text_field( $user_data['user']['plan'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['plan_expire_at'] ) ) {
				$userState['plan_expire_at'] = sanitize_text_field( $user_data['user']['plan_expire_at'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['joined'] ) ) {
				$userState['joined'] = sanitize_text_field( $user_data['user']['joined'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['is_verified'] ) ) {
				$userState['is_verified'] = sanitize_text_field( $user_data['user']['is_verified'] );
			}
			if ( isset( $user_data['status'] ) ) {
				$userState['status'] = sanitize_text_field( $user_data['status'] );
			}
			$api_key = '';
			if ( isset( $user_data['user'], $user_data['user']['api_key'] ) ) {
				$api_key = sanitize_text_field( $user_data['user']['api_key'] );
			}
			if ( isset( $user_data['user'], $user_data['user']['my_cloud'] ) ) {
				$user_clouds['limit']  = $user_data['user']['my_cloud']['limit'];
				$user_clouds['usages'] = $user_data['user']['my_cloud']['usages'];
				$user_clouds['name']   = $user_data['user']['my_cloud']['name'];
				$user_cloud_files      = [];

				if ( isset( $user_data['user']['my_cloud']['last_pushed'] ) ) {
					DB::update_user_specific_login_meta( '_templately_cloud_last_activity', $user_data['user']['my_cloud']['last_pushed'] );
				}

				array_walk( $user_data['user']['my_cloud']['files'], function ( $value ) use ( &$user_cloud_files ) {
					//TODO: mycloud
				} );
				$user_clouds['files'] = $user_cloud_files;
				$userState['clouds']  = $user_clouds;
			}
			if ( empty( $api_key ) ) {
				Helper::send_error( __( 'API Key is not found', 'templately' ) );
			}

			if ( $create_user ) {
				$userState['is_verified'] = false;
				$userState['is_global_login'] = Login::get_global_signed_in_by_user( get_current_user_id() );
			}

			DB::update_user_specific_login_meta( '_templately_api_key', $api_key );
			DB::update_user_specific_login_meta( '_templately_connected', true );
			DB::update_user_specific_login_meta( '_templately_connect_data', $userState );

			if ( $raw ) {
				return $userState;
			}
			Helper::send_success( array (
				'message' => __( 'Successfully Connected', 'templately' ),
				'admin'   => $userState
			) );
		}
	}

	/**
	 * This method delete templates from library.
	 * @return void
	 */
	protected function delete_template() {
		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : false;
		if ( ! $id ) {
			Helper::send_error( __( 'Template ID is not found to delete', 'templately' ) );
		}
		// $type = isset( $_POST['type'] ) ? trim( $_POST['type'] ) : 'template';
		\wp_delete_post( $id );
		$cloud_map     = DB::get_option( '_templately_cloud_map', [] );
		$new_cloud_map = [];
		array_walk( $cloud_map, function ( $cloud ) use ( &$cloud_map, $id, &$new_cloud_map ) {
			if ( $cloud['template_id'] !== $id ) {
				$new_cloud_map[] = $cloud;
			}
		} );
		DB::update_option( '_templately_cloud_map', $new_cloud_map );
		Helper::send_success( __( 'Successfully Deleted.', 'templately' ) );
	}

	/**
	 * This method helps to sync user profile data to current one.
	 * @return void
	 */
	protected function clouds_sync() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );

		if ( ! empty( $api_key ) ) {
			$file_type = isset( $_POST['fileType'] ) ? trim( $_POST['fileType'] ) : 'elementor';
			$search    = isset( $_POST['search'] ) ? trim( $_POST['search'] ) : '';
			$per_page  = isset( $_POST['per_page'] ) ? intval( $_POST['per_page'] ) : 12;
			$pagenum   = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;

			$query = \sprintf(
				'{ myCloud( api_key: "%s", cloud_files_page: %s, cloud_files_per_page: %s, file_type: "%s"%s ) { limit, usages, name, last_pushed, files {  data{ id, name, thumbnail, medium_thumbnail, preview, file_type, created_at }, current_page, total_page } } }',
				$api_key,
				$pagenum,
				$per_page,
				$file_type,
				! empty( $search ) ? ', files_search: "' . $search . '"' : ''
			);
			$data  = Query::get( $query );
			if ( is_wp_error( $data ) ) {
				Helper::send_error( $data->get_error_code() . ': ' . $data->get_error_message() );
			}

			if ( isset( $data['data'], $data['data']['myCloud'] ) ) {
				$user_data           = DB::get_user_specific_login_meta( '_templately_connect_data', [] );
				$user_data['clouds'] = $data['data']['myCloud'];
				DB::update_user_specific_login_meta( '_templately_connect_data', $user_data );
				if ( isset( $data['data']['myCloud']['last_pushed'] ) ) {
					DB::update_user_specific_login_meta( '_templately_cloud_last_activity', $data['data']['myCloud']['last_pushed'] );
				}

				return $data['data']['myCloud']['files'];
			} else {
				// TODO: in future will be handled.
				Helper::send_success( __( 'You have no items in your cloud.', 'templately' ) );
			}
		}
		Helper::send_error( __( 'You have to logged in first via your admin dashboard.', 'templately' ) );
	}

	/**
	 * This Method is responsible for Disconnect user.
	 * @return void
	 */
	protected function logout() {
		DB::delete_option( '_templately_trigger' );
		DB::delete_transient( 'templately_dependencies' );
		DB::delete_option( '_templately_connect_email' );

		DB::delete_user_specific_login_meta( '_templately_connected' );
		DB::delete_user_specific_login_meta( '_templately_api_key' );
		DB::delete_user_specific_login_meta( '_templately_connect_data' );
		DB::delete_user_specific_login_meta( '_templately_cloud_last_activity' );

		if( Login::user_can_logout() ) {
			DB::delete_option( '_templately_user_login_choice' );
		}else {
			Login::delete_link_my_account();
		}

		DB::delete_transient( 'templately_categories' );
		DB::delete_option( '_templately_cloud_map' );
		Helper::send_success( __( 'Logged Out', 'templately' ) );
	}

	/**
	 * Verification Done AJAX Call.
	 */
	protected function verification_done() {
		$data = DB::get_user_specific_login_meta( '_templately_connect_data', [] );
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		$query = \sprintf('{ isVerifiedUser( api_key: "%s" ) }', $api_key);
		$response = Query::get( $query );

		if( is_wp_error($response) ){
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}

		$data['is_verified'] = false;
		if( isset($response['data'], $response['data']['isVerifiedUser']) && boolval($response['data']['isVerifiedUser']) ) {
			$data['is_verified'] = true;
		}

		return DB::update_user_specific_login_meta( '_templately_connect_data', $data );
	}

	protected function install_requirements() {
		$requirements = isset( $_POST['requirements'] ) ? \json_decode( \wp_unslash( $_POST['requirements'] ), true ) : false;

		return RequirementInstaller::get_instance()->install_plugin( $requirements );
		die;
	}

	/**
	 * Platform Exists or Not
	 *
	 * @return void
	 */
	protected function platform_exists() {
		$platform = isset( $_POST['platform'] ) ? trim( sanitize_text_field( $_POST['platform'] ) ) : 'elementor';
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

	protected function set_favourite( $unfav = false ) {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( ! $api_key ) {
			Helper::send_error( __( 'Something went wrong. Please, try logged in again.', 'templately' ) );
		}
		$id   = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : false;
		$type = isset( $_POST['type'] ) ? trim( sanitize_text_field( $_POST['type'] ) ) : false;
		if ( $id === false || $type === false ) {
			Helper::send_error( __( 'Item ID or Item Type is not found.', 'templately' ) );
		}

		$type  = $type === 'block' || $type === 'page' ? 'item' : 'pack';
		$query = 'mutation { favourite( type_id: ' . $id . ', api_key: "' . $api_key . '", type: "' . $type . '" ){ status, message, data } }';
		if ( $unfav ) {
			$query = 'mutation { unFavourite( type_id: ' . $id . ', api_key: "' . $api_key . '", type: "' . $type . '" ) }';
		}
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}
		if ( isset( $response['data']['favourite'] ) ) {
			$response = $response['data']['favourite'];
			if ( isset( $response['status'] ) && $response['status'] != 'success' ) {
				Helper::send_error( $response['message'] );
			}

			$user_data = DB::get_user_specific_login_meta( '_templately_connect_data', [] );
			if ( ! empty( $user_data ) && array_key_exists( 'favourites', $user_data ) ) {
				if ( isset( $user_data['favourites'][ $type ] ) ) {
					if ( ! in_array( $id, $user_data['favourites'][ $type ] ) ) {
						$user_data['favourites'][ $type ][] = $id;
					}
				} else {
					$user_data['favourites'][ $type ]   = [];
					$user_data['favourites'][ $type ][] = $id;
				}
			} else {
				$user_data['favourites']            = [];
				$user_data['favourites'][ $type ]   = [];
				$user_data['favourites'][ $type ][] = $id;
			}

			DB::update_user_specific_login_meta( '_templately_connect_data', $user_data );

			return $user_data;
		}
		if ( $unfav && isset( $response['data']['unFavourite'] ) && $response['data']['unFavourite'] ) {
			$user_data = DB::get_user_specific_login_meta( '_templately_connect_data', [] );
			if ( $unfav && isset( $user_data['favourites'][ $type ] ) && is_array( $user_data['favourites'][ $type ] ) ) {
				$favourites                       = array_filter( $user_data['favourites'][ $type ], function ( $value ) use ( $id ) {
					return $value != $id;
				} );
				$user_data['favourites'][ $type ] = array_values( $favourites );
				DB::update_user_specific_login_meta( '_templately_connect_data', $user_data );
			}

			return $user_data;
		}
		Helper::send_error( __( 'Something went wrong.', 'templately' ) );
	}

	protected function get_workspace() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}

		$shared    = isset( $_POST['shared'] ) ? boolval( $_POST['shared'] ) : false;
		$pagenum   = isset( $_POST['pagenum'] ) ? intval( $_POST['pagenum'] ) : 1;
		$file_type = isset( $_POST['file_type'] ) ? trim( $_POST['file_type'] ) : 'elementor';
		$per_page  = isset( $_POST['per_page'] ) ? intval( $_POST['per_page'] ) : 11;

		$query    = sprintf(
			'{ %s ( page: %s, per_page: %s, api_key: "%s", file_type: "%s" ){ data{ id, name, slug %s }, total_page, current_page } }',
			$shared ? 'sharedWorkspaces' : 'workspaces',
			$pagenum,
			$per_page,
			$api_key,
			$file_type,
			$pagenum !== - 1 ? ', sharedWith{ name, email, profile_photo, id }, owner{ id, name, joined, display_name }, pending_invitations' : ''
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}

		if ( isset( $response['data'], $response['data']['workspaces'] ) && ! $shared ) {
			return $response['data']['workspaces'];
		}

		if ( isset( $response['data'], $response['data']['sharedWorkspaces'] ) && $shared ) {
			return $response['data']['sharedWorkspaces'];
		}

		Helper::send_error( __( 'Something went wrong loading WorkSpace. Try again or contact with Templately Support.', 'templately' ) );
	}

	protected function create_workspace() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}
		$title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : false;
		if ( $title === false ) {
			Helper::send_error( __( 'You have to give title at least.', 'templately' ) );
		}
		$share_with = isset( $_POST['share_with'] ) ? trim( $_POST['share_with'] ) : '';

		$query    = sprintf(
			'mutation { createWorkspace ( api_key: "%s", name: "%s", share_with: "%s" ){ status, message, workspace{ id, name, slug, sharedWith{ id, name, profile_photo }, owner{ id, name, profile_photo }, pending_invitations } } }',
			$api_key,
			$title,
			$share_with
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}

		if ( isset( $response['data'], $response['data']['createWorkspace'] ) ) {
			return $response['data']['createWorkspace'];
		}
		Helper::send_error( __( 'Something went wrong regarding create WorkSpace. Try again or contact with Templately Support.', 'templately' ) );
	}

	protected function create_or_edit_workspace( $edit = false ) {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}
		$title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : false;
		if ( $title === false ) {
			Helper::send_error( __( 'You have to give title at least.', 'templately' ) );
		}
		$share_with = isset( $_POST['share_with'] ) ? trim( $_POST['share_with'] ) : '';

		$query  = sprintf(
			'mutation { createWorkspace ( api_key: "%s", name: "%s", share_with: "%s" ){ status, message, workspace{ id, name, slug, sharedWith{ id, name, profile_photo }, owner{ id, name, profile_photo }, pending_invitations } } }',
			$api_key,
			$title,
			\wp_slash( \json_encode( \explode( ',', $share_with ) ) )
		);
		$action = 'create';
		if ( $edit ) {
			$action   = 'edit';
			$id       = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : false;
			$platform = ( isset( $_POST['platform'] ) && ! empty( $_POST['platform'] ) ) ? trim( $_POST['platform'] ) : 'elementor';
			if ( $id === false ) {
				Helper::send_error( __( 'Workspace not found.', 'templately' ) );
			}
			$remove = ( isset( $_POST['remove'] ) && ! empty( $_POST['remove'] ) ) ? trim( $_POST['remove'] ) : '';
			$query  = sprintf(
				'mutation { editWorkspace ( api_key: "%s", name: "%s", file_type: "%s", id: %s %s %s ){ status, workspace{ id, name, slug, sharedWith{ id, name, profile_photo }, files{ data{ id, my_cloud_id, name, file_type, owner{ id, name, profile_photo }, created_at, last_modified }, current_page, total_page }, owner{ id, name, profile_photo }, pending_invitations } } }',
				$api_key,
				$title,
				$platform,
				$id,
				! empty( $share_with ) ? 'share_with: "' . \wp_slash( \json_encode( \explode( ',', $share_with ) ) ) . '"' : '',
				! empty( $remove ) ? ', remove: "' . $remove . '"' : ''
			);
		}
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}

		if ( $edit === false && isset( $response['data'], $response['data']['createWorkspace'] ) ) {
			return $response['data']['createWorkspace'];
		}
		if ( $edit && isset( $response['data'], $response['data']['editWorkspace'] ) ) {
			return $response['data']['editWorkspace'];
		}
		Helper::send_error( __( "Something went wrong regarding $action WorkSpace. Try again or contact with Templately Support.", 'templately' ) );
	}

	protected function delete_workspace() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}
		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : false;
		if ( $id === false ) {
			Helper::send_error( __( 'Workspace not found.', 'templately' ) );
		}
		$withFiles = isset( $_POST['withFiles'] ) ? boolval( intval( $_POST['withFiles'] ) ) : false;

		$query    = sprintf(
			'mutation { deleteWorkspace ( id: %s, api_key: "%s" %s ){ status } }',
			$id,
			$api_key,
			$withFiles ? ', delete_files: true' : ''
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}
		if ( isset( $response['data'], $response['data']['deleteWorkspace'], $response['data']['deleteWorkspace']['status'] ) ) {
			return $response['data']['deleteWorkspace']['status'];
		}
		Helper::send_error( __( 'Something went wrong regarding delete WorkSpace. Try again or contact with Templately Support.', 'templately' ) );
	}

	protected function copy_or_move() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}
		$action        = isset( $_POST['trigger_action'] ) ? trim( $_POST['trigger_action'] ) : 'copy';
		$cloud_file_id = isset( $_POST['cloud_file_id'] ) ? intval( $_POST['cloud_file_id'] ) : false;
		if ( $cloud_file_id === false ) {
			Helper::send_error( __( 'No Cloud Item is selected to' . $action . '.', 'templately' ) );
		}
		$workspace_id = isset( $_POST['workspace_id'] ) ? intval( $_POST['workspace_id'] ) : false;
		if ( $workspace_id === false ) {
			Helper::send_error( __( 'No WorkSpace is selected, where the item will ' . $action . ' to.', 'templately' ) );
		}
		$query    = sprintf(
			'mutation { copyOrMoveToWorkspace ( api_key: "%s", my_cloud_file_id: %s, workspace_id: %s, action: "%s" ){ status, message } }',
			$api_key,
			$cloud_file_id,
			$workspace_id,
			$action
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}

		if ( isset( $response['data'], $response['data']['copyOrMoveToWorkspace'], $response['data']['copyOrMoveToWorkspace']['status'] ) ) {
			return $response['data']['copyOrMoveToWorkspace']['status'];
		}
		Helper::send_error( __( "Something went wrong regarding $action to WorkSpace. Try again or contact with Templately Support.", 'templately' ) );
	}

	protected function workspace_details() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}
		$slug = isset( $_POST['slug'] ) ? trim( $_POST['slug'] ) : false;
		if ( $slug === false ) {
			Helper::send_error( __( 'Slug can\'t be empty.', 'templately' ) );
		}

		$file_type      = isset( $_POST['file_type'] ) ? trim( $_POST['file_type'] ) : 'elementor';
		$search         = isset( $_POST['search'] ) ? trim( $_POST['search'] ) : '';
		$files_per_page = isset( $_POST['per_page'] ) ? intval( $_POST['per_page'] ) : 10;
		$files_page     = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;

		$query    = sprintf(
			'{ workspaceDetails ( api_key: "%s", slug: "%s", files_page: %s, files_per_page: %s, file_type: "%s" %s ){ id, name, slug, files{ data { id, name, my_cloud_id, file_type, owner{ id, name, profile_photo }, created_at, last_modified }, current_page, total_page }, sharedWith{ name, id, profile_photo }, owner{ id, name, profile_photo }, pending_invitations } }',
			$api_key,
			$slug,
			$files_page,
			$files_per_page,
			$file_type,
			! empty( $search ) ? ', files_search: "' . $search . '"' : ''
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}
		if ( isset( $response['data'], $response['data']['workspaceDetails'] ) ) {
			return $response['data']['workspaceDetails'];
		} else {
			if ( isset( $response['data'] ) && ! isset( $response['data']['workspaceDetails'] ) ) {
				return null;
			}
		}
		Helper::send_error( __( "Something went wrong regarding loading your WorkSpace. Try again or contact with Templately Support.", 'templately' ) );
	}

	protected function cloud_usage_limit() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}

		$query    = sprintf(
			'{ myCloudUsage( api_key: "%s" ){ data, status } }',
			$api_key
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}
		if ( isset( $response['data'], $response['data']['myCloudUsage'] ) ) {
			return $response['data']['myCloudUsage'];
		}
		Helper::send_error( __( "Something went wrong regarding collecting your usage limit. Try again or contact with Templately Support.", 'templately' ) );
	}

	protected function add_files_to_workspace() {
		$api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
		if ( empty( $api_key ) ) {
			Helper::send_error( __( 'You need to re-logged in.', 'templately' ) );
		}

		$workspace_id = isset( $_POST['workspace_id'] ) ? intval( $_POST['workspace_id'] ) : false;
		if ( $workspace_id === false ) {
			Helper::send_error( __( 'Workspace Not Found.', 'templately' ) );
		}
		$files = isset( $_POST['files'] ) ? trim( $_POST['files'] ) : false;
		if ( $files === false ) {
			Helper::send_error( __( 'Workspace Not Found.', 'templately' ) );
		}
		$query    = sprintf(
			'mutation { addFileToWorkspace( api_key: "%s", workspace_id: %d, files: %s ){ data, status } }',
			$api_key,
			$workspace_id,
			\json_encode( $files )
		);
		$response = Query::get( $query );
		if ( is_wp_error( $response ) ) {
			Helper::send_error( $response->get_error_code() . ': ' . $response->get_error_message() );
		}
		if ( isset( $response['data'], $response['data']['addFileToWorkspace'] ) ) {
			return $response['data']['addFileToWorkspace'];
		}
		Helper::send_error( __( "Something went wrong regarding adding files to your Workspace. Try again or contact with Templately Support.", 'templately' ) );
	}

	public function get_templates() {
		return Elementor::templates( false, [
			'page' => ( isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1 )
		] );
	}
}
