<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blossom_Floral
 */
    
    /**
     * After Content
     * 
     * @hooked blossom_floral_content_end - 20
    */
    do_action( 'blossom_floral_before_footer' );
    
    /**
     * Before Footer
     * 
     * @hooked blossom_floral_bottom_shop_section  - 10
     * @hooked blossom_floral_newsletter           - 20
    */
    do_action( 'blossom_floral_footer_start' );

    /**
     * Footer
     * @hooked blossom_floral_footer_instagram_section - 15
     * @hooked blossom_floral_footer_start             - 20
     * @hooked blossom_floral_footer_top               - 30
     * @hooked blossom_floral_footer_bottom            - 40
     * @hooked blossom_floral_footer_end               - 50
    */
    do_action( 'blossom_floral_footer' );
    
    /**
     * After Footer
     * 
     * @hooked blossom_floral_back_to_top - 15
     * @hooked blossom_floral_page_end    - 20
    */
    do_action( 'blossom_floral_after_footer' );

    wp_footer(); ?>

</body>
</html>
