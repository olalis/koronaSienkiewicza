<?php
/**
 * Active Callback
 * 
 * @package Blossom_Floral
*/

function blossom_floral_banner_ac( $control ){
    $banner      = $control->manager->get_setting( 'ed_banner_section' )->value();
    $slider_type = $control->manager->get_setting( 'slider_type' )->value();
    $control_id  = $control->id;
    
    if ( $control_id == 'slider_type' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'include_repetitive_posts' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_auto' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_loop' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_caption' && $banner == 'slider_banner' ) return true;             
    if ( $control_id == 'slider_cat' && $banner == 'slider_banner' && $slider_type == 'cat' ) return true;
    if ( $control_id == 'no_of_slides' && $banner == 'slider_banner' && $slider_type == 'latest_posts' ) return true;
    if ( $control_id == 'slider_animation' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'banner_hr' && $banner == 'slider_banner' ) return true;
    
    return false;
}

/**
 * Active Callback for post/page
*/
function blossom_floral_post_page_ac( $control ){
    
    $ed_related    = $control->manager->get_setting( 'ed_related' )->value();
    $ed_comment    = $control->manager->get_setting( 'ed_comments' )->value();
    $control_id    = $control->id;
    
    if ( $control_id == 'related_post_title' && $ed_related == true ) return true;
    if ( $control_id == 'toggle_comments' && $ed_comment == true ) return true;
    
    return false;
}

if( ! function_exists( 'blossom_floral_shop_sec_ac' ) ) :
/**
 * Active Callback for Shop Section
*/
function blossom_floral_shop_sec_ac( $control ){
    $shop_bg_type = $control->manager->get_setting( 'shop_bg' )->value();
    $product_type = $control->manager->get_setting( 'product_type' )->value();
    $control_id   = $control->id;
    
    if( $control_id == 'shop_bg_image' && $shop_bg_type == 'image' ) return true;
    if( $control_id == 'shop_bg_color' && $shop_bg_type == 'color' ) return true;
    if( $control_id == 'selected_products' && $product_type == 'custom' ) return true;
    
    return false;
}
endif;

/**
 * Active Callback for local fonts
*/
function blossom_floral_ed_localgoogle_fonts(){
    $ed_localgoogle_fonts = get_theme_mod( 'ed_localgoogle_fonts' , false );

    if( $ed_localgoogle_fonts ) return true;
    
    return false; 
}