<?php
/**
 * This class responsible for database work
 * using wordpress functionality 
 * get_option and update_option.
 */
class Crowdfundly_Settings {

    public static $settings_key = 'crowdfundly_settings'; 

    /**
     * Get all default settings value.
     *
     * @param string $name
     * @return array
     */ 
    public static function default_settings()  
    {
                
        $option_default = array(

        );

        return $option_default;
    }

    /**
     * Get all settings value from options table.
     *
     * @param string $name
     * @return array
     */
    public static function get( $name = '' )
    {

        $settings = get_option( static::$settings_key, true );
        if( ! empty( $name ) ) {
            if( isset( $settings[ $name ] ) ) {
                return $settings[ $name ];
            }
        }

        return is_array( $settings ) ? $settings : [];
    }

    /**
     * Update settings 
     * 
     * @param array $value
     * @return boolean
     */
    public static function update( $value, $key = null )
    {
        if( ! is_null( $key ) ) {
            return update_option( $key, $value );
        }
        return update_option( static::$settings_key, $value );
	}

    /**
     * Get crowdfundly bearer token
     * 
     * @param none
     * @return string|null
     */
    public static function getToken()
    {
        return self::get('token', null);
    }

    /**
     * Check token exists or not
     *
     * @param none
     * @return boolean
     */
    public static function hasToken() 
    {
        return boolval(self::getToken());
    }

    /**
     * Perpare settings page
     *
     * @param none
     * @return array
     */
    public static function settings_args() 
    {
        if (!function_exists('crowdfundly_settings_args')) {
            require CROWDFUNDLY_ADMIN_DIR_PATH . 'includes/crowdfundly-settings-page-helper.php';
        }
        do_action('crowdfundly_before_settings_load');
        return crowdfundly_settings_args();
    }

    /**
     * Get donation page permalink
     *
     * @param string
     * @return false|string
     */     
    public static function getDonationPagePermalink($campaign_slug)
    {
        $crowdfundlu_user = get_option( 'crowdfundly_user', null );
        $username = $crowdfundlu_user ? $crowdfundlu_user->username : '';

        $redirect_url = self::getSingleCampaingPagePermalink($campaign_slug);
		
        return Crowdfundly_Helper::buildUrl(
            esc_url("https://" . $username . ".crowdfundly.io/campaigns/" . $campaign_slug),
            [
                'redirect_back_url' => esc_url($redirect_url)
            ]
        );
    }

    /**
     * Get single campaign page permalink
     *
     * @param integer
     * @return false|string
     */     
    public static function getSingleCampaingPagePermalink($campaign_id)
    {
		$pageId = get_option('crowdfundly_single_campaign_page_id');
        return Crowdfundly_Helper::buildUrl(
            get_page_link($pageId),
            [
                'camp_id' => $campaign_id
            ]
        );
    }

    public static function getOrganizationPageId()
    {
        return get_option('crowdfundly_organization_page_id');
    }

    /**
     * Get organization page permalink
     *
     * @param none
     * @return string
     */     
    public static function getOrganizationPagePermalink()
    {
        $organizationId = self::getOrganizationPageId();
        return Crowdfundly_Helper::buildUrl(get_page_link($organizationId));
    }

    /**
     * Get crowdfundly user
     *
     * @param none
     * @return false|integer|array
     */    
    public static function getAllCampaignPageId()
    {
        return get_option('crowdfundly_all_campaigns_page_id');
    }

    /**
     * Get crowdfundly user
     *
     * @param none
     * @return string
     */          
    public static function getAllCampaignPagePermalink()
    {
        return get_page_link( get_the_ID() );
    }

    public static function getAllCampaignPageLinkByID()
    {
        $allCampaignPageId = self::getAllCampaignPageId();
        return Crowdfundly_Helper::buildUrl(get_page_link($allCampaignPageId));
    }

    /**
     * Update crowdfundly user
     *
     * @param none
     * @return boolean
     */          
    public static function updateUser($user)
    {
        update_option('crowdfundly_user', $user);
	}

    /**
     * Get crowdfundly user
     *
     * @param none
     * @return false|array|object
     */      
    public static function getUser()
    {
        return get_option('crowdfundly_user', null);
	}

    public static function get_countries() {
		$crowdfundly_settings = json_decode( json_encode( get_option( 'crowdfundly_settings', null ) ) );
		if ( $crowdfundly_settings != null ) {
			return $crowdfundly_settings->countries;
		}
	}

    public static function get_currencies() {
		$crowdfundly_settings = json_decode( json_encode( get_option( 'crowdfundly_settings', null ) ) );
		if ( $crowdfundly_settings != null ) {
			return $crowdfundly_settings->currencies;
		}
	}

    public static function is_email_log_in() {
        $crowdfundly_settings = json_decode( json_encode( get_option( 'crowdfundly_settings', null ) ) );
		if ( $crowdfundly_settings != null ) {
			return $crowdfundly_settings->email_login;
		}
    }

    /**
     * Display shortcodes tab content
     *
     * @param none
     * @return html
     */     
    public static function shortcodes_tab_content()
    {
        include CROWDFUNDLY_ADMIN_DIR_PATH . 'partials/crowdfundly-shortcodes-display.php';
    }

    /**
     * Design content tab
     *
     * @param none
     * @return html
     */    
    public static function design_tab_content()
    {
        $query['autofocus[panel]'] = 'crowdfundly_customize_options';
        $query['return'] = admin_url( 'admin.php?page=crowdfundly-settings' );

        $campaignPageId = self::getOrganizationPageId();

        if(!empty($campaignPageId)){
            $query['url'] = get_permalink($campaignPageId);
        }

        $customizer_link = add_query_arg( $query, admin_url( 'customize.php' ) );

		$btn_text = __( 'Design on Customizer', 'crowdfundly' );
        $html = '<div class="crowdfundly-customizer-design-box">';
        $html .= '<a href="'.$customizer_link.'" class="crowdfundly-customizer-btn"><i class="fas fa-paint-brush"></i> ' . $btn_text . '</a>';
        $html.="</div>";

        echo $html;
	}

	public static function clear_crowdfundly_data() {
		$crowdfundly_settings = delete_option('crowdfundly_settings');
		$crowdfundly_user = delete_option('crowdfundly_user');
		if ( $crowdfundly_settings == false && $crowdfundly_user == false ) {
			throw new \Exception(false);
		}
		return true;
	}

}