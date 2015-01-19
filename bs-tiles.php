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


// localisation
load_plugin_textdomain('blaat_tiles', false, basename( dirname( __FILE__ ) ) . '/languages' );
//



function bstiles_menu() {

  if (!is_menu_page_registered('blaat_plugins')){
    add_menu_page('BlaatSchaap', 'BlaatSchaap', 'manage_options', 'blaat_plugins', 'blaat_plugins_page');
    //add_submenu_page('blaat_plugins', "" , "" , 'manage_options', 'blaat_plugins', 'blaat_plugins_page');
  }


  add_submenu_page('blaat_plugins' ,  __('Tiles Configuration',"blaat_tiles"),
                                      __('Tiles',"blaat_tiles"),
                                      'manage_options',
                                      'bstiles_config',
                                      'bstiles_config_page' );

  add_action( 'admin_init', 'bstiles_register_options' );

}

add_action("admin_menu", bstiles_menu);

//----------------------------------------------------------------------------
function bstiles_config_page(){
    
  $title_fgcolour     = get_option( 'bstiles_title_fgcolour' );
  $title_bgcolour     = get_option( 'bstiles_title_bgcolour' );
  $title_height       = get_option( 'bstiles_title_height' );
  $title_padding      = get_option( 'bstiles_title_padding' );
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
  $paginate           = get_option( 'bstiles_paginate');
  $archive            = get_option( 'bstiles_archive');
  $showexcerpt        = get_option( 'bstiles_showexcerpt' );
  $imagesize          = get_option( 'bstiles_imagesize' );


    echo '<div class="wrap">';
    echo '<h2>';
    _e("BlaatSchaap Tiles","blaat_tiles");
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

    echo '<tr><th>'. __("Title height","blaat_tiles") .'</th><td>';
    echo "<input value='$title_height' name='bstiles_title_height'>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Title padding","blaat_tiles") .'</th><td>';
    echo "<input value='$title_padding' name='bstiles_title_padding'>";
    echo '</td></tr>';



    echo '<tr><th>'. __("Show Excerpt","blaat_tiles") .'</th><td>';
    echo "<select name='bstiles_showexcerpt'>";
    echo "<option value='1' ";
    if (get_option(bstiles_showexcerpt)==1) echo " selected ";
    echo ">".__("Yes","blaat_tiles")."</option>";
    echo "<option value='0' ";
    if (get_option(bstiles_showexcerpt)==0) echo " selected ";
    echo ">".__("No","blaat_tiles")."</option>";
    echo '</td></tr>';


    echo '<tr><th>'. __("Image Size","blaat_tiles") .'</th><td>';
    echo "<select name='bstiles_imagesize'>";
    echo "<option value='thumbnail' ";
    if (get_option(bstiles_imagesize)=='thumbnail') echo " selected ";
    echo ">".__("thumbnail", "blaat_tiles")."</option>";
    echo "<option value='medium' ";
    if (get_option(bstiles_imagesize)=='medium') echo " selected ";
    echo ">".__("medium", "blaat_tiles")."</option>";
    echo "<option value='large' ";
    if (get_option(bstiles_imagesize)=='large') echo " selected ";
    echo ">".__("large", "blaat_tiles")."</option>";
    echo "<option value='cover' ";
    if (get_option(bstiles_imagesize)=='cover') echo " selected ";
    echo ">".__("cover", "blaat_tiles")."</option>";
    echo "<option value='none' ";
    if (get_option(bstiles_imagesize)=='none') echo " selected ";
    echo ">".__("none", "blaat_tiles")."</option>";
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

    echo '<tr><th>'. __("Enable Pagination","blaat_tiles") .'</th><td>';
    echo "<select name='bstiles_paginate'>";
    echo "<option value='1' ";
    if (get_option(bstiles_paginate)==1) echo " selected ";
    echo ">".__("Yes","blaat_tiles")."</option>";
    echo "<option value='0' ";
    if (get_option(bstiles_paginate)==0) echo " selected ";
    echo ">".__("No","blaat_tiles")."</option>";
    echo '</td></tr>';

    echo '<tr><th>'. __("Show Archive","blaat_tiles") .'</th><td>';
    echo "<select name='bstiles_archive'>";
    echo "<option value='1' ";
    if (get_option(bstiles_archive)==1) echo " selected ";
    echo ">".__("Yes","blaat_tiles")."</option>";
    echo "<option value='0' ";
    if (get_option(bstiles_archive)==0) echo " selected ";
    echo ">".__("No","blaat_tiles")."</option>";
    echo '</td></tr>';

    echo '</table><input name="Submit" type="submit" value="';
    echo  esc_attr_e('Save Changes' , "blaat_tiles") ;
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
function blaat_generate_tile($url, $title, $excerpt, $thumbnail, $bg){
    $id="blah".uniqid();
    echo "<a href='$url'>";
    echo "<div class='bs-tile' id='$id'><div class='bs-tile-title'>$title</div>";
    echo "<div class='bs-tile-thumbnail-and-excerpt-container'>";
    if ($thumbnail!="none") echo "<img class='bs-tile-thumbnail' src='$thumbnail'>";
    if ($excerpt!="") echo "<div class='bs-tile-excerpt'>$excerpt</div>";
    echo "</div></div></a>";
    if ($bg!="none"){
      echo "<style>#$id  { background-size: cover; background: url($bg) no-repeat center center;}</style>";
    }
}

//----------------------------------------------------------------------------
function bstiles_display($atts, $content, $tag){
  bstiles_generate_css();
  echo "<div class='bs-tiles'>";
  $tilecount          = get_option( 'bstiles_tilecount' );
  $imagesize          = get_option( 'bstiles_imagesize' );
  $paginate           = get_option( 'bstiles_paginate' );
  $archive            = get_option( 'bstiles_archive' );

  $offset = 0;
  if (isset($_GET['offset']))   if (is_numeric($_GET['offset'])) $offset=$_GET['offset'];


  //category
  $args = array( 'posts_per_page'   => $tilecount ,
                 'post_status'      => 'publish',
                 'orderby'          => 'post_date',
                 'offset'           => $offset );

  if (isset($atts['cat'])) $args['category']=$atts['cat'];

  $postslist = get_posts( $args );
  foreach ( $postslist as $post ) {
                setup_postdata( $post );
                $title = get_the_title($post->ID);
                $excerpt= "";
		if (get_option(bstiles_showexcerpt)) $excerpt =  get_the_excerpt();
                $url = get_permalink($post->ID ); 
	

		if ($imagesize=="cover"){	
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),"large");
			$bg=$image[0];
			$thumbnail="none";
		} else
			
		if ('none'!=$imagesize && has_post_thumbnail($post->ID)  ) {
		  //$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(150,150) ); 
        	  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $imagesize);
 		  $thumbnail=$image[0];
		  $bg="none";
		}
		else $thumbnail="none";
	
	blaat_generate_tile($url,$title,$excerpt,$thumbnail,$bg);
		wp_reset_postdata();
  }

  if ($paginate || $archive) {
    echo "<div id='bs-tiles-nav'>";

    if ($paginate) {
      $prev = $offset-$tilecount;
      echo "<a href='?offset=" . $prev ."'>". __("Previous", "blaat_tiles") ."</a>";      
    }
    if ($archive) {
        if (isset($atts['cat'])) {
        $url = get_category_link( $atts['cat'] );
      } else {
        $url = "?post_type=post";
      }
      $url =  esc_url($url);
      echo "<a href='$url'>". __("Archive", "blaat_tiles") ."</a>";
    }  
    if ($paginate) {
      $next = $offset+$tilecount;
      echo "<a href='?offset=" . $next ."'>" .  __("Next", "blaat_tiles")  . "</a>";
    }  
  echo "</div>";
  }
  echo "</div>";

}
//----------------------------------------------------------------------------
function bstiles_register_options(){
  register_setting( 'blaat_tiles', 'bstiles_title_fgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_title_bgcolour' );
  register_setting( 'blaat_tiles', 'bstiles_title_height' );
  register_setting( 'blaat_tiles', 'bstiles_title_padding' );
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
  register_setting( 'blaat_tiles', 'bstiles_paginate' );
  register_setting( 'blaat_tiles', 'bstiles_archive' );
  register_setting( 'blaat_tiles', 'bstiles_showexcerpt' );
  register_setting( 'blaat_tiles', 'bstiles_imagesize' );

}
//----------------------------------------------------------------------------
function bstiles_generate_css(){
  $title_fgcolour     = get_option( 'bstiles_title_fgcolour' );
  $title_bgcolour     = get_option( 'bstiles_title_bgcolour' );
  $title_height       = get_option( 'bstiles_title_height' );
  $title_padding      = get_option( 'bstiles_title_padding' );
  $excerpt_fgcolour   = get_option( 'bstiles_excerpt_fgcolour' );
  $excerpt_bgcolour   = get_option( 'bstiles_excerpt_bgcolour' );
  $tile_bgcolour      = get_option( 'bstiles_tile_bgcolour' );
  $tile_width         = get_option( 'bstiles_tile_width' );
  $tile_height        = get_option( 'bstiles_tile_height' );
  $tile_corner        = get_option( 'bstiles_tile_corner' );
  $tile_margin        = get_option( 'bstiles_tile_margin' );
  $tiles_margin_left  = get_option( 'bstiles_tiles_margin_left' );
  $tiles_margin_right = get_option( 'bstiles_tiles_margin_right' );


  if ($title_height) {
      echo "<style> 
     .bs-tile-title {
        height : ".$title_height."px;
        overflow : hidden;        
      }
    </style>";
    }

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

      .bs-tile-title {
        background-color: $title_bgcolour;
        color: $title_fgcolour;
        padding: ".$title_padding."px;
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

      #bs-tiles-nav {
        text-align: center;
        display: block;
        width: 100%;
      }

      #bs-tiles-nav a {
        display: inline-block;
        background-color: $title_bgcolour;
        color: $title_fgcolour;
        width: 100px;
        height: 25px;
        border:$title_bgcolour 1px solid;
        margin: ".$tile_margin."px;
      }
      </style>";

  $imagesize = get_option("bstiles_imagesize");
  $showexcerpt = get_option("bstiles_showexcerpt");
  if ($showexcerpt) {
    $extrastyle .= "
      .bs-tile-thumbnail {
       float:left;
       margin:10px;
       margin-bottom:0px;
    }";
  } else {
    $lineheight= $tile_height -  $tile_corner ;
    $extrastyle .= "
      .bs-tile-thumbnail-and-excerpt-container{
        line-height: ".$lineheight."px;
        text-align:center;
      }
      .bs-tile-thumbnail {
      margin: auto;
      display:inline-block;
      vertical-align: middle;
      }";
  } 
  
  if ($imagesize=="none") 
    $extrastyle .= "
      .bs-tile-thumbnail {
      display:none;
      }";
  else 
  if ($imagesize=="thumbnail") 
    $extrastyle .= "
      .bs-tile-thumbnail {
      max-width: 150px;
      max-height: 150px;
      }"; 
  if ($imagesize=="medium") 
    $extrastyle .= "
      .bs-tile-thumbnail {
      max-width: 300px;
      max-height: 300px;
      }";
  else
  if ($imagesize=="large")   
    $extrastyle .= "
      .bs-tile-thumbnail {
      max-width: 640px;
      max-height: 640px;
      }";
  else
    if ($imagesize=="cover")
    $extrastyle .= "
      .bs-tile-thumbnail {
      height:auto;
      width:auto;
      min-width: 100%;
      min-height: 100%;
      
      }";
  echo "<style>$extrastyle</style>";
  }
add_shortcode( 'bstiles', 'bstiles_display' );

//wp_register_style("blaat_tiles" , plugin_dir_url(__FILE__) . "css/bs-tiles.css");
//wp_enqueue_style( "blaat_tiles");


?>
