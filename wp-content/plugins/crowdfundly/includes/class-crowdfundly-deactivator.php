<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wpdeveloper.net/
 * @since      1.0.0
 *
 * @package    Crowdfundly
 * @subpackage Crowdfundly/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Crowdfundly
 * @subpackage Crowdfundly/includes
 * @author     WPDeveloper 
 */
class Crowdfundly_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option('crowdfundly_settings');
		delete_option('crowdfundly_user');
	}

}
