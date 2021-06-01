<?php
/**
 * This class responsible for database work
 * using wordpress functionality 
 * get_option and update_option.
 */
class ReviewX_DB {
    /**
     * Get all settings value from options table.
     * or, get settings for a specific $key
     *
     * @param string $name
     * @return array
     */
    public static function get_settings( $name = '' ) {
        $settings = get_option( 'ReviewX_settings', true );

        if( ! empty( $name ) && isset( $settings[ $name ] ) ) {
            return $settings[ $name ];
        }
        
        if( ! empty( $name ) && ! isset( $settings[ $name ] ) ) {
            return '';
        }

        return is_array( $settings ) ? $settings : [];
    }
    /**
     * Update settings 
     * @param array $value
     * @return boolean
     */
    public static function update_settings( $value ){
        return update_option( 'ReviewX_settings', $value );
    }
}