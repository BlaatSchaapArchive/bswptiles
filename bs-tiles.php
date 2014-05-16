<?php
/*
Plugin Name: BlaatSchaap Tiles
Plugin URI: http://code.blaatschaap.be
Description: Create tiles for posts
Version: 0.1
Author: André van Schoubroeck
Author URI: http://andre.blaatschaap.be
License: BSD
*/

require_once("blaat.php");


function blaat_tiles_menu() {

  if (!is_menu_page_registered('blaat_plugins')){
    add_menu_page('BlaatSchaap', 'BlaatSchaap', 'manage_options', 'blaat_plugins', 'blaat_plugins_page');
    //add_submenu_page('blaat_plugins', "" , "" , 'manage_options', 'blaat_plugins', 'blaat_plugins_page');
  }


  add_submenu_page('blaat_plugins' ,  __('Tiles Configuration',"blaat_tiles"),
                                      __('Tiles',"blaat_tiles"),
                                      'manage_options',
                                      'blaat_tiles_config',
                                      'blaat_tiles_config_page' );

}

add_action("admin_menu", blaat_tiles_menu);

//----------------------------------------------------------------------------
function blaat_tiles_config_page(){
    echo '<div class="wrap">';
    echo '<h2>';
    _e("BlaatSchaap Tiles","blaat_auth");
    echo '</h2>';
}
//----------------------------------------------------------------------------
function blaat_generate_tile($url, $title, $excerpt, $thumbnail){
    echo "<a href='$url'>";
    echo "<div class='bs-tile'><div class='bs-tile-title'>$title</div>";
    echo "<img class='bs-tile-thumbnail' src='$thumbnail'>";
    echo "<div class='bs-tile-excerpt'>$excerpt</div></div>";
    echo "</a>";
}

//----------------------------------------------------------------------------
function blaat_tiles_display($atts, $content, $tag){


  $args = array( 'posts_per_page' => 6 ,'post_status'      => 'publish','orderby'          => 'post_date',);
  $postslist = get_posts( $args );
  foreach ( $postslist as $post ) {
                setup_postdata( $post );
                $title = get_the_title($post->ID);
		$excerpt =  get_the_excerpt();
                $url = get_permalink($post->ID ); 
	
		if (has_post_thumbnail($post->ID)  ) {
		  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(150,150) ); 
 		  $thumbnail=$image[0];
		}
		else $thumbnail="none";
		blaat_generate_tile($url,$title,$excerpt,$thumbnail);
		wp_reset_postdata();
  }


}
//----------------------------------------------------------------------------
add_shortcode( 'bstiles', 'blaat_tiles_display' );

wp_register_style("blaat_tiles" , plugin_dir_url(__FILE__) . "css/bs-tiles.css");
wp_enqueue_style( "blaat_tiles");


?>
