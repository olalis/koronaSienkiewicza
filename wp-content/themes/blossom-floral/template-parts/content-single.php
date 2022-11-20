<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Floral_Pro
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php 
        blossom_floral_article_meta();
        
        echo '<div class="content-wrap">';

        /**
         * 
         * @hooked blossom_floral_entry_content - 15
         * @hooked blossom_floral_entry_footer  - 20
        */
        do_action( 'blossom_floral_post_entry_content' );
        
        echo '</div>';
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
