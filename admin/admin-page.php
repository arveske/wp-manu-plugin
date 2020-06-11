<?php

function manu_plugin_to_admin_menu() {


add_menu_page(
  'Manu Test',
  'Разработчики',
  'manage_options',
  'manu-test-plugin',
  'manu_plugin_page',
  'dashicons-editor-justify',
  null
);


}
add_action( 'admin_menu', 'manu_plugin_to_admin_menu' );
