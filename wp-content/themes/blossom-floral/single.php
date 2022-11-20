<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blossom_Floral
 */

get_header(); ?>
<div class="page-grid">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
        
        <?php
        /**
         * @hooked blossom_floral_author        - 15
         * @hooked blossom_floral_navigation    - 20 
         * @hooked blossom_floral_related_posts - 30
         * @hooked blossom_floral_comment       - 40
        */
        do_action( 'blossom_floral_after_post_content' );
        ?>
        
	</div><!-- #primary -->

    <?php get_sidebar(); ?>

</div><!-- #page-grid -->
<?php
get_footer();
