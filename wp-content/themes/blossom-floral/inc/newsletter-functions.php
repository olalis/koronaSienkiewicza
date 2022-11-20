<?php
/**
 * Blossomthemes Email Newsletter Functions.
 *
 * @package Blossom_Floral
 */

if( ! function_exists( 'blossom_floral_add_inner_div' ) ) :
    function blossom_floral_add_inner_div(){
        return true;
    }
endif;
add_filter( 'bt_newsletter_widget_inner_wrap_display', 'blossom_floral_add_inner_div' );

if( ! function_exists( 'blossom_floral_start_inner_div' ) ) :
    function blossom_floral_start_inner_div(){
        echo '<div class="container">';
    }
endif;
add_action( 'bt_newsletter_widget_inner_wrap_start', 'blossom_floral_start_inner_div' );

if( ! function_exists( 'blossom_floral_end_inner_div' ) ) :
    function blossom_floral_end_inner_div(){
        echo '</div>';
    }
endif;
add_action( 'bt_newsletter_widget_inner_wrap_close', 'blossom_floral_end_inner_div' );

if( ! function_exists( 'blossom_floral_shortcode_add_inner_div' ) ) :
    function blossom_floral_shortcode_add_inner_div(){
        return true;
    }
endif;
add_filter( 'bt_newsletter_shortcode_inner_wrap_display', 'blossom_floral_shortcode_add_inner_div' );

if( ! function_exists( 'blossom_floral_shortcode_start_inner_div' ) ) :
    function blossom_floral_shortcode_start_inner_div(){
        echo '<div class="container">';
    }
endif;
add_action( 'bt_newsletter_shortcode_inner_wrap_start', 'blossom_floral_shortcode_start_inner_div' );

if( ! function_exists( 'blossom_floral_shortcode_end_inner_div' ) ) :
    function blossom_floral_shortcode_end_inner_div(){
        echo '</div>';
    }
endif;
add_action( 'bt_newsletter_shortcode_inner_wrap_close', 'blossom_floral_shortcode_end_inner_div' );