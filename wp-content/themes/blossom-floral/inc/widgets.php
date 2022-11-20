<?php
/**
 * Blossom Floral Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Blossom_Floral
 */

function blossom_floral_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'blossom-floral' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'blossom-floral' ),
        ),
        'featured'   => array(
            'name'        => __( 'Featured Area Section', 'blossom-floral' ),
            'id'          => 'featured', 
            'description' => __( 'Add "Blossom: Image Text" widget for featured area section. The recommended image size for this section is 360px by 486px in JPG format.', 'blossom-floral' ),
        ),
        'about'   => array(
            'name'        => __( 'About Section', 'blossom-floral' ),
            'id'          => 'about', 
            'description' => __( 'Add "Blossom: Featured Page" widget for about section.', 'blossom-floral' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'blossom-floral' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'blossom-floral' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'blossom-floral' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'blossom-floral' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'blossom-floral' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'blossom-floral' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'blossom-floral' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'blossom-floral' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }
}
add_action( 'widgets_init', 'blossom_floral_widgets_init' );