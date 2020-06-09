<?php
/**
* @package           Manu_Test_Plugin
*
*Plugin Name: Manu Plugin
*Description: Test plugin for Manu:Team
*Plugin URI:  https://arveske.com/
*Author:      Artur Veske
*Version:     1.0
*License:     GPLv2 or later
*License URI: https://www.gnu.org/licenses/gpl-2.0.txt
**/

// if admin area
if ( is_admin() ) {

	// include dependencies
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-page.php';
  require_once plugin_dir_path( __FILE__ ) . 'admin/admin-page-info.php';

}

function get_all_developers() {
  $jsonPath = plugin_dir_url( __FILE__ ) . '/data.json';
  $response = wp_remote_get($jsonPath);
  $responseBody = wp_remote_retrieve_body( $response );
  $result = json_decode( $responseBody );
  if ( is_array( $result ) && ! is_wp_error( $result ) ) {
      return $result;
  } else {
      return $result;
  }
}

add_action( 'rest_api_init', function () {

           register_rest_route( 'manu/developers', 'get-all', [
             'methods'  => 'GET',
             'callback' => 'get_all_developers'
           ]
            );

    } );

function add_developer($request) {
  if ( isset( $request['name'] ) && isset( $request['position'] )
    && isset( $request['stack']) ) {
      $postData = array(
        'name' => $request['name'],
        'position' => $request['position'],
        'stack' => $request['stack']
      );
      $jsonPath = plugin_dir_url( __FILE__ ) . 'data.json';
      $response = wp_remote_get($jsonPath);
      $responseBody = wp_remote_retrieve_body( $response );
      $jsonArray = json_decode( $responseBody , true);
      array_push($jsonArray['items'], $postData);
      $responseBody = json_encode($jsonArray);
      $jsonPathDirPath = plugin_dir_path( __FILE__ ) . 'data.json';
      file_put_contents( $jsonPathDirPath,
      $responseBody);
      return 'ok';
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route('manu/developers', 'create-developer/', [
            'methods' => 'POST',
            'callback' => 'add_developer',
    ]);
} );
