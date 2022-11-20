<?php
/**
 * Blossom Floral Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Blossom_Floral
 */

if( ! function_exists( 'blossom_floral_doctype' ) ) :
/**
 * Doctype Declaration
*/
function blossom_floral_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'blossom_floral_doctype', 'blossom_floral_doctype' );

if( ! function_exists( 'blossom_floral_head' ) ) :
/**
 * Before wp_head 
*/
function blossom_floral_head(){ ?>
    <meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'blossom_floral_before_wp_head', 'blossom_floral_head' );

if( ! function_exists( 'blossom_floral_page_start' ) ) :
/**
 * Page Start
*/
function blossom_floral_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'blossom-floral' ); ?></a>
    <?php
}
endif;
add_action( 'blossom_floral_before_header', 'blossom_floral_page_start', 20 );

if( ! function_exists( 'blossom_floral_instagram_section' ) ) :
/**
 * Header Instagram Section
*/
function blossom_floral_instagram_section(){ 
    blossom_floral_instagram( true );
}
endif;
add_action( 'blossom_floral_header', 'blossom_floral_instagram_section', 15 );

if( ! function_exists( 'blossom_floral_header' ) ) :
/**
 * Header Start
*/
function blossom_floral_header(){ 

    $ed_social      = get_theme_mod('ed_social_links', false);
    $ed_search      = get_theme_mod( 'ed_header_search', false );
    $ed_cart        = get_theme_mod( 'ed_shopping_cart', false );
    $header_bg_img2 = get_theme_mod( 'header_bg_image_two' );
    $add_class      = ! empty($header_bg_img2) ? " header-img" : '';
    $add_class_two  = ( !$ed_social && !$ed_search && !$ed_cart ) ? " site-branding-only" : '';
    ?>

    <header id="masthead" class="site-header style-one<?php echo esc_attr( $add_class ); ?>" itemscope itemtype="http://schema.org/WPHeader">
        <div class="header-top">
            <div class="container">
                <div class="header-right">
                    <?php blossom_floral_secondary_navigation(); ?>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container<?php echo esc_attr( $add_class_two ); ?>">
                <?php if( $ed_social ) { ?>
                    <div class="header-left">
                        <?php blossom_floral_social_links(); ?>
                    </div>
                <?php } 
                blossom_floral_site_branding(); ?>
                <div class="header-right">
                    <?php 
                    blossom_floral_search();
                    blossom_floral_header_cart(); ?>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="container">
                <?php blossom_floral_primary_nagivation(); ?>
            </div>
        </div>
        <?php 
            blossom_floral_mobile_navigation();  
        ?>
    </header>
    <?php 
}
endif;
add_action( 'blossom_floral_header', 'blossom_floral_header', 20 );

if( ! function_exists( 'blossom_floral_banner' ) ) :
/**
 * Banner Section 
*/
function blossom_floral_banner(){
    $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
    $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' ); 
    $slider_cat     = get_theme_mod( 'slider_cat' );
    $posts_per_page = get_theme_mod( 'no_of_slides', 3 );    
    $ed_caption     = get_theme_mod( 'slider_caption', true );
    
    if( is_front_page() || is_home() ){ 
        
        if( $ed_banner == 'slider_banner' ){
            $args = array(
                'post_type'           => 'post',
                'post_status'         => 'publish',            
                'ignore_sticky_posts' => true,
            );
            
            if( $slider_type === 'cat' && $slider_cat ){
                $args['cat']            = $slider_cat; 
                $args['posts_per_page'] = -1;  
            }else{
                $args['posts_per_page'] = $posts_per_page;
            }
                
            $qry = new WP_Query( $args );
            
            if( $qry->have_posts() ){ ?>
                <div id="banner-section" class="site-banner slider-one">
                    <div class="banner-wrapper owl-carousel">
                        <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                            <div class="item">
                                <?php 
                                echo '<div class="banner-img-wrap"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">';
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( 'blossom-floral-slider', array( 'itemprop' => 'image' ) );    
                                    }else{ 
                                        blossom_floral_get_fallback_svg( 'blossom-floral-slider' );//fallback
                                    }
                                echo '</a></div>';
                                if( $ed_caption ){ 
                                    ?>  
                                    <div class="banner-caption">
                                        <?php 
                                            echo '<div class="entry-meta">';
                                                blossom_floral_category();
                                            echo '</div>';
                                            the_title( '<h2 class="banner-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                        ?>
                                    </div>
                                    <?php
                                } ?>
                            </div>
                        <?php } ?>                        
                    </div>
                </div>
                <?php
                wp_reset_postdata();
            }
        } 
    }    
}
endif;
add_action( 'blossom_floral_after_header', 'blossom_floral_banner', 15 );

if( ! function_exists( 'blossom_floral_featured_section' ) ) :
/**
 * Featured Section
 * 
*/
function blossom_floral_featured_section(){
                        
    if( ( is_front_page() || is_home() ) && is_active_sidebar( 'featured' ) ) { ?>
        <section id="featured_area" class="promo-section">
            <div class="container">                 
                <?php dynamic_sidebar( 'featured' ); ?>          
            </div>
        </section><!-- .feature-section --> 
    <?php }
}
endif;
add_action( 'blossom_floral_after_header', 'blossom_floral_featured_section', 20 );

if( ! function_exists( 'blossom_floral_about_section' ) ) :
/**
 * Featured Section
 * 
*/
function blossom_floral_about_section(){
                        
    if( ( is_front_page() || is_home() ) && is_active_sidebar( 'about' ) ) { ?>
        <section id="about_section" class="about-section">
            <div class="about-section-wrapper">
                <div class="about-section-bg-color">
                    <div class="container">                
                        <?php dynamic_sidebar( 'about' ); ?> 
                    </div>
                </div>         
            </div>
        </section><!-- .feature-section --> 
    <?php }
}
endif;
add_action( 'blossom_floral_after_header', 'blossom_floral_about_section', 25 );

if( ! function_exists( 'blossom_floral_footer_instagram_section' ) ) :
/**
 * Bottom Instagram
*/
function blossom_floral_footer_instagram_section(){ 
    if( blossom_floral_is_btif_activated() ){
        blossom_floral_instagram( false );
    }
}
endif;
add_action( 'blossom_floral_footer', 'blossom_floral_footer_instagram_section', 15 );

if( ! function_exists( 'blossom_floral_content_start' ) ) :
/**
 * Content Start
*/
function blossom_floral_content_start(){ 
    global $post;
    $ed_featured        = get_theme_mod( 'ed_featured_image', true );
    $ed_crop_single     = get_theme_mod( 'ed_crop_single', false );
    $ed_post_date       = get_theme_mod( 'ed_post_date', false );

    if( has_post_thumbnail() ){
        $thumbnail_class = '';
    }else{
        $thumbnail_class = 'no-thumbnail';
    } 

    echo '<div id="content" class="site-content">'; 
    if( ! is_front_page() ) echo '<div class="page-header ' . $thumbnail_class . '">';
    
        if ( is_404() ) return;   
        
        if( ! is_front_page() ){
            echo '<div class="breadcrumb-wrapper">';      
                //Breadcrumb
                blossom_floral_breadcrumb();
            echo '</div>';
        }

        if ( is_home() && ! is_front_page() ){ 
            echo '<h1 class="page-title">';
            single_post_title();
            echo '</h1>';
        }

        if ( is_single() && ! ( blossom_floral_is_woocommerce_activated() && is_product() ) && !is_singular('blossom-portfolio') ) { ?>

            <div class="container">
                <header class="entry-header">
                    <div class="entry-meta">
                        <?php blossom_floral_category(); ?>
                    </div>
                        <?php the_title( '<h1 class="entry-title">','</h1>' ); ?>
                    <div class="entry-meta">
                        <?php if ( ! $ed_post_date ) blossom_floral_posted_on(); 
                        if( is_singular( 'post' ) ) blossom_floral_estimated_reading_time( get_post( get_the_ID() )->post_content ); ?>
                    </div>
                    <div class="site-author">
                        <figure class="author-img">
                            <?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), 70, '' , 'avatar' ); ?>
                            <span class="byline">
                                <span>
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ); ?>" class="url fn">
                                        <?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?>
                                    </a>
                                </span>
                            </span>
                        </figure>
                    </div>
                </header>
            </div>
            <?php
            if ( $ed_featured && has_post_thumbnail() ) { 
                echo '<div class="post-thumbnail">';
                    if( $ed_crop_single ){
                        the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
                    }else{
                        the_post_thumbnail( 'blossom-floral-single', array( 'itemprop' => 'image' ) );
                    }
                echo '</div>';
            }
        }

    if( ! is_front_page() ) echo '</div>'; ?>
    <div class="container">

    <?php  
}
endif;
add_action( 'blossom_floral_content', 'blossom_floral_content_start' );

if( ! function_exists( 'blossom_floral_page_header' ) ) :
/**
 * Content Start
 *   
*/
function blossom_floral_page_header(){ ?>    
    <?php        
        if ( is_home() ){ 
            $blog_text    = get_theme_mod( 'blog_text', __( 'From The Blog', 'blossom-floral' ) );
            $blog_content = get_theme_mod( 'blog_content' );
            echo '<header class="section-header"><div class="container">';
            if( $blog_text ) echo '<h2 class="section-title blog-title">' . esc_html( $blog_text) . '</h2>';
            if( $blog_content ) echo '<div class="section-desc blog-content">' . wp_kses_post( wpautop( $blog_content ) ). '</div>';
            echo '</div></header>';
        }
        
        if( is_archive() ){              
        
            if( is_author() ){
                $author_title       = get_the_author_meta( 'display_name' );
                $author_description = get_the_author_meta( 'description' );
                $about_author       = get_theme_mod( 'author_title', __( 'About The Author', 'blossom-floral' ) ); ?>
                <div class="page-header__content-wrapper">
                    <div class="author-section">
                        <h3 class="author-section-title">
                            <?php echo esc_html( $about_author ); ?>
                        </h3>
                        <div class="inner-author-section">
                            <div class="author-img-title-wrap">
                                <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 130, '', 'avatar' ); ?></figure>
                                <div class="author-title-wrap">
                                    <?php echo '<h1 class="author-name">' . esc_html( $author_title ) . '</h1>'; ?>
                                </div>
                            </div>
                            <?php if( $author_description ) : ?>
                                <div class="author-content-wrap">
                                    <?php echo '<div class="author-content">' . wp_kses_post( wpautop( $author_description ) ) . '</div>'; ?>      
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php blossom_floral_posts_per_page_count(); ?>
                    </div>
                </div>
                <?php 
            } else {
                echo '<div class="page-header__content-wrapper">';
                the_archive_title();
                the_archive_description( '<div class="archive-description">', '</div>' );
                blossom_floral_posts_per_page_count();
                echo '</div>';
            }
        }
        
        if( is_search() ){ 
            $search_title = get_theme_mod( 'search_title', __( 'Search Result For', 'blossom-floral' ) );
            echo '<div class="page-header__content-wrapper">';
            echo '<h1 class="page-title">' . esc_html( $search_title ) . '</h1>';
            get_search_form();
            blossom_floral_posts_per_page_count();
            echo '</div>';  
        }
    ?>
<?php }
endif;
add_action( 'blossom_floral_before_posts_content', 'blossom_floral_page_header', 10 );

if( ! function_exists( 'blossom_floral_entry_header' ) ) :
/**
 * Entry Header
*/
function blossom_floral_entry_header(){ 

    if( ! is_single() ){
        echo '<header class="entry-header">';  

        echo '<div class="entry-meta">';
        blossom_floral_category();
        echo '</div>';           

        if( is_home() ){
            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
        } else {
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }

        echo '<div class="entry-meta">';
        echo get_avatar( get_the_author_meta( 'ID' ), 30, '', 'avatar' );
        blossom_floral_posted_by();
        blossom_floral_posted_on();
        echo '</div>';

        echo '</header>';
    }     
}
endif;
add_action( 'blossom_floral_post_entry_content', 'blossom_floral_entry_header', 10 );

if ( ! function_exists( 'blossom_floral_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function blossom_floral_post_thumbnail() {
    
    $image_size     = 'thumbnail'; 
    $ed_crop_blog   = get_theme_mod( 'ed_crop_blog', false );
    $sidebar        = blossom_floral_sidebar();
    
    if( is_home() || is_archive() || is_search() ){
       
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
        if( has_post_thumbnail() ){
            if( $ed_crop_blog ){
                the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
            }else{
                the_post_thumbnail( 'blossom-floral-blog-home', array( 'itemprop' => 'image' ) );    
            }
        }else{
            blossom_floral_get_fallback_svg( 'blossom-floral-blog-home' );//fallback
        }
        echo '</a></figure>';
    }elseif( is_singular() ){
        $image_size = ( $sidebar ) ? 'blossom-floral-with-sidebar' : 'full';
        
        if( has_post_thumbnail() ){
            echo '<div class="post-thumbnail">';
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
            echo '</div>';    
        } 
    }
}
endif;
add_action( 'blossom_floral_before_page_entry_content', 'blossom_floral_post_thumbnail' );
add_action( 'blossom_floral_before_post_entry_content', 'blossom_floral_post_thumbnail', 10 );

if( ! function_exists( 'blossom_floral_entry_content' ) ) :
/**
 * Entry Content
*/
function blossom_floral_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); ?>
    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blossom-floral' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'blossom_floral_page_entry_content', 'blossom_floral_entry_content', 15 );
add_action( 'blossom_floral_post_entry_content', 'blossom_floral_entry_content', 15 );

if( ! function_exists( 'blossom_floral_entry_footer' ) ) :
/**
 * Entry Footer
*/
function blossom_floral_entry_footer(){ 
    $readmore = get_theme_mod( 'read_more_text', __('READ THE ARTICLE', 'blossom-floral') ); ?>
	<footer class="entry-footer">
		<?php
			if( is_single() ){
			    blossom_floral_tag();
			}
            
            if( is_home()|| is_archive() || is_search() ){
                echo '<div class="button-wrap"><a href="' . esc_url( get_the_permalink() ) . '" class="btn-link">' . esc_html( $readmore ) . '</a></div>';    
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'blossom-floral' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'blossom_floral_page_entry_content', 'blossom_floral_entry_footer', 20 );
add_action( 'blossom_floral_post_entry_content', 'blossom_floral_entry_footer', 20 );

if( ! function_exists( 'blossom_floral_navigation' ) ) :
/**
 * Navigation
*/
function blossom_floral_navigation(){
    if( is_singular() ){
        $next_post  = get_next_post();
        $prev_post  = get_previous_post();
        $image_size = 'blossom-floral-related';

        if( $prev_post || $next_post ){ ?>            
            <nav class="post-navigation pagination" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'blossom-floral' ); ?></h2>
                <div class="nav-links">
                    <?php if( $prev_post ){ ?>
                        <div class="nav-previous">
                            <article class="post">
                                <figure class="post-thumbnail">
                                    <?php
                                    $prev_img = get_post_thumbnail_id( $prev_post->ID ); ?>
                                    <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                                        <?php if( $prev_img ){
                                            $prev_url = wp_get_attachment_image_url( $prev_img, $image_size );
                                            echo '<img src="' . esc_url( $prev_url ) . '" alt="' . the_title_attribute( 'echo=0', $prev_post ) . '">';                                        
                                        }else{
                                            blossom_floral_get_fallback_svg( $image_size );
                                        }
                                        ?>
                                    </a>
                                </figure>
                                <div class="content-wrap">
                                    <div class="entry-meta">
                                        <span class="cat-links" itemprop="about">
                                            <?php
                                            $prev_categories = get_the_category( $prev_post->ID ); 
                                            foreach( $prev_categories as $prev_cat ){
                                                echo '<a href="' . esc_url( get_category_link( $prev_cat->term_id ) ) . '">' . esc_html( $prev_cat->name ) . '</a>';
                                            } ?>
                                        </span> 
                                    </div>
                                    <header class="entry-header">
                                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                                            <h3 class="entry-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h3>
                                        </a>
                                    </header>
                                </div>
                            </article>
                            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                                <span class="meta-nav"><?php esc_html_e( 'Previous', 'blossom-floral' ); ?></span>
                            </a>
                        </div>
                    <?php }
                    if( $next_post ){ ?>
                    <div class="nav-next">
                        <article class="post">
                            <figure class="post-thumbnail">
                                <?php
                                $next_img = get_post_thumbnail_id( $next_post->ID ); ?>
                                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
                                    <?php if( $next_img ){
                                        $next_url = wp_get_attachment_image_url( $next_img, $image_size );
                                        echo '<img src="' . esc_url( $next_url ) . '" alt="' . the_title_attribute( 'echo=0', $next_post ) . '">';                                        
                                    }else{
                                        blossom_floral_get_fallback_svg( $image_size );
                                    }
                                    ?>
                                </a>
                            </figure>
                            <div class="content-wrap">
                                <div class="entry-meta">
                                    <span class="cat-links" itemprop="about">
                                        <?php
                                        $next_categories = get_the_category( $next_post->ID ); 
                                        foreach( $next_categories as $next_cat ){
                                            echo '<a href="' . esc_url( get_category_link( $next_cat->term_id ) ) . '">' . esc_html( $next_cat->name ) . '</a>';
                                        } ?>
                                    </span> 
                                </div>
                                <header class="entry-header">
                                    <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
                                        <h3 class="entry-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h3>
                                    </a>
                                </header>
                            </div>
                        </article>
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="prev">
                            <span class="meta-nav"><?php esc_html_e( 'Next', 'blossom-floral' ); ?></span>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </nav>        
            <?php
        }
    }else{
        the_posts_pagination( array(
            'prev_text'          => __( 'Previous', 'blossom-floral' ),
            'next_text'          => __( 'Next', 'blossom-floral' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'blossom-floral' ) . ' </span>',
        ) );
    }
}
endif;
add_action( 'blossom_floral_after_post_content', 'blossom_floral_navigation', 20 );
add_action( 'blossom_floral_after_posts_content', 'blossom_floral_navigation', 10 );

if( ! function_exists( 'blossom_floral_author' ) ) :
/**
 * Author Section
*/
function blossom_floral_author(){ 
    $ed_author    = get_theme_mod( 'ed_author', false );
    $author_title = get_theme_mod( 'author_title', __( 'About Author', 'blossom-floral' ) );
    if( ! $ed_author && get_the_author_meta( 'description' ) ){ ?>
        <div class="author-section">
            <div class="inner-author-section">
                <div class="author-img-title-wrap">
                    <figure class="author-img">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 95, '', 'avatar' ); ?>
                    </figure>
                    <div class="author-title-wrap">
                        <?php 
                            if( $author_title ) echo '<h5 class="title">' . esc_html( $author_title ) . '</h5>'; 
                            blossom_floral_posted_by(); 
                        ?>
                    </div>
                </div>
                <div class="author-content">
                    <?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
                </div>
            </div>
        </div>
    <?php
    }
}
endif;
add_action( 'blossom_floral_after_post_content', 'blossom_floral_author', 15 );

if( ! function_exists( 'blossom_floral_related_posts' ) ) :
/**
 * Related Posts 
*/
function blossom_floral_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    if( $ed_related_post ){
        blossom_floral_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'blossom_floral_after_post_content', 'blossom_floral_related_posts', 30 );

if( ! function_exists( 'blossom_floral_latest_posts' ) ) :
/**
 * Latest Posts
*/
function blossom_floral_latest_posts(){ 
    blossom_floral_get_posts_list( 'latest' );
}
endif;
add_action( 'blossom_floral_latest_posts', 'blossom_floral_latest_posts' );

if( ! function_exists( 'blossom_floral_comment' ) ) :
/**
 * Comments Template 
*/
function blossom_floral_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( get_theme_mod( 'ed_comments', true ) && ( comments_open() || get_comments_number() ) ) :
        echo '<div class="comment-list-wrapper">';
		  comments_template();
        echo '</div>';
	endif;
}
endif;
add_action( 'blossom_floral_after_post_content', 'blossom_floral_comment', blossom_floral_comment_toggle() );
add_action( 'blossom_floral_after_page_content', 'blossom_floral_comment' );

if( ! function_exists( 'blossom_floral_content_end' ) ) :
/**
 * Content End
*/
function blossom_floral_content_end(){ 
        ?>            
        </div><!-- .container -->        
    </div><!-- .site-content -->
    <?php
}
endif;
add_action( 'blossom_floral_before_footer', 'blossom_floral_content_end', 20 );

if( ! function_exists( 'blossom_floral_bottom_shop_section' ) ) :
/**
 * Shop Section
 * 
*/
function blossom_floral_bottom_shop_section(){ 
    $ed_shop_section = get_theme_mod( 'ed_top_shop_section', false );
    $section_title   = get_theme_mod( 'shop_section_title', __( 'My Shop', 'blossom-floral' ) );
    $section_content = get_theme_mod( 'shop_section_content', __( 'This option can be change from Customize > General Settings > Shop settings.', 'blossom-floral' ) );
    $product_type    = get_theme_mod( 'product_type' );
    $custom_product  = get_theme_mod( 'selected_products' );
    $button_lbl      = get_theme_mod( 'shop_btn_lbl', __( 'Go To Shop', 'blossom-floral' ) );
    $button_link     = get_theme_mod( 'shop_btn_link' );

    if( is_front_page() && blossom_floral_is_woocommerce_activated() && $ed_shop_section ){ 
        
        $args = array(
            'post_type'       => 'product',
            'posts_per_page'  => 4,
            'post_status'     => 'publish'
        );
        if( $product_type == 'custom' ){
            $args['post__in'] = $custom_product;
        }elseif( $product_type == 'popular-products' ){
            $args['meta_key'] = 'total_sales';
            $args['order_by'] = 'meta_value_num';
        }elseif( $product_type == 'sale-products' ){
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['post__in']   = array_merge(array(0), wc_get_product_ids_on_sale());
        }else{
            $args['orderby']     = 'date';
            $args['order']       = 'DESC';
        }
        $qry = new WP_Query( $args );
        
        if( $qry->have_posts() || $section_title || $section_content ){ ?>
            <div id="product_section" class="product-section">
                <div class="product-section-wrapper">
                    <?php if( $section_title || $section_content ){ ?>
                        <header class="section-header">
                            <div class="container">
                                <?php 
                                    if( $section_title ) echo '<h2 class="section-title">' . esc_html( $section_title ) . '</h2>';
                                    if( $section_content ) echo '<div class="section-desc">' . wp_kses_post( wpautop( $section_content ) ) . '</div>';
                                ?>
                            </div>
                        </header>
                    <?php }
                    if( $qry->have_posts() ){ ?> 
                        <div class="container">
                            <div class="product-section-grid">
                                <?php while( $qry->have_posts() ){
                                    $qry->the_post(); 
                                    global $product;
                                    $stock = get_post_meta( get_the_ID(), '_stock_status', true );
                                    ?>
                                        <div class="product-item">
                                            <div class="product-image">
                                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                                    <?php 
                                                    if( has_post_thumbnail() ){
                                                        the_post_thumbnail( 'blossom-floral-shop', array( 'itemprop' => 'image' ) );    
                                                    }else{
                                                        blossom_floral_get_fallback_svg( 'blossom-floral-shop' ); //fallback
                                                    }
                                                    ?>
                                                </a>
                                                <?php 
                                                    $stock = get_post_meta( get_the_ID(), '_stock_status', true );
                                                    if( $stock == 'outofstock' ){
                                                        echo '<span class="outofstock">' . esc_html__( 'Sold Out', 'blossom-floral' ) . '</span>';
                                                    }else{
                                                        woocommerce_show_product_sale_flash();    
                                                    }
                                                ?> 
                                                <div class="woocommer-button">
                                                    <?php woocommerce_template_loop_add_to_cart(); ?>
                                                </div>
                                            </div>
                                            <div class="product-detail">                                    
                                                <?php 
                                                woocommerce_template_single_rating();                  
                                                the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                                                woocommerce_template_single_price(); 
                                                ?>
                                            </div>
                                        </div>
                                <?php } wp_reset_postdata(); ?>
                            </div>
                            <?php if( $button_lbl && $button_link ) { ?>
                                <div class="button-wrap">
                                    <a href="<?php echo esc_url( $button_link ); ?>" class="btn-readmore"><?php echo esc_html( $button_lbl ); ?></a>
                                </div>       
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php
        }
    }
}
endif;
add_action( 'blossom_floral_footer_start', 'blossom_floral_bottom_shop_section', 10 );

if( ! function_exists( 'blossom_floral_newsletter' ) ) :
/**
 * Newsletter
*/
function blossom_floral_newsletter(){ 
    $ed_newsletter    = get_theme_mod( 'ed_newsletter', false );
    $newsletter       = get_theme_mod( 'newsletter_shortcode' );
    $newsletter_image = get_theme_mod( 'newsletter_image' );

    if( $ed_newsletter && $newsletter && is_front_page() ){ ?>
        <div id="newsletter_section" class="newsletter-section">
            <div class="container">
                <div class="newsletter-section-grid">
                    <div class="grid-item">
                        <?php echo do_shortcode( wp_kses_post( $newsletter ) ); ?>
                    </div>              
                    <?php if ( $newsletter_image ) { ?>
                        <div class="grid-item">                                                                         
                            <img src="<?php echo esc_url( $newsletter_image ); ?>">                                    
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }
}
endif;
add_action( 'blossom_floral_footer_start', 'blossom_floral_newsletter', 20 );

if( ! function_exists( 'blossom_floral_footer_start' ) ) :
/**
 * Footer Start
*/
function blossom_floral_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'blossom_floral_footer', 'blossom_floral_footer_start', 20 );

if( ! function_exists( 'blossom_floral_footer_top' ) ) :
/**
 * Footer Top
*/
function blossom_floral_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-mid">
    		<div class="container">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
    				<div class="col">
    				   <?php dynamic_sidebar( $active ); ?>	
    				</div>
                <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }   
}
endif;
add_action( 'blossom_floral_footer', 'blossom_floral_footer_top', 30 );

if( ! function_exists( 'blossom_floral_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function blossom_floral_footer_bottom(){ ?>
    <div class="footer-bottom">
		<div class="container">
            <div class="footer-bottom__content-wrapper">
                <div class="site-info">            
                <?php
                    blossom_floral_get_footer_copyright();
                    echo esc_html__( ' Blossom Floral | Developed By ', 'blossom-floral' ); 
                    echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'blossom-floral' ) . '</a>.';                
                    printf( esc_html__( ' Powered by %s. ', 'blossom-floral' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'blossom-floral' ) ) .'" target="_blank">WordPress</a>' );
                    if( function_exists( 'the_privacy_policy_link' ) ){
                        the_privacy_policy_link();
                    }
                ?>               
                </div>
                <?php if( blossom_floral_social_links( false ) ) { ?>
                    <div class="footer-social-network">
                        <?php blossom_floral_social_links(); ?>
                    </div>
                    <?php
                } ?>
                <div class="footer-bottom-right">
                    <?php 
                        blossom_floral_footer_navigation();
                    ?>
                </div>
            </div>
		</div>
	</div>
    <?php
}
endif;
add_action( 'blossom_floral_footer', 'blossom_floral_footer_bottom', 40 );

if( ! function_exists( 'blossom_floral_footer_end' ) ) :
/**
 * Footer End 
*/
function blossom_floral_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'blossom_floral_footer', 'blossom_floral_footer_end', 50 );

if( ! function_exists( 'blossom_floral_back_to_top' ) ) :
/**
 * Back to top
*/
function blossom_floral_back_to_top(){ ?>
        <button class="back-to-top">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14.824" viewBox="0 0 18 14.824">
                <g id="Group_5480" data-name="Group 5480" transform="translate(1 1.408)" opacity="0.9">
                    <g id="Group_5477" data-name="Group 5477" transform="translate(0 0)">
                    <path id="Path_26477" data-name="Path 26477" d="M0,0H15.889" transform="translate(0 6.072)" fill="none"  stroke-linecap="round" stroke-width="2"/>
                    <path id="Path_26478" data-name="Path 26478" d="M0,0,7.209,6,0,12.007" transform="translate(8.791 0)" fill="none"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </g>
                </g>
            </svg>
        </button><!-- .back-to-top -->
    <?php
}
endif;
add_action( 'blossom_floral_after_footer', 'blossom_floral_back_to_top', 15 );

if( ! function_exists( 'blossom_floral_page_end' ) ) :
/**
 * Page End
*/
function blossom_floral_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'blossom_floral_after_footer', 'blossom_floral_page_end', 20 );