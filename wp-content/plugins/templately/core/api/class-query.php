<?php

namespace Templately;

class Query {
    private static $url = 'https://app.templately.com/api/plugin';

    private static function get_url(){
        if( defined('TEMPLATELY_DEV') && TEMPLATELY_DEV ) {
            self::$url = 'https://app.templately.dev/api/plugin';
        }
        return self::$url;
    }

    public static function prepare( $query, ...$args ){
        return \sprintf( $query, ...$args );
    }

    public static function get( $query, $args = array() ){
        $headers = array(
            'Content-Type' => 'application/json',
        );

        if( isset( $args['headers'] ) && ! empty( $args['headers'] ) ) {
            $headers = wp_parse_args( $args['headers'], $headers );
            unset( $args['headers'] );
        }

        $response = wp_remote_post( self::get_url(),
            array(
                'headers' => $headers,
                'body' => wp_json_encode([
                    'query' => $query
                ])
            )
        );
        return self::maybeErrors( $response, $args );
    }

    private static function maybeErrors( &$response, $args = [] ){
        if( $response instanceof \WP_Error ) {
            return $response; // Return WP_Error, if it is an error.
        }
        /**
         * Retrive Data from Response Body.
         */
        $response = json_decode( wp_remote_retrieve_body( $response ), true );
        /**
         * @param mixed $args['is_rest']
         */
        $is_rest = isset( $args['is_rest'] ) ? $args['is_rest'] : false;
        /**
         * If the graphql hit with any error.
         */
        if( $is_rest && ! $response instanceof \WP_Error && isset( $response['errors'] ) && ! empty( $response['errors'] ) ) {
            if( is_array( $response['errors'] ) ) {
                $wp_error = new \WP_Error;
                array_walk( $response['errors'], function( $error ) use( &$wp_error ) {
                    if( isset( $error['message'] ) ) {
                        $wp_error->add( 'templately_graphql_error', $error['message'] );
                    }
                });
                return $wp_error;
            }
        }

        if( $is_rest && isset( $args['only_data'] ) && $args['only_data'] == true ) {
            if( isset( $response['data'], $response['data'][ $args['query'] ] ) ) {
                return $response['data'][ $args['query'] ];
            }
        }

        return $response;
    }

    public static function getFromLibrary( $id ){
        $local = new \Elementor\TemplateLibrary\Source_Local();
        $content = $local->get_data( [
			'template_id' => $id
        ] );
        return $content;
    }

    public static function remove_cloud_item( $id, $api_key, $from = 'cloud' ){
        $query = sprintf(
            '%s( api_key: "%s", file_id: %s){ status, data, message }}',
            $from === 'cloud' ? 'query{ removeFromMyCloud' : 'mutation { deleteWorkspaceFile',
            $api_key,
            $id
        );
        return self::get( $query );
    }

    public static function push( $name, $file_content, $api_key, $item_type, $args = array() ){
        $headers = array(
            'Content-Type' => 'application/json',
        );

        if( isset( $args['headers'] ) && ! empty( $args['headers'] ) ) {
            $headers = wp_parse_args( $args['headers'], $headers );
        }
        $workspace_id = false;
        if( isset( $args['workspace_id'] ) && ! empty( $args['workspace_id'] ) ) {
            $workspace_id = intval( $args['workspace_id'] );
        }

        $mutation = \sprintf(
            'mutation{ pushToMyCloud( file_type: "%s", name: "%s", file_content: "%s", api_key: "%s"%s%s){ message, status, data } }',
            $item_type,
            $name,
            $file_content,
            $api_key,
            $workspace_id !== false ? ', workspace_id: ' . $workspace_id : '',
            isset( $args['thumbnail'] ) ? ', thumbnail: "' . $args['thumbnail'] . '"' : ''
        );

        $response = wp_remote_post( self::get_url(),
            array(
                'headers' => $headers,
                'body' => wp_json_encode([
                    'query' => $mutation
                ])
            )
        );

        if( is_wp_error( $response ) ) {
            return $response;
        }
        $api_response = json_decode( wp_remote_retrieve_body( $response ), true );
        return $api_response;
    }
}
