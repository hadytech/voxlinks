<?php

namespace Templately;

class DB {
	/**
	 * Get an option
	 *
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return void
	 */
	public static function get_option( $key, $default = false ) {
		$trimmed_key = trim( $key );

		return empty( $trimmed_key ) ? false : \get_option( $trimmed_key, $default );
	}

	/**
	 * Update an option
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param string|boolean $autoload
	 *
	 * @return void
	 */
	public static function update_option( $key, $value, $autoload = null ) {
		$trimmed_key = trim( $key );

		return empty( $trimmed_key ) ? false : \update_option( $trimmed_key, $value, $autoload );
	}
	public static function set_transient( $key, $value, $expiration = DAY_IN_SECONDS ){
		return set_transient( $key, $value, $expiration );
	}
	public static function get_transient( $key ){
		return get_transient( $key );
	}
	public static function delete_transient( $key ){
		return \delete_transient( $key );
	}
	/**
	 * Update|Set user meta.
	 *
	 * @param int $user_id
	 * @param string $meta_key
	 * @param mixed $meta_value
	 */
	public static function update_user_meta( $user_id, $meta_key, $meta_value ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$user_id  = absint( $user_id );
		$meta_key = trim( $meta_key );

		if ( ! $user_id && empty( $meta_key ) ) {
			return false;
		}

		return \update_user_meta( $user_id, $meta_key, $meta_value );
	}

	/**
	 * Get an option
	 *
	 * @param int $user_id
	 * @param string $meta_key
	 * @param bool $single
	 */
	public static function get_user_meta( $user_id, $meta_key, $default = false, $single = true ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$user_id  = absint( $user_id );
		$meta_key = trim( $meta_key );

		if ( ! $user_id && empty( $meta_key ) ) {
			return false;
		}

		$res = \get_user_meta( $user_id, $meta_key, $single );

		return ( ! $res ) ? $default : $res;

	}

	/**
	 * Delete a user meta.
	 *
	 * @param int $user_id
	 * @param string $meta_key
	 */
	public static function delete_user_meta( $user_id, $meta_key ) {

		if ( ! $user_id ) {
			return false;
		}

		$user_id  = absint( $user_id );
		$meta_key = trim( $meta_key );

		if ( ! $user_id && empty( $meta_key ) ) {
			return false;
		}

		return \delete_user_meta( $user_id, $meta_key );

	}

	/**
	 * Delete an option
	 *
	 * @param string $key
	 *
	 * @return void
	 */
	public static function delete_option( $key ) {
		$trimmed_key = trim( $key );
		if ( ! empty( $trimmed_key ) ) {
			return \delete_option( $trimmed_key );
		}

		return false;
	}

	/**
	 * Update user specif data based on login choice $global|$local.
	 *
	 * @param string $meta_key
	 * @param string $value;
	 * @return void
	 */
	public static function update_user_specific_login_meta( $meta_key, $value ) {
		return Login::get_link_my_account() ? self::update_user_meta( get_current_user_id(), $meta_key, $value ) : self::update_option( $meta_key, $value );
	}

	/**
	 * Get user speficic data based on login choiche $global|$local
	 *
	 * @param string $meta_key
	 * @return mixed
	 */
	public static function get_user_specific_login_meta( $meta_key, $default = false, $single = true ) {
		return Login::get_link_my_account() ? self::get_user_meta( get_current_user_id(), $meta_key, $default, $single ) : self::get_option( $meta_key, $default );
	}

	/**
	 * Delete user speficic data based on login choiche $global|$local
	 *
	 * @param string $meta_key
	 * @return mixed
	 */
	public static function delete_user_specific_login_meta( $meta_key ) {
		return Login::get_link_my_account() ? self::delete_user_meta( get_current_user_id(), $meta_key ) : self::delete_option( $meta_key );
	}

}
