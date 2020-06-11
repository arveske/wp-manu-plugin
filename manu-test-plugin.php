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

/*
  Get list of all developers as JSON file.
  GET method
*/
function get_all_developers() {
  $jsonPath = plugin_dir_url( __FILE__ ) . '/data.json';
  $response = wp_remote_get($jsonPath);
  $responseBody = wp_remote_retrieve_body( $response );
  $result = json_decode( $responseBody, true );

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

/*
      Add new developer to JSON file.
      POST method
      Required data: name, position, stack
*/
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
    } else {
      return 'Invalid data sent';
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route('manu/developers', 'create-developer/', [
            'methods' => 'POST',
            'callback' => 'add_developer',
    ]);
} );

/*
      Edit existed developer in JSON file.
      POST method
      Required data: id, name, position, stack
*/
function edit_developer($request) {
  if ( isset( $request['id'] ) && isset( $request['name'] ) && isset( $request['position'] )
    && isset( $request['stack'])) {
      $jsonPath = plugin_dir_url( __FILE__ ) . 'data.json';
      $response = wp_remote_get($jsonPath);
      $responseBody = wp_remote_retrieve_body( $response );
      $jsonArray = json_decode( $responseBody , true);

      $jsonArray['items'][$request['id']]['name'] = $request['name'];
      $jsonArray['items'][$request['id']]['position'] = $request['position'];
      $jsonArray['items'][$request['id']]['stack'] = $request['stack'];

      $responseBody = json_encode($jsonArray);
      $jsonPathDirPath = plugin_dir_path( __FILE__ ) . 'data.json';
      file_put_contents( $jsonPathDirPath,
      $responseBody);
      return 'ok';
    } else {
      return 'Invalid data sent';
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route('manu/developers', 'edit-developer/', [
            'methods' => 'POST',
            'callback' => 'edit_developer',
    ]);
} );

/*
      Delete developer from JSON file
      POST method
      Required data: id
*/
function delete_developer($request) {
  if ( isset( $request['id'] ) ) {
      $jsonPath = plugin_dir_url( __FILE__ ) . 'data.json';
      $response = wp_remote_get($jsonPath);
      $responseBody = wp_remote_retrieve_body( $response );
      $jsonArray = json_decode( $responseBody , true);

      $responseBody = json_encode($jsonArray);
      $jsonPathDirPath = plugin_dir_path( __FILE__ ) . 'data.json';
      file_put_contents( $jsonPathDirPath,
      $responseBody);
      return 'ok';
    } else {
      return 'Invalid data sent';
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route('manu/developers', 'delete-developer/', [
            'methods' => 'POST',
            'callback' => 'delete_developer',
    ]);
} );

/*
      Add custom style css file to header of admin panel
*/
function myplugin_enqueue_style_admin() {

	$bootstrapSrc = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css';
  $customStyles = plugin_dir_url( __FILE__ ).'admin/css/style.css';

	wp_enqueue_style( 'myplugin-admin', $bootstrapSrc, array(), null, 'all' );
  wp_enqueue_style( 'myplugin-admin1', $customStyles, array(), null, 'all' );
}

add_action( 'admin_enqueue_scripts', 'myplugin_enqueue_style_admin' );
