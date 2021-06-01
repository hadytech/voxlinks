<?php
/**
 * Class Crowdfundly_Shortcode
 * Handles all public shortcodes for Crowdfundly
 * @since 1.0.0
 */
class Crowdfundly_Shortcode
{
    /**
     * Crowdfundly_Shortcode constructor.
     */
    public function __construct() 
    {
        add_shortcode( 'crowdfundly-organization', array( $this, 'render_organization_shortcode' ) );
        add_shortcode( 'crowdfundly-all-campaigns', array( $this, 'render_all_campaigns_shortcode' ) );
        add_shortcode( 'crowdfundly-campaign', array($this, 'render_single_campaign_shortcode'));
    }

    /**
     * Render content for shortcode 'organization'
     * @since 1.0.0
     * @return false|string
     */
    public function render_organization_shortcode()
    {
        $company = $this->get_organization_info();
        $recent_campaigns = $this->get_recent_campaigns();
		
		ob_start();
        switch ($company->template_id) {
            case 1:
                include CROWDFUNDLY_PUBLIC_PATH . 'partials/organization/template-one.php';
                break;
            case 2:
                include CROWDFUNDLY_PUBLIC_PATH . 'partials/organization/template-two.php';
                break;
            default:
                break;
        }
        return ob_get_clean();
    }

    /**
     * Render content for shortcode 'all campaign'
     * @since 1.0.0
     * @return void
     */    
    public function render_all_campaigns_shortcode() {
        $campaigns = self::get_all_campaigns();
        if ( !$campaigns ) {
            return null;
        }

        $search_params = [];
        if ( isset($_GET['search']) ) {
            $search_params['search_key'] = sanitize_text_field($_GET['search']);
        }
        if ( isset($_GET['type']) ) {
            $search_params['camp_type'] = sanitize_text_field($_GET['type']);
        }

        $camps = null;
        $crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_all_camps', '' );

        if ( ! empty( $crowdfundly_elementor_settings['all_camp_per_page'] ) ) {
            $all_camp_per_page = $crowdfundly_elementor_settings['all_camp_per_page'];
            $camps = self::get_all_campaigns($all_camp_per_page, $search_params);
        } else {
            $all_camp_per_page = get_theme_mod( 'cf_all_camp_per_page', 15 );
            $camps = self::get_all_campaigns($all_camp_per_page, $search_params);
        }

        $data = ($camps == null) ? $campaigns->data : $camps->data;
        $last_page = ($camps == null) ? $campaigns->last_page : $camps->last_page;
        $total_camps = count( $campaigns->data );

        ob_start();
            include CROWDFUNDLY_PUBLIC_PATH . 'partials/crowdfundly-all-campaigns-page.php';
        return ob_get_clean();
    }

    /**
     * Render content for shortcode 'single campaign'
     * @since 1.0.0
     * @return void
     */     
    public function render_single_campaign_shortcode()
    {
        $singleCampaign         = self::get_single_campaign();
		$campaign               = isset( $singleCampaign['campaign'] ) ? $singleCampaign['campaign'] : [];
		$campaign_presets       = isset( $singleCampaign['campaign_presets'] ) ? $singleCampaign['campaign_presets'] : [];
        $updates                = isset( $singleCampaign['updates'] ) ? $singleCampaign['updates'] : [];
        $topDonor               = isset( $singleCampaign['topDonor'] ) ? $singleCampaign['topDonor'] : [];
        $activities             = isset( $singleCampaign['activities'] ) ? $singleCampaign['activities'] : [];
        $total_activities       = isset( $singleCampaign['activities_total'] ) ? $singleCampaign['activities_total'] : 0;
        $endorsements           = isset( $singleCampaign['endorsements'] ) ? $singleCampaign['endorsements'] : [];
		$similars               = isset( $singleCampaign['similars'] ) ? $singleCampaign['similars'] : [];
		$organization_gateways  = isset( $singleCampaign['organization_gateways'] ) ? $singleCampaign['organization_gateways'] : [];
        $notice                 = $singleCampaign['notice'];

        $current_user = wp_get_current_user();
        if ( $notice && empty( $current_user->roles ) ) {
            $campaign = [];
        } elseif ( $notice && ! empty( $current_user->roles ) ) {
            foreach ( $current_user->roles as $role ) {
                $role != 'administrator' ? $campaign = [] : '';
            }
        }

        if (!$campaign) {
            return null;
		}
		
        ob_start();
        include CROWDFUNDLY_PUBLIC_PATH . 'partials/crowdfundly-single-campaign-page.php';
        return ob_get_clean();
    }

    /**
     * Get company info from api
     * @since 1.0.0
     * @return object|bool
     */
    private function get_organization_info()
    {
        $organization = get_option( 'crowdfundly_user', null );
        $username 	  = isset($organization->username)?$organization->username:''; 
        $orgs_info    = Crowdfundly_Api::get('organization', [], $username);
        if( !empty( $orgs_info ) ){
            return $orgs_info;
		}
        return false;
    }

    /**
     * Retrieve all campaign information
     * @since 1.0.0
     * @return false|array
     */  
    public static function get_all_campaigns($per_page = 15, $search_params = []) {
        $organization = get_option( 'crowdfundly_user', null );
        $username = isset($organization->username) ? $organization->username : '';
        // $camps_info = Crowdfundly_Api::get( 'organization', $search_params, $username . '/active-campaigns/' . '?per_page=' . $per_page );

        $extra_route = '/' . $username . '/active-campaigns/' . '?per_page=' . $per_page;
        $search_param = '';

        if ( array_key_exists( 'search_key', $search_params ) ) {
            $search_param = '&search=' . $search_params['search_key'];
        } elseif ( array_key_exists( 'camp_type', $search_params ) ) {
            $search_param = '&type=' . $search_params['camp_type'];
        }
        if ( array_key_exists( 'search_key', $search_params ) && array_key_exists( 'camp_type', $search_params ) ) {
            $search_param = '&type=' . $search_params['camp_type'] . '&search=' . $search_params['search_key'];
        }
        
        $response = wp_remote_get( Crowdfundly_Api::$get_endpoints['organization'] . $extra_route . $search_param );
        $camps_info = json_decode( wp_remote_retrieve_body( $response ) );

        if (! empty($camps_info) ) {
            return $camps_info;
        }

        return false;
    }

    /**
     * Retrieve single campaign information
     * @since 1.0.0
     * @return false|array
     */     
    public static function get_single_campaign()
    {
        $camps = self::get_all_campaigns();

		$single_camp_id  = apply_filters( 'crowdfundly_single_camp', '' );
		$campaignSlug    = isset( $single_camp_id['camp_id'] ) ? $single_camp_id['camp_id'] : null;

		if ( ! $campaignSlug && $camps != false && ! empty( $camps->data ) ) {
			$campaignSlug = $camps->data[0]->slug;
		}

		if ( isset($_GET['camp_id']) ) {
            $campaignSlug = sanitize_text_field($_GET['camp_id']);
        }

        if ($campaignSlug != null) {
            $options = [
                'method' => 'GET',
                'headers' => [ 'Authorization' => 'Bearer ' . get_option( 'crowdfundly_settings', null )['token'] ]
            ];
		    $response = wp_remote_request( Crowdfundly_Api::$get_endpoints['campaign'] . '/' . $campaignSlug, $options );
            $campaign = json_decode( wp_remote_retrieve_body( $response ) );

            if (! empty($campaign) ) {

                $singleCampaign = [
                    'campaign' => $campaign,
				];

				$organization_gateways_route = $campaign->organization->id . '/available-gateway';
                $organization_gateways = Crowdfundly_Api::get('organization', [], $organization_gateways_route);
				
				$presets_route = $campaign->id . '/presets';
                $campaign_presets = Crowdfundly_Api::get('campaign', [], $presets_route);

                $donorSlug = $campaign->id . '/top-donors';
                $topDonor = Crowdfundly_Api::get('campaign', [], $donorSlug);

                $activitiesSlug = $campaign->id . '/activities';
                $activities = Crowdfundly_Api::get('campaign', [
                    'per_page' => 3,
					'page'     => 1
                ], $activitiesSlug);

                $endorsementSlug = $campaign->id . '/endorsements';
                $endorsements = Crowdfundly_Api::get('campaign', [
                    'show_all' => true,
                    'status'   => 1
                ], $endorsementSlug);

                $updatesSlug = $campaign->id . '/updates';
                $updates = Crowdfundly_Api::get('campaign', [
                    'per_page' => 1000
                ], $updatesSlug);                

                $similarsSlug = $campaign->slug . '/similar';
                $similars = Crowdfundly_Api::get('campaign', [
                    'show_all' => true
                ], $similarsSlug);   


				if ( ! empty( $organization_gateways ) ) {
					$singleCampaign['organization_gateways'] = $organization_gateways;
				}

				if ( ! empty( $campaign_presets->presets ) ) {
                    $singleCampaign['campaign_presets'] = $campaign_presets->presets;
				}
				
                if (! empty($topDonor)) {
                    $singleCampaign['topDonor'] = $topDonor;
                }

                if (! empty($activities) ) {
					$singleCampaign['activities'] = $activities;     
					$singleCampaign['activities_total'] = $activities->total;                  
                }

                if (! empty($endorsements) ) {
                    $singleCampaign['endorsements'] = $endorsements;
                }

                if (! empty($updates)) {
                    $singleCampaign['updates'] = $updates;
                } 
                
                if (! empty($similars)) {
                    $singleCampaign['similars'] = $similars;
                }

                $singleCampaign['notice'] = null;
                if ( $campaign->status == 0 || $campaign->status == 2 || $campaign->status == 16 ) {
                    $singleCampaign['notice'] = __( 'This campaign is in readonly view and publicly invisible.', 'crowdfundly' );
                }

                return $singleCampaign;
            }
        }

        return false;
    }

    /**
     * Gel organization basic information
     * @since 1.0.0
     * @return false|object
     */ 
	private function get_recent_campaigns() {

        $organization = get_option( 'crowdfundly_user', null );
		if ( empty( $organization ) ) return;
        $username 		= isset($organization->username)?$organization->username:''; 
		$recent_campaigns = Crowdfundly_Api::get('organization', [], $username . '/recent-campaigns');
		return $recent_campaigns;
	}

    /**
     * Gel campaign information
     * @since 1.0.0
     * @return false|string
     */    
    private function get_campaign_donation()
    {
        if (isset($_GET['camp_id'])) {
            $campaignSlug = sanitize_text_field($_GET['camp_id']);
            $campaign = Crowdfundly_Api::get('campaign', [], $campaignSlug);
            if (! empty($campaign) ) {
                return $campaign;
            }
        }

        return false;
    }
    
}