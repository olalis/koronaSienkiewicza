<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Floral
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
	<?php 
        /**
         * @hooked blossom_floral_post_thumbnail - 10
        */
        do_action( 'blossom_floral_before_post_entry_content' );

        echo '<div class="content-wrap">';

        /**
         * @hooked blossom_floral_entry_header  - 10
         * @hooked blossom_floral_entry_content - 15
         * @hooked blossom_floral_entry_footer  - 20
        */
        do_action( 'blossom_floral_post_entry_content' );
        
        echo '</div>';
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
