<?php
/**
 * Blossom Floral Footer Setting
 *
 * @package Blossom_Floral
 */

function blossom_floral_customize_register_footer( $wp_customize ) {
    
    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => __( 'Footer Settings', 'blossom-floral' ),
            'priority'   => 199,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label'   => __( 'Footer Copyright Text', 'blossom-floral' ),
            'section' => 'footer_settings',
            'type'    => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector' => '.site-info .copyright',
        'render_callback' => 'blossom_floral_get_footer_copyright',
    ) );

    $wp_customize->add_setting(
        'footer_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control( 
            $wp_customize, 
            'footer_bg_image', 
            array(
                'label'      => __( 'Background Image', 'blossom-floral' ),
                'description'=> __( 'Choose background Image of your choice for footer section. The recommended size for image is 1920px by 566px in PNG format.', 'blossom-floral' ),
                'section'    => 'footer_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'footer_top_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control( 
            $wp_customize, 
            'footer_top_image', 
            array(
                'label'      => __( 'Footer Secondary Image', 'blossom-floral' ),
                'description'=> __( 'This will appear at the top right corner of footer section. The recommended size for image is 222px by 238px in PNG format.', 'blossom-floral' ),
                'section'    => 'footer_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'footer_bottom_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control( 
            $wp_customize, 
            'footer_bottom_image', 
            array(
                'label'      => __( 'Footer Tertiary Image', 'blossom-floral' ),
                'description'=> __( 'This will appear at the bottom left corner of footer section. The recommended size for image is 95px by 66px in PNG format.', 'blossom-floral' ),
                'section'    => 'footer_settings',
            )
        )
    );
        
}
add_action( 'customize_register', 'blossom_floral_customize_register_footer' );