<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Floral
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php the_title( '<h1 class="page-title">', '</h1>' );
    
        /**
         * Post Thumbnail
         * 
         * @hooked blossom_floral_post_thumbnail
        */
        do_action( 'blossom_floral_before_page_entry_content' );
    
        /**
         * Entry Content
         * 
         * @hooked blossom_floral_entry_content - 15
         * @hooked blossom_floral_entry_footer  - 20
        */
        do_action( 'blossom_floral_page_entry_content' );    
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
