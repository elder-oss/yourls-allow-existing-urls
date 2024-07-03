<?php
/*
Plugin Name: Allow Existing URLs
Plugin URI: https://github.com/elder-oss/yourls-allow-existing-urls
Description: Changes the response (to success) when a URL has already been saved and YOURLS_UNIQUE_URLS=true
Version: 1.0.0
Author: Elder Technologies Ltd
Author URI: https://www.elder.org/
*/

// block direct calls
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_filter( 'add_new_link_already_stored_filter', 'allow_existing_urls' );

// if the link has already been stored, return success anyway
function allow_existing_urls( $return, $url, $keyword, $title  ) {
	if ( isset( $return['code'] ) ) {
		if ( $return['code'] === 'error:url' ){
			if ($url_exists = yourls_url_exists( $url )) {
				$return['status']     = 'success';
				$return['code']       = '';
				$return['errorCode']  = '200';
				$return['statusCode'] = '200';
			}
		}
	}
	return yourls_apply_filter( 'after_allow_existing_urls', $return, $url, $keyword, $title );
}
