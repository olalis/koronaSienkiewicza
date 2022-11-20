<?php
/**
 * Blossom Floral Custom functions and definitions
 *
 * @package Blossom_Floral
 */

if ( ! function_exists( 'blossom_floral_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function blossom_floral_setup() {

    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Blossom Floral, use a find and replace
	 * to change 'blossom-floral' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'blossom-floral', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'blossom-floral' ),
        'secondary' => esc_html__( 'Secondary', 'blossom-floral' ),
        'footer'    => esc_html__( 'Footer', 'blossom-floral' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'blossom_floral_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 
        'custom-logo', 
        apply_filters( 
            'blossom_floral_custom_logo_args', 
            array( 
                'height'      => 70, /** change height as per theme requirement */
                'width'       => 70, /** change width as per theme requirement */
                'flex-height' => true,
                'flex-width'  => true,
                'header-text' => array( 'site-title', 'site-description' ) 
            )
        ) 
    );
    
    /**
     * Add support for custom header.
    */
    add_theme_support( 
        'custom-header', 
        apply_filters( 
            'blossom_floral_custom_header_args', 
            array(
                'default-image' => '',
                'video'         => true,
                'width'         => 1920, /** change width as per theme requirement */
                'height'        => 760, /** change height as per theme requirement */
                'header-text'   => false
            ) 
        ) 
    );
 
    /**
     * Add Custom Images sizes.
    */        
    add_image_size( 'blossom-floral-slider', 1920, 700, true );
    add_image_size( 'blossom-floral-featured-section', 360, 486, true );
    add_image_size( 'blossom-floral-with-sidebar', 730, 400, true );
    add_image_size( 'blossom-floral-related', 360, 203, true );
    add_image_size( 'blossom-floral-shop', 269, 364, true );
    add_image_size( 'blossom-floral-single', 1140, 641, true );
    add_image_size( 'blossom-floral-blog-home', 755, 424, true );

    // Add theme support for Responsive Videos.
    add_theme_support( 'jetpack-responsive-videos' );

    // Add support for full and wide align images.
    add_theme_support( 'align-wide' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Add excerpt support for pages
    add_post_type_support( 'page', 'excerpt' );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     *
     */
    add_editor_style( array(
            'css' . $build . '/editor-style' . $suffix . '.css',
            blossom_floral_fonts_url()
        )
    );

    // Add support for block editor styles.
    add_theme_support( 'wp-block-styles' );

    //Remove block widgets
    remove_theme_support( 'widgets-block-editor' );
}
endif;
add_action( 'after_setup_theme', 'blossom_floral_setup' );

if( ! function_exists( 'blossom_floral_content_width' ) ) :
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blossom_floral_content_width() {
	/** 
     * @todo Change content width as per theme.
    */
    $GLOBALS['content_width'] = apply_filters( 'blossom_floral_content_width', 775 );
}
endif;
add_action( 'after_setup_theme', 'blossom_floral_content_width', 0 );

if( ! function_exists( 'blossom_floral_template_redirect_content_width' ) ) :
/**
* Adjust content_width value according to template.
*
* @return void
*/
function blossom_floral_template_redirect_content_width(){
	$sidebar = blossom_floral_sidebar();
    if( $sidebar ){	
        $GLOBALS['content_width'] = 775;       
	}else{
        if( is_singular() ){
            if( blossom_floral_sidebar( true ) === 'full-width centered' ){
                $GLOBALS['content_width'] = 775;
            }else{
                $GLOBALS['content_width'] = 1170;               
            }                
        }else{
            $GLOBALS['content_width'] = 1170;
        }
	}
}
endif;
add_action( 'template_redirect', 'blossom_floral_template_redirect_content_width' );

if( ! function_exists( 'blossom_floral_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function blossom_floral_scripts() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    if( blossom_floral_is_woocommerce_activated() )
    wp_enqueue_style( 'blossom-floral-woocommerce', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array(), BLOSSOM_FLORAL_THEME_VERSION );
    
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css', array(), '2.3.4' );
    wp_enqueue_style( 'animate', get_template_directory_uri(). '/css' . $build . '/animate' . $suffix . '.css', array(), '3.5.2' );
    if ( get_theme_mod( 'ed_localgoogle_fonts', false ) && ! is_customize_preview() && ! is_admin() && get_theme_mod( 'ed_preload_local_fonts', false ) ) {
        blossom_floral_preload_local_fonts( blossom_floral_fonts_url() );
    }
    wp_enqueue_style( 'blossom-floral-google-fonts', blossom_floral_fonts_url(), array(), null );
    
    wp_enqueue_style( 'blossom-floral-elementor', get_template_directory_uri(). '/css' . $build . '/elementor' . $suffix . '.css', array(), BLOSSOM_FLORAL_THEME_VERSION );
    wp_enqueue_style( 'blossom-floral-gutenberg', get_template_directory_uri(). '/css' . $build . '/gutenberg' . $suffix . '.css', array(), BLOSSOM_FLORAL_THEME_VERSION );

    wp_enqueue_style( 'blossom-floral', get_stylesheet_uri(), array(), BLOSSOM_FLORAL_THEME_VERSION );

    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '6.1.1', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery', 'all' ), '6.1.1', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'blossom-floral', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery' ), BLOSSOM_FLORAL_THEME_VERSION, true );
	wp_enqueue_script( 'blossom-floral-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), BLOSSOM_FLORAL_THEME_VERSION, true );
    
    $array = array( 
        'rtl'       => is_rtl(),
        'auto'          => (bool) get_theme_mod( 'slider_auto', true ),
        'loop'          => (bool) get_theme_mod( 'slider_loop', false ),
        'animation' => esc_attr( get_theme_mod( 'slider_animation' ) ),
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
    );
    
    wp_localize_script( 'blossom-floral', 'blossom_floral_data', $array );
    
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'blossom_floral_scripts' );

if( ! function_exists( 'blossom_floral_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function blossom_floral_admin_scripts(){
    wp_enqueue_style( 'blossom-floral-admin', get_template_directory_uri() . '/inc/css/admin.css', '', BLOSSOM_FLORAL_THEME_VERSION );
}
endif; 
add_action( 'admin_enqueue_scripts', 'blossom_floral_admin_scripts' );

if( ! function_exists( 'blossom_floral_block_editor_styles' ) ) :
/**
 * Enqueue editor styles for Gutenberg
 */
function blossom_floral_block_editor_styles() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    // Block styles.
    wp_enqueue_style( 'blossom-floral-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    wp_add_inline_style( 'blossom-floral-block-editor-style', blossom_floral_gutenberg_inline_style() );

    // Add custom fonts.
    wp_enqueue_style( 'blossom-floral-google-fonts', blossom_floral_fonts_url(), array(), null );
}
endif;
add_action( 'enqueue_block_editor_assets', 'blossom_floral_block_editor_styles' );

if( ! function_exists( 'blossom_floral_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blossom_floral_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    
    // Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
    
    // Adds a class single post layout.
    if( is_single() ) {
        $classes[] = 'style-one';
    }

    if ( is_home() || ( is_archive() && !( blossom_floral_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() ) ) ) || is_search() ) {
        $classes[] = 'list-layout';
    }

    $classes[] = blossom_floral_sidebar( true );
    
	return $classes;
}
endif;
add_filter( 'body_class', 'blossom_floral_body_classes' );

if( ! function_exists( 'blossom_floral_post_classes' ) ) :
/**
 * Add custom classes to the array of post classes.
*/
function blossom_floral_post_classes( $classes ){
    
    if( is_single() ){
        $classes[] = 'has-meta';
    }
    
    return $classes;
}
endif;
add_filter( 'post_class', 'blossom_floral_post_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function blossom_floral_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'blossom_floral_pingback_header' );

if( ! function_exists( 'blossom_floral_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
*/
function blossom_floral_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );    
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'blossom-floral' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr__( 'Name*', 'blossom-floral' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'blossom-floral' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr__( 'Email*', 'blossom-floral' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'blossom-floral' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'blossom-floral' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'blossom_floral_change_comment_form_default_fields' );

if( ! function_exists( 'blossom_floral_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
*/
function blossom_floral_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'blossom-floral' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'blossom-floral' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'blossom_floral_change_comment_form_defaults' );

if ( ! function_exists( 'blossom_floral_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function blossom_floral_excerpt_more( $more ) {
	return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'blossom_floral_excerpt_more' );

if ( ! function_exists( 'blossom_floral_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function blossom_floral_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'excerpt_length', 55 );
    return is_admin() ? $length : absint( $excerpt_length );    
}
endif;
add_filter( 'excerpt_length', 'blossom_floral_excerpt_length', 999 );

if( ! function_exists( 'blossom_floral_exclude_cat' ) ) :
/**
 * Exclude post with Category from blog and archive page. 
*/
function blossom_floral_exclude_cat( $query ){
    
    $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
    $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' );
    $slider_cat     = get_theme_mod( 'slider_cat' );
    $posts_per_page = get_theme_mod( 'no_of_slides', 3 );
    $repetitive_posts = get_theme_mod( 'include_repetitive_posts', true );

    if( ! is_admin() && $query->is_main_query() && $query->is_home() && $ed_banner == 'slider_banner'  && ! $repetitive_posts ){
        if( $slider_type === 'cat' && $slider_cat  ){            
 			$query->set( 'category__not_in', array( $slider_cat ) );    		
        }elseif( $slider_type == 'latest_posts' ){
            $args = array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => $posts_per_page,
                'ignore_sticky_posts' => true
            );
            $latest = get_posts( $args );
            $excludes = array();
            foreach( $latest as $l ){
                array_push( $excludes, $l->ID );
            }
            $query->set( 'post__not_in', $excludes );
        }  
    }    
}
endif;
add_filter( 'pre_get_posts', 'blossom_floral_exclude_cat' );

if( ! function_exists( 'blossom_floral_get_the_archive_title' ) ) :
/**
 * Filter Archive Title
*/
function blossom_floral_get_the_archive_title( $title ){
    $ed_prefix = get_theme_mod( 'ed_prefix_archive', false );
    
    if( is_post_type_archive( 'product' ) ){
        $title = '<h1 class="page-title">' . get_the_title( get_option( 'woocommerce_shop_page_id' ) ) . '</h1>';
    }else{
        if( is_category() ){
            if( $ed_prefix ) {
                $title = '<h1 class="page-title">' . esc_html( single_cat_title( '', false ) ) . '</h1>';
            }else{
                $title = '<span class="sub-title">' . esc_html__( 'Browse Category For', 'blossom-floral' ) . '</span><h1 class="page-title">' . esc_html( single_cat_title( '', false ) ) . '</h1>';
            }
        }
        elseif( is_tag() ){
            if( $ed_prefix ) {
                $title = '<h1 class="page-title">' . esc_html( single_tag_title( '', false ) ) . '</h1>';
            }else{
                $title = '<span class="sub-title">'. esc_html__( 'Browse Tag For', 'blossom-floral' ) . '</span><h1 class="page-title">' . esc_html( single_tag_title( '', false ) ) . '</h1>';
            }
        }elseif( is_year() ){
            if( $ed_prefix ){
                $title = '<h1 class="page-title">' . get_the_date( _x( 'Y', 'yearly archives date format', 'blossom-floral' ) ) . '</h1>';                   
            }else{
                $title = '<span class="sub-title">'. esc_html__( 'Year', 'blossom-floral' ) . '</span><h1 class="page-title">' . get_the_date( _x( 'Y', 'yearly archives date format', 'blossom-floral' ) ) . '</h1>';
            }
        }elseif( is_month() ){
            if( $ed_prefix ){
                $title = '<h1 class="page-title">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'blossom-floral' ) ) . '</h1>';                                   
            }else{
                $title = '<span class="sub-title">'. esc_html__( 'Month', 'blossom-floral' ) . '</span><h1 class="page-title">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'blossom-floral' ) ) . '</h1>';
            }
        }elseif( is_day() ){
            if( $ed_prefix ){
                $title = '<h1 class="page-title">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'blossom-floral' ) ) . '</h1>';                                   
            }else{
                $title = '<span class="sub-title">'. esc_html__( 'Day', 'blossom-floral' ) . '</span><h1 class="page-title">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'blossom-floral' ) ) .  '</h1>';
            }
        }elseif( is_post_type_archive() ) {
            if( $ed_prefix ){
                $title = '<h1 class="page-title">'  . post_type_archive_title( '', false ) . '</h1>';                            
            }else{
                $title = '<span class="sub-title">'. esc_html__( 'Archives', 'blossom-floral' ) . '</span><h1 class="page-title">'  . post_type_archive_title( '', false ) . '</h1>';
            }
        }elseif( is_tax() ) {
            $tax = get_taxonomy( get_queried_object()->taxonomy );
            if( $ed_prefix ){
                $title = '<h1 class="page-title">' . single_term_title( '', false ) . '</h1>';                                   
            }else{
                $title = '<span class="sub-title">' . $tax->labels->singular_name . '</span><h1 class="page-title">' . single_term_title( '', false ) . '</h1>';
            }
        }
    }  
    
    return $title;

}
endif;
add_filter( 'get_the_archive_title', 'blossom_floral_get_the_archive_title' );

if( ! function_exists( 'blossom_floral_remove_archive_description' ) ) :
/**
 * filter the_archive_description & get_the_archive_description to show post type archive
 * @param  string $description original description
 * @return string post type description if on post type archive
 */
function blossom_floral_remove_archive_description( $description ){
    $ed_shop_archive_description = get_theme_mod( 'ed_shop_archive_description', false );
    if( is_post_type_archive( 'product' ) ) {
        if( ! $ed_shop_archive_description ){
            $description = '';
        }
    }
    return $description;
}
endif;
add_filter( 'get_the_archive_description', 'blossom_floral_remove_archive_description' );

if( ! function_exists( 'blossom_floral_get_comment_author_link' ) ) :
/**
 * Filter to modify comment author link
 * @link https://developer.wordpress.org/reference/functions/get_comment_author_link/
 */
function blossom_floral_get_comment_author_link( $return, $author, $comment_ID ){
    $comment = get_comment( $comment_ID );
    $url     = get_comment_author_url( $comment );
    $author  = get_comment_author( $comment );
 
    if ( empty( $url ) || 'http://' == $url )
        $return = '<span itemprop="name">'. esc_html( $author ) .'</span>';
    else
        $return = '<span itemprop="name"><a href=' . esc_url( $url ) . ' rel="external nofollow noopener" class="url" itemprop="url">' . esc_html( $author ) . '</a></span>';

    return $return;
}
endif;
add_filter( 'get_comment_author_link', 'blossom_floral_get_comment_author_link', 10, 3 );

if( ! function_exists( 'blossom_floral_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function blossom_floral_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'blossom_floral_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'blossom-floral' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'blossom-floral' ), esc_html( $name ) ); ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=blossom-floral-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'blossom-floral' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?blossom_floral_admin_notice=1"><?php esc_html_e( 'Dismiss', 'blossom-floral' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'blossom_floral_admin_notice' );

if( ! function_exists( 'blossom_floral_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function blossom_floral_update_admin_notice(){
    if ( isset( $_GET['blossom_floral_admin_notice'] ) && $_GET['blossom_floral_admin_notice'] = '1' ) {
        update_option( 'blossom_floral_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'blossom_floral_update_admin_notice' );

if ( ! function_exists( 'blossom_floral_get_fontawesome_ajax' ) ) :
/**
 * Return an array of all icons.
 */
function blossom_floral_get_fontawesome_ajax() {
    // Bail if the nonce doesn't check out
    if ( ! isset( $_POST['blossom_floral_customize_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['blossom_floral_customize_nonce'] ), 'blossom_floral_customize_nonce' ) ) {
        wp_die();
    }

    // Do another nonce check
    check_ajax_referer( 'blossom_floral_customize_nonce', 'blossom_floral_customize_nonce' );

    // Bail if user can't edit theme options
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die();
    }

    // Get all of our fonts
    $fonts = blossom_floral_get_fontawesome_list();
    
    ob_start();
    if( $fonts ){ ?>
        <ul class="font-group">
            <?php 
                foreach( $fonts as $font ){
                    echo '<li data-font="' . esc_attr( $font ) . '"><i class="' . esc_attr( $font ) . '"></i></li>';                        
                }
            ?>
        </ul>
        <?php
    }
    echo ob_get_clean();

    // Exit
    wp_die();
}
endif;
add_action( 'wp_ajax_blossom_floral_get_fontawesome_ajax', 'blossom_floral_get_fontawesome_ajax' );