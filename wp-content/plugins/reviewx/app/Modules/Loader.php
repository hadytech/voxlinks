<?php

namespace ReviewX\Modules;

use JoulesLabs\Warehouse\Facade\App;
use ReviewX\Constants\Reviewx;
use ReviewX\Controllers\Admin\Core\ReviewxAdmin;
use ReviewX\Controllers\Admin\Reviews\ManageAllReviews;

class Loader
{
    protected $app;
    protected $submenu;
    protected $quickSetup;

    public function __construct()
    {
        $this->setApp();
        $this->setSubmenu();

    }

    /**
     * @param mixed $app
     */
    public function setApp()
    {
        $this->app = App::make();;
    }

    /**
     *
     */
    public function setSubmenu()
    {

        $wc_is_enabled =  $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        if( $wc_is_enabled && class_exists('WooCommerce') ) {
            $this->submenu = apply_filters('rx_admin_submenu', [
                'all_reviews' => [
                    'parent_slug'   => 'rx-admin',
                    'page_title'    => __('All Reviews', 'reviewx'),
                    'menu_title'    => __('All Reviews', 'reviewx'),
                    'capability'    => 'manage_options',
                    'menu_slug'     => 'reviewx-all',
                    'callback'      =>  array($this, 'performAllReviewsPage')
                ],
                'review_email' => [
                    'parent_slug'   => 'rx-admin',
                    'page_title'    => __('WC Review Email', 'reviewx'),
                    'menu_title'    => __('WC Review Email', 'reviewx'),
                    'capability'    => 'manage_options',
                    'menu_slug'     => 'reviewx-review-email',
                    'callback'      =>  array((new ReviewxAdmin(PLUGIN_NAME, "1.0.2")), 'review_email')
                ],
                'quick_setup' => [
                    'parent_slug'   => 'rx-admin',
                    'page_title'    => __('WC Quick Setup', 'reviewx'),
                    'menu_title'    => __('WC Quick Setup', 'reviewx'),
                    'capability'    => 'manage_options',
                    'menu_slug'     => 'reviewx-quick-setup',
                    'callback'      =>  array((new ReviewxAdmin(PLUGIN_NAME, "1.0.2")), 'quick_setup')
                ],             
            ]);
        } else {
            $this->submenu = apply_filters('rx_admin_submenu', [
                'all_reviews' => [
                    'parent_slug'   => 'rx-admin',
                    'page_title'    => __('All Reviews', 'reviewx'),
                    'menu_title'    => __('All Reviews', 'reviewx'),
                    'capability'    => 'manage_options',
                    'menu_slug'     => 'reviewx-all',
                    'callback'      =>  array($this, 'performAllReviewsPage')
                ],  
                'quick_setup' => [
                    'parent_slug'   => 'rx-admin',
                    'page_title'    => __('WC Quick Setup', 'reviewx'),
                    'menu_title'    => __('WC Quick Setup', 'reviewx'),
                    'capability'    => 'manage_options',
                    'menu_slug'     => 'reviewx-quick-setup',
                    'callback'      =>  array((new ReviewxAdmin(PLUGIN_NAME, "1.0.2")), 'quick_setup')
                ],                             
            ]);            
        }

        add_filter('set-screen-option', [ $this, 'saveReviewPerPage' ], 10, 3);
        add_filter('set-screen-option', [ $this, 'saveReviewEmailPerPage' ], 10, 3);
    }

    public function registerSubmenu()
    {
        foreach ($this->submenu as $key => $submenu) {
            if ( isset($submenu['capability']) && current_user_can($submenu['capability']) ) {
                $hook = add_submenu_page(
                    $submenu['parent_slug'],
                    $submenu['page_title'],
                    $submenu['menu_title'],
                    $submenu['capability'],
                    $submenu['menu_slug'],
                    $submenu['callback']
                );

                if( 'reviewx_page_reviewx-all' == $hook ) {
                    add_action( "load-$hook", [ $this, 'setReviewOptionScreen'] );
                }

                if( 'reviewx_page_reviewx-review-email' == $hook ) {
                    add_action( "load-$hook", [ $this, 'setReviewEmailOptionScreen'] );
                }                
                
            }
        }
    }

    // register common assets
    public function loadCommonAssets()
    {

    }

    public function loadReviewsPageAssets()
    {
        \wp_enqueue_style(
            $this->app->getSlug() . '_admin_css',
            \esc_url(assets('css/reviewx_admin.css'))
        );

        \wp_enqueue_script(
            $this->app->getSlug() . "_admin_js",
            \esc_url(assets('js/reviewx_admin.js'))
        );
    }

    public function performAllReviewsPage()
    {
        $this->loadCommonAssets();
        $this->loadReviewsPageAssets();

        $records = new ManageAllReviews;

        $domain = 'reviewx';

        $searchBoxText = __('Search reviews', 'reviewx');

	    $searchColumn = ManageAllReviews::$SEARCH_COLUMN;

        if(isset($_GET['rxaction'] ) ) {
            echo \view('admin.pages.edit-review');
        } else {
            echo \view('admin.pages.manage-all-reviews', compact('records','domain','searchBoxText','searchColumn'));
        }
    }

    public function performSettingPage()
    {
    }

    public function setReviewOptionScreen()
    {

        $option = 'per_page';

        $args = array(
            'label'     => __('Number of items per page:', 'reviewx'),
            'default'   => 20,
            'option'    => 'edit_review_per_page'
        );

        add_screen_option( $option, $args );

    }

    public function saveReviewPerPage( $status, $option, $value )
    {

        if ( 'edit_review_per_page' == $option ) return $value;

        return $status;

    }

    public function setReviewEmailOptionScreen()
    {

        $option = 'per_page';

        $args = array(
            'label'     => __('Number of items per page:', 'reviewx'),
            'default'   => 20,
            'option'    => 'edit_review_email_per_page'
        );

        add_screen_option( $option, $args );

    }

    public function saveReviewEmailPerPage( $status, $option, $value )
    {

        if ( 'edit_review_email_per_page' == $option ) return $value;

        return $status;

    }    

}
