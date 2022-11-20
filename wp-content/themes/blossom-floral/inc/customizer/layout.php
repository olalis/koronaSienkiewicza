<?php
/**
 * Blossom Floral Layout Settings
 *
 * @package Blossom_Floral
 */

function blossom_floral_customize_register_layout( $wp_customize ) {
	
    /** Home Page Layout Settings */
    $wp_customize->add_section(
        'layout_settings',
        array(
            'title'       => __( 'Layout Settings', 'blossom-floral' ),
            'description' => __( 'Change Page, Post and General sidebar layout from here.', 'blossom-floral' ),
            'capability'  => 'edit_theme_options',
            'priority'    => 55,
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'page_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_floral_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Floral_Radio_Image_Control(
			$wp_customize,
			'page_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => __( 'Page Sidebar Layout', 'blossom-floral' ),
				'description' => __( 'This is the general sidebar layout for pages. You can override the sidebar layout for individual page in respective page.', 'blossom-floral' ),
				'choices'	  => array(
					'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'centered'      => esc_url( get_template_directory_uri() . '/images/1cc.jpg' ),
					'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
				)
			)
		)
	);
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'post_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_floral_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Floral_Radio_Image_Control(
			$wp_customize,
			'post_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => __( 'Post Sidebar Layout', 'blossom-floral' ),
				'description' => __( 'This is the general sidebar layout for posts. You can override the sidebar layout for individual post in respective post.', 'blossom-floral' ),
				'choices'	  => array(
					'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'centered'      => esc_url( get_template_directory_uri() . '/images/1cc.jpg' ),
					'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
				)
			)
		)
	);
    
    /** Default Sidebar layout */
    $wp_customize->add_setting( 
        'layout_style', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_floral_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Floral_Radio_Image_Control(
			$wp_customize,
			'layout_style',
			array(
				'section'	  => 'layout_settings',
				'label'		  => __( 'Default Sidebar Layout', 'blossom-floral' ),
				'description' => __( 'This is the general sidebar layout for whole site.', 'blossom-floral' ),
				'choices'	  => array(
					'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
				)
			)
		)
	);
    
}
add_action( 'customize_register', 'blossom_floral_customize_register_layout' );