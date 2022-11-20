<?php
/**
 * Blossom Floral Customizer Partials
 *
 * @package Blossom_Floral
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blossom_floral_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blossom_floral_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'blossom_floral_get_topbar_text' ) ) :
/**
 * Top bar notification text
*/
function blossom_floral_get_topbar_text(){
    return esc_html( get_theme_mod( 'notification_text' ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_topbar_button' ) ) :
/**
 * Top bar notification text
*/
function blossom_floral_get_topbar_button(){
    return esc_html( get_theme_mod( 'notification_label' ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_blog_text' ) ) :
/**
 * Blog title
*/
function blossom_floral_get_blog_text(){
    return esc_html( get_theme_mod( 'blog_text', __( 'From The Blog', 'blossom-floral' ) ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_blog_content' ) ) :
/**
 * Blog content
*/
function blossom_floral_get_blog_content(){
    return wp_kses_post( wpautop( get_theme_mod( 'blog_content' )));
}
endif;

if( ! function_exists( 'blossom_floral_get_search_title' ) ) :
/**
 * Search Page Title
*/
function blossom_floral_get_search_title(){
    return esc_html( get_theme_mod( 'search_title', __( 'Search Result For', 'blossom-floral' ) ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_related_portfolio_title' ) ) :
/**
 * Portfolio Related Projects Title
*/
function blossom_floral_get_related_portfolio_title(){
    return esc_html( get_theme_mod( 'related_portfolio_title', __( 'Related Projects', 'blossom-floral' ) ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_shop_title' ) ) :
/**
 * Display shop section title
*/
function blossom_floral_get_shop_title(){
    return esc_html( get_theme_mod( 'shop_section_title', __( 'My Shop', 'blossom-floral' ) ) );    
}
endif;

if( ! function_exists( 'blossom_floral_get_shop_btn_lbl' ) ) :
/**
 * Display blog readmore button
*/
function blossom_floral_get_shop_btn_lbl(){
    return esc_html( get_theme_mod( 'shop_btn_lbl', __( 'Go To Shop', 'blossom-floral' ) ) );    
}
endif;

if( ! function_exists( 'blossom_floral_get_shop_content' ) ) :
/**
 * Display blog readmore button
*/
function blossom_floral_get_shop_content(){
    return wp_kses_post( wpautop( get_theme_mod( 'shop_section_content', __( 'This option can be change from Customize > General Settings > Shop settings.', 'blossom-floral' ) ) ) );    
}
endif;

if( ! function_exists( 'blossom_floral_get_read_more' ) ) :
/**
 * Display blog readmore button
*/
function blossom_floral_get_read_more(){
    return esc_html( get_theme_mod( 'read_more_text', __( 'READ THE ARTICLE', 'blossom-floral' ) ) );    
}
endif;

if( ! function_exists( 'blossom_floral_get_author_title' ) ) :
/**
 * Display blog readmore button
*/
function blossom_floral_get_author_title(){
    return esc_html( get_theme_mod( 'author_title', __( 'About The Author', 'blossom-floral' ) ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function blossom_floral_get_related_title(){
    return esc_html( get_theme_mod( 'related_post_title', __( 'You may also like...', 'blossom-floral' ) ) );
}
endif;

if( ! function_exists( 'blossom_floral_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function blossom_floral_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'blossom-floral' );
        echo date_i18n( esc_html__( 'Y', 'blossom-floral' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'blossom-floral' );
    }
    echo '</span>'; 
}
endif;