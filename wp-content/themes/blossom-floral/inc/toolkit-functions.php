<?php
/**
 * Toolkit Filters
 *
 * @package Blossom_Floral
 */

if( ! function_exists( 'blossom_floral_pro_feature_image_size' ) ) :
    function blossom_floral_pro_feature_image_size(){
        return 'blossom-floral-featured-section';
    }
endif;
add_filter( 'bttk_it_img_size', 'blossom_floral_pro_feature_image_size' );