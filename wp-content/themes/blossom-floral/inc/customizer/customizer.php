<?php
/**
 * Blossom Floral Theme Customizer
 *
 * @package Blossom_Floral
 */

/**
 * Requiring customizer panels & sections
*/

$blossom_floral_sections     = array( 'home', 'general', 'info', 'site', 'footer', 'layout', 'appearance' );

foreach( $blossom_floral_sections as $section ){
    require get_template_directory() . '/inc/customizer/' . $section . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blossom_floral_customize_preview_js() {
	wp_enqueue_script( 'blossom-floral-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), BLOSSOM_FLORAL_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'blossom_floral_customize_preview_js' );

function blossom_floral_customize_script(){

	$array = array(
        'flushFonts'        => wp_create_nonce( 'blossom-floral-local-fonts-flush' ),
    );

    wp_enqueue_style( 'blossom-floral-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), BLOSSOM_FLORAL_THEME_VERSION );
    wp_enqueue_script( 'blossom-floral-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), BLOSSOM_FLORAL_THEME_VERSION, true );

    wp_localize_script( 'blossom-floral-customize', 'blossom_floral_cdata', $array );

    wp_localize_script( 'blossom-floral-repeater', 'blossom_floral_customize',
		array(
			'nonce' => wp_create_nonce( 'blossom_floral_customize_nonce' )
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'blossom_floral_customize_script' );

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-recommend.php';

/**
 * Reset font folder
 *
 * @access public
 * @return void
 */
function blossom_floral_ajax_delete_fonts_folder() {
	// Check request.
	if ( ! check_ajax_referer( 'blossom-floral-local-fonts-flush', 'nonce', false ) ) {
		wp_send_json_error( 'invalid_nonce' );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_send_json_error( 'invalid_permissions' );
	}
	if ( class_exists( '\Blossom_Floral_WebFont_Loader' ) ) {
		$font_loader = new \Blossom_Floral_WebFont_Loader( '' );
		$removed = $font_loader->delete_fonts_folder();
		if ( ! $removed ) {
			wp_send_json_error( 'failed_to_flush' );
		}
		wp_send_json_success();
	}
	wp_send_json_error( 'no_font_loader' );
}
add_action( 'wp_ajax_blossom_floral_flush_fonts_folder', 'blossom_floral_ajax_delete_fonts_folder' );