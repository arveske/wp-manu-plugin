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


function myplugin_enqueue_style_admin() {

	/*
		wp_enqueue_style(
			string           $handle,
			string           $src = '',
			array            $deps = array(),
			string|bool|null $ver = false,
			string           $media = 'all'
		)
	*/

	$src = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css';
  $src1 = plugin_dir_url( __FILE__ ).'admin/css/style.css';

	wp_enqueue_style( 'myplugin-admin', $src, array(), null, 'all' );
  wp_enqueue_style( 'myplugin-admin1', $src1, array(), null, 'all' );
}
add_action( 'admin_enqueue_scripts', 'myplugin_enqueue_style_admin' );


function myplugin_enqueue_script_admin() {

	/*
		wp_enqueue_script(
			string           $handle,
			string           $src = '',
			array            $deps = array(),
			string|bool|null $ver = false,
			bool             $in_footer = false
		)
	*/

	$src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js';
  $src1 = 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js';
  $src2 = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js';

	wp_enqueue_script( 'myplugin-admin', $src, array(), null, false );
  wp_enqueue_script( 'myplugin-admin1', $src1, array(), null, false );
  wp_enqueue_script( 'myplugin-admin2', $src1, array(), null, false );


}
add_action( 'admin_enqueue_scripts', 'myplugin_enqueue_script_admin' );
