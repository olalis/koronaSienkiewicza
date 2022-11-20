<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blossom_Floral
 */
    /**
     * Doctype Hook
     * 
     * @hooked blossom_floral_doctype
    */
    do_action( 'blossom_floral_doctype' );
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<?php 
    /**
     * Before wp_head
     * 
     * @hooked blossom_floral_head
    */
    do_action( 'blossom_floral_before_wp_head' );
    
    wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php
    wp_body_open();
    
    /**
     * Before Header
     * 
     * @hooked blossom_floral_page_start - 20 
    */
    do_action( 'blossom_floral_before_header' );
    
    /**
     * Header
     * 
     * @hooked blossom_floral_instagram_section   - 15
     * @hooked blossom_floral_header              - 20     
    */
    do_action( 'blossom_floral_header' );
    
    /**
     * Before Content
     * 
     * @hooked blossom_floral_banner             - 15
     * @hooked blossom_floral_featured_section   - 20
     * @hooked blossom_floral_about_section      - 25
    */
    do_action( 'blossom_floral_after_header' );
    
    /**
     * Content
     * 
     * @hooked blossom_floral_content_start
    */
    do_action( 'blossom_floral_content' );