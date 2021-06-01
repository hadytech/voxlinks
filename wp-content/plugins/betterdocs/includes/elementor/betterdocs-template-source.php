<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Working with elementor plugin
 *
 *
 * @since      1.3.0
 * @package    BetterDocs
 * @subpackage BetterDocs/elementor
 * @author     WPDeveloper <support@wpdeveloper.net>
 */
class BetterDocs_Template_Source extends Elementor\TemplateLibrary\Source_Base {

    protected $template_prefix = 'betterdocs_';
    protected $cloud_url = 'https://betterdocs.co/wp-json/bd_cloud/v1/';
    // protected $cloud_url = 'http://betterdocs.test/wp-json/bd_cloud/v1/';

    public function get_prefix() {
        return $this->template_prefix;
    }

    public function get_id() {
        return 'betterdocs-templates';
    }

    public function get_title() {
        return __( 'BetterDocs Templates', 'betterdocs' );
    }

    public function register_data() {
    }

    public function get_items( $args = array() ) {

        $url            = $this->cloud_url . 'templates';
        $response       = wp_remote_get( $url, [ 'timeout' => 60 ] );
        $body           = wp_remote_retrieve_body( $response );
        $body           = json_decode( $body, true );
        $templates_data = !empty( $body['data'] ) ? $body['data'] : false;
        $templates      = array();

        if ( !empty( $templates_data ) ) {
            foreach ( $templates_data as $template_data ) {
                $templates[] = $this->get_item( $template_data );
            }
        }

        if ( !empty( $args ) ) {
            $templates = wp_list_filter( $templates, $args );
        }

        return $templates;
    }


    public function get_item( $template_data ) {
        return [
            'accessLevel'     => 0,
            'template_id'     => $template_data['template_id'],
            'source'          => 'remote',
            'type'            => $template_data['type'],
            'subtype'         => $template_data['subtype'],
            'title'           => $template_data['title'],
            'thumbnail'       => $template_data['thumbnail'],
            'date'            => $template_data['date'],
            'author'          => $template_data['author'],
            'tags'            => $template_data['tags'],
            'isPro'           => ( 1 == $template_data['isPro'] ),
            'popularityIndex' => (int)$template_data['popularityIndex'],
            'trendIndex'      => (int)$template_data['trendIndex'],
            'hasPageSettings' => ( 1 == $template_data['hasPageSettings'] ),
            'url'             => $template_data['url'],
            'favorite'        => ( 1 == $template_data['favorite'] ),
        ];
    }

    public function save_item( $template_data ) {
        return false;
    }

    public function update_item( $new_data ) {
        return false;
    }

    public function delete_template( $template_id ) {
        return false;
    }

    public function export_template( $template_id ) {
        return false;
    }

    public function get_data( array $args, $context = 'display' ) {
        $file_url = $this->cloud_url . 'template/' . $args['template_id'];
        $request  = wp_remote_get( $file_url );
        $response = wp_remote_retrieve_body( $request );
        $body     = json_decode( $response, true );
        $data     = !empty( $body['data'] ) ? $body['data'] : false;

        $result = array();

        $result['content']       = $this->replace_elements_ids( $data );
        $result['content']       = $this->process_export_import_content( $result['content'], 'on_import' );
        $result['page_settings'] = array();

        return $result;
    }
}
