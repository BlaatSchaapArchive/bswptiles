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

  add_action( 'admin_init', 'bstiles_register_options' );

}

add_action("admin_menu", blaat_tiles_menu);

//----------------------------------------------------------------------------
function blaat_tiles_config_page(){
    
  $title_fgcolour     = get_option( 'bstiles_title_fgcolour' );
  $title_bgcolour     = get_option( 'bstiles_title_bgcolour' );
  $excerpt_fgcolour   = get_option( 'bstiles_excerpt_fgcolour' );
  $excerpt_bgcolour   = get_option( 'bstiles_excerpt_bgcolour' );
  $tile_bgcolour      = get_option( 'bstiles_tile_bgcolour' );
  $tile_width         = get_option( 'bstiles_tile_width' );
  $tile_height        = get_option( 'bstiles_tile_height' );
  $tile_corner        = get_option( 'bstiles_tile_corner' );
  $tile_margin        = get_option( 'bstiles_tile_margin' );
  $tiles_margin_left  = get_option( 'bstiles_tiles_margin_left');
  $tiles_margin_right = get_option( 'bstiles_tiles_margin_right');
  $tilecount          = get_option( 'bstiles_tilecount');


    echo '<div class="wrap">';
    echo '<h2>';
    _e("BlaatSchaap Tiles","blaat_auth");
    echo '</h2>';
 
    echo '<form method="post" action="options.php">';
    settings_fields( 'blaat_tiles' );

    echo '<table class="form-table">';

    echo '<tr><th>'. __("Title foreground colour","blaat_tiles") .'</th><td>';
    echo "<input value='$title_fgcolour' name='bstiles_title_fgcolour' class='colour'>";
    echo "<td>35</td>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Title background colour","blaat_tiles") .'</th><td>';
    echo "<input value='$title_bgcolour' name='bstiles_title_bgcolour' class='colour'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Excerpt foreground colour","blaat_tiles") .'</th><td>';
    echo "<input value='$excerpt_fgcolour' name='bstiles_excerpt_fgcolour' class='colour'>";
    echo '</td></tr>';
/*    
    echo '<tr><th>'. __("Excerpt background colour","blaat_tiles") .'</th><td>';
    echo "<input value='$excerpt_bgcolour' name='bstiles_excerpt_bgcolour' class='colour'>";
    echo '</td></tr>';
*/
    echo '<tr><th>'. __("Tile background colour","blaat_tiles") .'</th><td>';
    echo "<input value='$tile_bgcolour' name='bstiles_tile_bgcolour' class='colour'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Tile height","blaat_tiles") .'</th><td>';
    echo "<input value='$tile_height' name='bstiles_tile_height'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Tile width","blaat_tiles") .'</th><td>';
    echo "<input value='$tile_width' name='bstiles_tile_width'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Tile corner radius","blaat_tiles") .'</th><td>';
    echo "<input value='$tile_corner' name='bstiles_tile_corner'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Tile margin","blaat_tiles") .'</th><td>';
    echo "<input value='$tile_margin' name='bstiles_tile_margin'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Tiles margin left","blaat_tiles") .'</th><td>';
    echo "<input value='$tiles_margin_left' name='bstiles_tiles_margin_left'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Tiles margin right","blaat_tiles") .'</th><td>';
    echo "<input value='$tiles_margin_right' name='bstiles_tiles_margin_right'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Number of tiles","blaat_tiles") .'</th><td>';
    echo "<input value='$tilecount' name='bstiles_tilecount'>";
    echo '</td></tr>';

    echo '</table><input name="Submit" type="submit" value="';
    echo  esc_attr_e('Save Changes') ;
    echo '" ></form></div>';

    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );

     ?><script type="text/javascript">
    jQuery(document).ready(function($) {   
        $('.colour').wpColorPicker();
    });             
    </script><?php

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
  bstiles_generate_css();
  echo "<div class='bs-tiles'>";
  $tilecount          = get_option( 'bstiles_tilecount' );

  //category
  $args = array( 'posts_per_page'   => $tilecount ,
                 'post_status'      => 'publish',
                 'orderby'          => 'post_date');

  if (isset($atts['cat'])) $args['category']=$atts['cat'];

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
  echo "</div>";

}
//----------------------------------------------------------------------------
function bstiles_register_options(){
  register_setting( 'blaat_tiles', 'bstiles_title_fgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_title_bgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_excerpt_fgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_excerpt_bgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_tile_bgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_tile_width' );
  register_setting( 'blaat_tiles', 'bstiles_tile_height' );
  register_setting( 'blaat_tiles', 'bstiles_tile_corner' );
  register_setting( 'blaat_tiles', 'bstiles_tile_margin' );
  register_setting( 'blaat_tiles', 'bstiles_tiles_margin_left' );
  register_setting( 'blaat_tiles', 'bstiles_tiles_margin_right' );
  register_setting( 'blaat_tiles', 'bstiles_tilecount' );

}
//----------------------------------------------------------------------------
function bstiles_generate_css(){
  $title_fgcolour     = get_option( 'bstiles_title_fgcolour' );
  $title_bgcolour     = get_option( 'bstiles_title_bgcolour' );
  $excerpt_fgcolour   = get_option( 'bstiles_excerpt_fgcolour' );
  $excerpt_bgcolour   = get_option( 'bstiles_excerpt_bgcolour' );
  $tile_bgcolour      = get_option( 'bstiles_tile_bgcolour' );
  $tile_width         = get_option( 'bstiles_tile_width' );
  $tile_height        = get_option( 'bstiles_tile_height' );
  $tile_corner        = get_option( 'bstiles_tile_corner' );
  $tile_margin        = get_option( 'bstiles_tile_margin' );
  $tiles_margin_left  = get_option( 'bstiles_tiles_margin_left' );
  $tiles_margin_right = get_option( 'bstiles_tiles_margin_right' );


  echo "<style>
.bs-tiles {
    margin-left:".$tiles_margin_left."px;
    margin-right:".$tiles_margin_right."px;
}
.bs-tile {
  float:left; 
  width: ".$tile_width."px;
  height: ".$tile_height."px;
  border:$title_bgcolour 1px solid;
  overflow : hidden;
  margin: ".$tile_margin."px;
  background-color: $tile_bgcolour;
  border-radius: ".$tile_corner."px;
}

.bs-tile-thumbnail {
  float:left;
  width:150px;
  margin:10px;
  margin-bottom:0px;
}
.bs-tile-title {
  background-color: $title_bgcolour;
  color: $title_fgcolour;
  padding:10px;
}

.bs-tile-excerpt {
  /* background-color: $excerpt_bgcolour; */
  color: $excerpt_fgcolour;
  margin:5px;
  hyphens: none;
  -moz-hyphens: none;
  -o-hyphens: none;
  -ms-hyphens: none;
  -webkit-hyphens: none;
}
</style>";

}

add_shortcode( 'bstiles', 'blaat_tiles_display' );

//wp_register_style("blaat_tiles" , plugin_dir_url(__FILE__) . "css/bs-tiles.css");
wp_enqueue_style( "blaat_tiles");


?>
