<?php 
namespace Templately;

class RequirementInstaller {
    /**
     * Plugin Instance
     * @var \Templately\RequirementInstaller
     */
    private static $_instance = null;
    /**
     * Get a single instance of Plugin
     * @return Plugin
     */
    public static function get_instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * Some process take long time to execute 
     * for that need to raise the limit.
     */
    public static function raise_limits() {
		wp_raise_memory_limit( 'admin' );
		if ( wp_is_ini_value_changeable( 'max_execution_time' ) ) {
			ini_set( 'max_execution_time', 0 );
		}
		@ set_time_limit( 0 );
	}
    
    public function install_plugin( $plugin_details ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$all_plugins = get_plugins();
		$is_installed = isset( $all_plugins[ $plugin_details['plugin_file'] ] );

		if( isset( $plugin_details['is_pro'] ) && $plugin_details['is_pro'] == true ) {
			if( ! $is_installed ) {
				$status = [
					'success' => false,
				];
				$status['errorCode'] = 'pro_plugin';
				$status['message']   = 'Pro Plugin';
				Helper::send_error( $status );
			}
		}

		if ( $is_installed ) {
			$activate_status = $this->activate_plugin( $plugin_details['plugin_file'] );
		} else {
			$status = [
				'success' => false,
			];
			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => sanitize_key( wp_unslash( $plugin_details['plugin_original_slug'] ) ),
					'fields' => array(
						'sections' => false,
					),
				)
			);

			if ( is_wp_error( $api ) ) {
				$status['message'] = $api->get_error_message();
				return $status;
			}

			$status['plugin_name'] = $api->name;

			$skin     = new \WP_Ajax_Upgrader_Skin();
			$upgrader = new \Plugin_Upgrader( $skin );
			$result   = $upgrader->install( $api->download_link );

			if ( is_wp_error( $result ) ) {
				$status['errorCode'] = $result->get_error_code();
				$status['message']   = $result->get_error_message();

				return $status;
			} elseif ( is_wp_error( $skin->result ) ) {
				$status['errorCode'] = $skin->result->get_error_code();
				$status['message']   = $skin->result->get_error_message();

				return $status;
			} elseif ( $skin->get_errors()->has_errors() ) {
				$status['message'] = $skin->get_error_messages();

				return $status;
			} elseif ( is_null( $result ) ) {
				global $wp_filesystem;

				$status['errorCode'] = 'unable_to_connect_to_filesystem';
				$status['message']   = __( 'Unable to connect to the filesystem. Please confirm your credentials.' );

				if ( $wp_filesystem instanceof \WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
					$status['message'] = esc_html( $wp_filesystem->errors->get_error_message() );
				}

				return $status;
			}

			$install_status = install_plugin_install_status( $api );
			$activate_status = $this->activate_plugin( $install_status['file'] );
		}

		if ( $activate_status && ! is_wp_error( $activate_status ) ) {
			$status['success'] = true;
		}
		$status['slug'] = $plugin_details['plugin_original_slug'];

		return $status;
	}

	private function activate_plugin( $file ) {
		if ( current_user_can( 'activate_plugin', $file ) && is_plugin_inactive( $file ) ) {
			$result = activate_plugin( $file, false, false );
			if ( is_wp_error( $result ) ) {
				return $result;
			} else {
				return true;
			}
		}

		return false;
	}

}