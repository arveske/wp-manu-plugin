<?php

function myplugin_add_toplevel_menu() {


add_menu_page(
  'Manu Test',
  'Manu:Plugin',
  'manage_options',
  'manu-test-plugin',
  'manu_plugin_page',
  'dashicons-editor-justify',
  null
);

}
add_action( 'admin_menu', 'myplugin_add_toplevel_menu' );
