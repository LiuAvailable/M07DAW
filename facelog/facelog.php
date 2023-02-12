<?php

/**
 * Plugin Name: FaceLog Plugin
 * Plugin URI: http://boscdelacoma.cat
 * Description: Pràctica MP07.
 * Version: 0.1
 * Author: ELTEUNOM
 * Author URI:  http://boscdelacoma.cat
 **/

 const FACELOG_DB_VERSION = '1.0';
 const FACELOG_VERSION= '1.0';
 
 // Allow subscribers to see Private posts and pages
 $subRole = get_role( 'subscriber' );
 $subRole->add_cap( 'read_private_posts' );
 $subRole->add_cap( 'read_private_pages' );
 

 function facelog_example(){
    return "Hola a tothom!";
 }

 add_shortcode('facelog', 'facelog_example');


// Create a new page when the plugin is activated
function pg_create_page() {
  // Check if the page already exists
  $page_exists = get_page_by_title( 'FACELOG' );
  if ( !$page_exists ) {

    // Create a new page if it doesn't exist
    $page = array(
      'post_type'    => 'page',
      'post_title'   => 'FACELOG',
      'post_content' => $page_content = file_get_contents( plugin_dir_path( __FILE__ ) . 'visual/facelog.php' ),
      'post_status'  => 'publish',
    );
    $page2 = array(
      'post_type'    => 'page',
      'post_title'   => 'upload',
      'post_content' => $page_content = file_get_contents( plugin_dir_path( __FILE__ ) . 'visual/upload.php' ),
      'post_status'  => 'publish',
    );
    wp_insert_post( $page );
    wp_insert_post( $page2 );
  }
}
register_activation_hook( __FILE__, 'pg_create_page' );

// Delete the page when the plugin is deactivated
function pg_delete_page() {
  // Get the page object
  $page = get_page_by_title( 'FACELOG' );
  $page2 = get_page_by_title( 'upload' );
  if ( $page ) {
    wp_delete_post( $page->ID, true );
    wp_delete_post( $page2->ID, true );
  }
  deleteTable();
  deleteDirectory('C://xampp/htdocs/wordpress/wp-content/plugins/facelog/uploads/img');
}

function deleteTable(){
  global $wpdb;
  $sql = "DROP TABLE wordpress.wp_images";
  $result = $wpdb->query($sql);
}

function deleteDirectory($dir) {
 if (is_dir($dir))
 {
  $objects = scandir($dir);

  foreach ($objects as $object)
  {
   if ($object != '.' && $object != '..')
   {
    if (filetype($dir.'/'.$object) == 'dir') {rrmdir($dir.'/'.$object);}
    else {unlink($dir.'/'.$object);}
   }
  }

  reset($objects);
  rmdir($dir);
 }
}

register_deactivation_hook( __FILE__, 'pg_delete_page' );