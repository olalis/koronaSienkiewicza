<?php

/**
 * Blossom Floral Standalone Functions.
 *
 * @package Blossom_Floral
 */

if (!function_exists('blossom_floral_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function blossom_floral_posted_on()
    {
        $ed_updated_post_date = get_theme_mod('ed_post_update_date', true);
        $on = '';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            if ($ed_updated_post_date) {
                $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
                $on = __('Updated on ', 'blossom-floral');
            } else {
                $time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
            }
        } else {
            $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf('%1$s %2$s', esc_html($on), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>');

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

    }
endif;

if (!function_exists('blossom_floral_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function blossom_floral_posted_by()
    {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('%s', 'post author', 'blossom-floral'),
            '<span itemprop="name"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" itemprop="url">' . esc_html(get_the_author()) . '</a></span>'
        );
        echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person">' . $byline . '</span>';
    }
endif;

if (!function_exists('blossom_floral_comment_count')) :
    /**
     * Comment Count
     */
    function blossom_floral_comment_count( $echo = true ) {
        if ( $echo && ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) ) {
            echo '<span class="comments"><i class="far fa-comment"></i>';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'blossom-floral' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }else{
            return true;
        }   
    }
endif;

if (!function_exists('blossom_floral_category')) :
    /**
     * Prints categories
     */
    function blossom_floral_category()
    {
        $ed_cat_single  = get_theme_mod( 'ed_category', false );
        // Hide category and tag text for pages.
        if ('post' === get_post_type() && !$ed_cat_single ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(' ', 'blossom-floral'));
            if ($categories_list) {
                echo '<span class="cat-links" itemprop="about">' . wp_kses_post( $categories_list ) . '</span>';
            }
        }
    }
endif;

if (!function_exists('blossom_floral_tag')) :
    /**
     * Prints tags
     */
    function blossom_floral_tag()
    {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            $tags_list = get_the_tag_list('', ' ');
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<div class="tags" itemprop="about">' . esc_html__('%1$sTags:%2$s %3$s', 'blossom-floral') . '</div>', '<span>', '</span>', $tags_list);
            }
        }
    }
endif;

if (!function_exists('blossom_floral_get_posts_list')) :
    /**
     * Returns Latest and Related 
     */
    function blossom_floral_get_posts_list($status)
    {
        global $post;

        $args = array(
            'post_type'           => 'post',
            'posts_status'        => 'publish',
            'ignore_sticky_posts' => true
        );

        switch ($status) {
            case 'latest':
            $args['posts_per_page'] = 6;
            $article_title          = __('Latest Posts', 'blossom-floral');
            $class                  = 'additional-post';
            $image_size             = 'blossom-floral-related';
            break;

            case 'related':
            $args['posts_per_page'] = 4;
            $args['post__not_in']   = array($post->ID);
            $args['orderby']        = 'rand';
            $article_title          = get_theme_mod('related_post_title', __('You may also like...', 'blossom-floral'));
            $class                  = 'related-posts';
            $image_size             = 'blossom-floral-related';
            $cats                   = get_the_category($post->ID);
            if ($cats) {
                $c = array();
                foreach ($cats as $cat) {
                    $c[] = $cat->term_id;
                }
                $args['category__in'] = $c;
            }
            break;
        }

        $qry = new WP_Query($args);

        if( $qry->have_posts() ){ ?>    
            <div class="<?php echo esc_attr( $class ); ?>">
                <?php 
                if( $article_title  ) echo '<h2 class="title">' . esc_html( $article_title  ) . '</h2>'; ?>
                <div class="article-wrap">
                    <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                        <article class="post">
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                <?php
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                                    }else{ 
                                        blossom_floral_get_fallback_svg( $image_size );//fallback
                                    }
                                ?>
                            </a>
                            <header class="entry-header">
                                <div class="entry-meta">
                                    <?php blossom_floral_category(); ?>
                                </div> 
                                <?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>  
                            </header>
                        </article>   
                    <?php } ?>    
                </div>
                <?php if( is_404() ){?>
                    <div class="section-button-wrapper">
                        <a class="wc-btn wc-btn-one"
                            href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'GO TO HOMEPAGE', 'blossom-floral' ); ?>
                        </a>
                    </div>
                <?php } ?>		
            </div>
            <?php
            wp_reset_postdata();
        }
    }
endif;

if (!function_exists('blossom_floral_social_links')) :
    /**
     * Social Links 
     */
    function blossom_floral_social_links($echo = true)
    {
        $social_links = get_theme_mod('social_links');
        $ed_social    = get_theme_mod('ed_social_links', false);

        if ($ed_social && $social_links && $echo) { ?>
            <ul class="social-networks">
                <?php
                foreach ($social_links as $link) {
                    if ($link['link']) { ?>
                        <li>
                            <a href="<?php echo esc_url($link['link']); ?>" target="_blank" rel="nofollow noopener">
                                <i class="<?php echo esc_attr($link['font']); ?>"></i>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        <?php
        } elseif ($ed_social && $social_links) {
            return true;
        } else {
            return false;
        }
        ?>
    <?php
    }
endif;

if (!function_exists('blossom_floral_breadcrumb')) :
    /**
     * Breadcrumbs
     */
    function blossom_floral_breadcrumb()
    {
        global $post;
        $post_page  = get_option('page_for_posts'); //The ID of the page that displays posts.
        $show_front = get_option('show_on_front'); //What to show on the front page    
        $home       = get_theme_mod('home_text', __('Home', 'blossom-floral')); // text for the 'Home' link
        $before     = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
        $after      = '</span>'; // tag after the current crumb

        if (get_theme_mod('ed_breadcrumb', true)) {
            $depth = 1;
            echo '<div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="' . esc_url(home_url()) . '" itemprop="item"><span itemprop="name">' . esc_html($home) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';

            if (is_home()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(single_post_title('', false)) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_category()) {
                $depth = 2;
                $thisCat = get_category(get_query_var('cat'), false);
                if ($show_front === 'page' && $post_page) { //If static blog post page is set
                    $p = get_post($post_page);
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink($post_page)) . '" itemprop="item"><span itemprop="name">' . esc_html($p->post_title) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                    $depth++;
                }
                if ($thisCat->parent != 0) {
                    $parent_categories = get_category_parents($thisCat->parent, false, ',');
                    $parent_categories = explode(',', $parent_categories);
                    foreach ($parent_categories as $parent_term) {
                        $parent_obj = get_term_by('name', $parent_term, 'category');
                        if (is_object($parent_obj)) {
                            $term_url  = get_term_link($parent_obj->term_id);
                            $term_name = $parent_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url($term_url) . '"><span itemprop="name">' . esc_html($term_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<a itemprop="item" href="' . esc_url(get_term_link($thisCat->term_id)) . '"><span itemprop="name">' .  esc_html(single_cat_title('', false)) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (blossom_floral_is_woocommerce_activated() && (is_product_category() || is_product_tag())) { //For Woocommerce archive page
                $depth = 2;
                $current_term = $GLOBALS['wp_query']->get_queried_object();
                if (wc_get_page_id('shop')) { //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';
                    if (!$_name) {
                        $product_post_type = get_post_type_object('product');
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" itemprop="item"><span itemprop="name">' . esc_html($_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                    $depth++;
                }
                if (is_product_category()) {
                    $ancestors = get_ancestors($current_term->term_id, 'product_cat');
                    $ancestors = array_reverse($ancestors);
                    foreach ($ancestors as $ancestor) {
                        $ancestor = get_term($ancestor, 'product_cat');
                        if (!is_wp_error($ancestor) && $ancestor) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_term_link($ancestor)) . '" itemprop="item"><span itemprop="name">' . esc_html($ancestor->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<a itemprop="item" href="' . esc_url(get_term_link($current_term->term_id)) . '"><span itemprop="name">' . esc_html($current_term->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (blossom_floral_is_woocommerce_activated() && is_shop()) { //Shop Archive page
                $depth = 2;
                if (get_option('page_on_front') == wc_get_page_id('shop')) {
                    return;
                }
                $_name    = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';
                $shop_url = (wc_get_page_id('shop') && wc_get_page_id('shop') > 0)  ? get_the_permalink(wc_get_page_id('shop')) : home_url('/shop');
                if (!$_name) {
                    $product_post_type = get_post_type_object('product');
                    $_name             = $product_post_type->labels->singular_name;
                }
                echo $before . '<a itemprop="item" href="' . esc_url($shop_url) . '"><span itemprop="name">' . esc_html($_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_tag()) {
                $depth          = 2;
                $queried_object = get_queried_object();
                echo $before . '<a itemprop="item" href="' . esc_url(get_term_link($queried_object->term_id)) . '"><span itemprop="name">' . esc_html(single_tag_title('', false)) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_author()) {
                global $author;
                $depth    = 2;
                $userdata = get_userdata($author);
                echo $before . '<a itemprop="item" href="' . esc_url(get_author_posts_url($author)) . '"><span itemprop="name">' . esc_html($userdata->display_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_search()) {
                $depth       = 2;
                $request_uri = $_SERVER['REQUEST_URI'];
                echo $before . '<a itemprop="item" href="' . esc_url($request_uri) . '"><span itemprop="name">' . sprintf(__('Search Results for "%s"', 'blossom-floral'), esc_html(get_search_query())) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_day()) {
                $depth = 2;
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_year_link(get_the_time(__('Y', 'blossom-floral')))) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_time(__('Y', 'blossom-floral'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                $depth++;
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_month_link(get_the_time(__('Y', 'blossom-floral')), get_the_time(__('m', 'blossom-floral')))) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_time(__('F', 'blossom-floral'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                $depth++;
                echo $before . '<a itemprop="item" href="' . esc_url(get_day_link(get_the_time(__('Y', 'blossom-floral')), get_the_time(__('m', 'blossom-floral')), get_the_time(__('d', 'blossom-floral')))) . '"><span itemprop="name">' . esc_html(get_the_time(__('d', 'blossom-floral'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_month()) {
                $depth = 2;
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_year_link(get_the_time(__('Y', 'blossom-floral')))) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_time(__('Y', 'blossom-floral'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                $depth++;
                echo $before . '<a itemprop="item" href="' . esc_url(get_month_link(get_the_time(__('Y', 'blossom-floral')), get_the_time(__('m', 'blossom-floral')))) . '"><span itemprop="name">' . esc_html(get_the_time(__('F', 'blossom-floral'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_year()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_year_link(get_the_time(__('Y', 'blossom-floral')))) . '"><span itemprop="name">' . esc_html(get_the_time(__('Y', 'blossom-floral'))) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_single() && !is_attachment()) {
                $depth = 2;
                if (blossom_floral_is_woocommerce_activated() && 'product' === get_post_type()) { //For Woocommerce single product
                    if (wc_get_page_id('shop')) { //Displaying Shop link in woocommerce archive page
                        $_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';
                        if (!$_name) {
                            $product_post_type = get_post_type_object('product');
                            $_name = $product_post_type->labels->singular_name;
                        }
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" itemprop="item"><span itemprop="name">' . esc_html($_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                        $depth++;
                    }
                    if ($terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'))) {
                        $main_term = apply_filters('woocommerce_breadcrumb_main_term', $terms[0], $terms);
                        $ancestors = get_ancestors($main_term->term_id, 'product_cat');
                        $ancestors = array_reverse($ancestors);
                        foreach ($ancestors as $ancestor) {
                            $ancestor = get_term($ancestor, 'product_cat');
                            if (!is_wp_error($ancestor) && $ancestor) {
                                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_term_link($ancestor)) . '" itemprop="item"><span itemprop="name">' . esc_html($ancestor->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                                $depth++;
                            }
                        }
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_term_link($main_term)) . '" itemprop="item"><span itemprop="name">' . esc_html($main_term->name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                        $depth++;
                    }
                    echo $before . '<a href="' . esc_url(get_the_permalink()) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                } elseif (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    if ($post_type->has_archive == true) { // For CPT Archive Link                   
                        // Add support for a non-standard label of 'archive_title' (special use case).
                        $label = !empty($post_type->labels->archive_title) ? $post_type->labels->archive_title : $post_type->labels->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_post_type_archive_link(get_post_type())) . '" itemprop="item"><span itemprop="name">' . esc_html($label) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                        $depth++;
                    }
                    echo $before . '<a href="' . esc_url(get_the_permalink()) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                } else { //For Post                
                    $cat_object       = get_the_category();
                    $potential_parent = 0;

                    if ($show_front === 'page' && $post_page) { //If static blog post page is set
                        $p = get_post($post_page);
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink($post_page)) . '" itemprop="item"><span itemprop="name">' . esc_html($p->post_title) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                        $depth++;
                    }

                    if ($cat_object) { //Getting category hierarchy if any        
                        //Now try to find the deepest term of those that we know of
                        $use_term = key($cat_object);
                        foreach ($cat_object as $key => $object) {
                            //Can't use the next($cat_object) trick since order is unknown
                            if ($object->parent > 0  && ($potential_parent === 0 || $object->parent === $potential_parent)) {
                                $use_term         = $key;
                                $potential_parent = $object->term_id;
                            }
                        }
                        $cat  = $cat_object[$use_term];
                        $cats = get_category_parents($cat, false, ',');
                        $cats = explode(',', $cats);
                        foreach ($cats as $cat) {
                            $cat_obj = get_term_by('name', $cat, 'category');
                            if (is_object($cat_obj)) {
                                $term_url  = get_term_link($cat_obj->term_id);
                                $term_name = $cat_obj->name;
                                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url($term_url) . '"><span itemprop="name">' . esc_html($term_name) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                                $depth++;
                            }
                        }
                    }
                    echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) { //For Custom Post Archive
                $depth     = 2;
                $post_type = get_post_type_object(get_post_type());
                if (get_query_var('paged')) {
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_post_type_archive_link($post_type->name)) . '" itemprop="item"><span itemprop="name">' . esc_html($post_type->label) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />/</span>';
                    echo $before . sprintf(__('Page %s', 'blossom-floral'), get_query_var('paged')) . $after; //@todo need to check this
                } else {
                    echo $before . '<a itemprop="item" href="' . esc_url(get_post_type_archive_link($post_type->name)) . '"><span itemprop="name">' . esc_html($post_type->label) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
                }
            } elseif (is_attachment()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_page() && !$post->post_parent) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(get_the_permalink()) . '"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            } elseif (is_page() && $post->post_parent) {
                $depth       = 2;
                $parent_id   = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $current_page  = get_post($parent_id);
                    $breadcrumbs[] = $current_page->ID;
                    $parent_id     = $current_page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url(get_permalink($breadcrumbs[$i])) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($breadcrumbs[$i])) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>';
                    $depth++;
                }
                echo $before . '<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title()) . '</span></a><meta itemprop="position" content="' . absint($depth) . '" /></span>' . $after;
            } elseif (is_404()) {
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url(home_url()) . '"><span itemprop="name">' . esc_html__('404 Error - Page Not Found', 'blossom-floral') . '</span></a><meta itemprop="position" content="' . absint($depth) . '" />' . $after;
            }

            if (get_query_var('paged')) printf(__(' (Page %s)', 'blossom-floral'), get_query_var('paged'));

            echo '</div><!-- .crumbs -->';
        }
    }
endif;

if (!function_exists('blossom_floral_theme_comment')) :
    /**
     * Callback function for Comment List *
     * 
     * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
     */
    function blossom_floral_theme_comment($comment, $args, $depth)
    {
        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
    ?>
    <<?php echo esc_html( $tag ) ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

        <?php if ('div' != $args['style']) : ?>
            <div id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
            <?php endif; ?>

            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size'], '', 'avatar' ); ?>
                </div><!-- .comment-author vcard -->
            </footer>

            <div class="text-holder">
                <div class="top">
                    <div class="left">
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'blossom-floral'); ?></em>
                            <br />
                        <?php endif; ?>
                        <?php printf(__('<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b> <span class="says">says:</span>', 'blossom-floral'), get_comment_author_link()); ?>
                        <div class="comment-metadata commentmetadata">
                            <?php esc_html_e('Posted on', 'blossom-floral'); ?>
                            <a href="<?php echo esc_url(htmlspecialchars(get_comment_link($comment->comment_ID))); ?>">
                                <time itemprop="commentTime" datetime="<?php echo esc_attr(get_gmt_from_date(get_comment_date() . get_comment_time(), 'Y-m-d H:i:s')); ?>"><?php printf(esc_html__('%1$s at %2$s', 'blossom-floral'), get_comment_date(),  get_comment_time()); ?></time>
                            </a>
                        </div>
                    </div>
                    <div class="reply">
                        <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    </div>
                </div>
                <div class="comment-content" itemprop="commentText"><?php comment_text(); ?></div>
            </div><!-- .text-holder -->

            <?php if ('div' != $args['style']) : ?>
            </div><!-- .comment-body -->
        <?php endif; ?>

        <?php
    }
endif;

if (!function_exists('blossom_floral_sidebar')) :
    /**
     * Return sidebar layouts for pages/posts
     */
    function blossom_floral_sidebar($class = false)
    {
        global $post;
        $return = false;
        $page_layout = get_theme_mod('page_sidebar_layout', 'right-sidebar'); //Default Layout Style for Pages
        $post_layout = get_theme_mod('post_sidebar_layout', 'right-sidebar'); //Default Layout Style for Posts
        $layout      = get_theme_mod('layout_style', 'right-sidebar'); //Default Layout Style for Styling Settings

        if (is_singular(array('page', 'post'))) {
            if (get_post_meta($post->ID, '_blossom_floral_sidebar_layout', true)) {
                $sidebar_layout = get_post_meta($post->ID, '_blossom_floral_sidebar_layout', true);
            } else {
                $sidebar_layout = 'default-sidebar';
            }

            if (is_page()) {
                if (is_active_sidebar('sidebar')) {
                    if ($sidebar_layout == 'no-sidebar' || ($sidebar_layout == 'default-sidebar' && $page_layout == 'no-sidebar')) {
                        $return = $class ? 'full-width' : false;
                    } elseif ($sidebar_layout == 'centered' || ($sidebar_layout == 'default-sidebar' && $page_layout == 'centered')) {
                        $return = $class ? 'full-width centered' : false;
                    } elseif (($sidebar_layout == 'default-sidebar' && $page_layout == 'right-sidebar') || ($sidebar_layout == 'right-sidebar')) {
                        $return = $class ? 'rightsidebar' : 'sidebar';
                    } elseif (($sidebar_layout == 'default-sidebar' && $page_layout == 'left-sidebar') || ($sidebar_layout == 'left-sidebar')) {
                        $return = $class ? 'leftsidebar' : 'sidebar';
                    }
                } else {
                    $return = $class ? 'full-width' : false;
                }
            } elseif (is_single()) {
                if (is_active_sidebar('sidebar')) {
                    if ($sidebar_layout == 'no-sidebar' || ($sidebar_layout == 'default-sidebar' && $post_layout == 'no-sidebar')) {
                        $return = $class ? 'full-width' : false;
                    } elseif ($sidebar_layout == 'centered' || ($sidebar_layout == 'default-sidebar' && $post_layout == 'centered')) {
                        $return = $class ? 'full-width centered' : false;
                    } elseif (($sidebar_layout == 'default-sidebar' && $post_layout == 'right-sidebar') || ($sidebar_layout == 'right-sidebar')) {
                        $return = $class ? 'rightsidebar' : 'sidebar';
                    } elseif (($sidebar_layout == 'default-sidebar' && $post_layout == 'left-sidebar') || ($sidebar_layout == 'left-sidebar')) {
                        $return = $class ? 'leftsidebar' : 'sidebar';
                    }
                } else {
                    $return = $class ? 'full-width' : false;
                }
            }
        } elseif (blossom_floral_is_woocommerce_activated() && (is_shop() || is_product_category() || is_product_tag() || get_post_type() == 'product')) {
            if ($layout == 'no-sidebar') {
                $return = $class ? 'full-width' : false;
            } elseif (is_active_sidebar('shop-sidebar')) {
                if ($class) {
                    if ($layout == 'right-sidebar') $return = 'rightsidebar'; //With Sidebar
                    if ($layout == 'left-sidebar') $return = 'leftsidebar';
                }
            } else {
                $return = $class ? 'full-width' : false;
            }
        } else {
            if ($layout == 'no-sidebar') {
                $return = $class ? 'full-width' : false;
            } elseif (is_active_sidebar('sidebar')) {
                if ($class) {
                    if ($layout == 'right-sidebar') $return = 'rightsidebar'; //With Sidebar
                    if ($layout == 'left-sidebar') $return = 'leftsidebar';
                } else {
                    $return = 'sidebar';
                }
            } else {
                $return = $class ? 'full-width' : false;
            }
        }
        return $return;
    }
endif;

if ( ! function_exists( 'blossom_floral_article_meta' )) :

    /**
    * Author profile for single post.
    */
function blossom_floral_article_meta(){
    $comment    = blossom_floral_comment_count( false );
    $ed_author  = get_theme_mod( 'ed_post_author', false );

    if ( ! $ed_author || $comment ) {
        ?>
        <div class="article-meta">
            <div class="article-meta-inner">
                <?php  
                if( ! $ed_author ){ ?>
                    <figure class="author-img">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 70, '', 'avatar' ); ?>
                        <span class="byline">
                            <span>
                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="url fn">
                                    <?php the_author_meta( 'display_name'); ?>
                                </a>
                            </span>
                        </span>
                    </figure>
                <?php
                }
                if( $comment ) blossom_floral_comment_count();
                ?>
            </div>
        </div>
        <?php
    }
}
endif;

if (!function_exists('blossom_floral_get_posts')) :
    /**
     * Fuction to list Custom Post Type
     */
    function blossom_floral_get_posts($post_type = 'post')
    {
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => $post_type,
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts($args);

        // Initate an empty array
        $post_options = array();
        $post_options[''] = __(' -- Choose -- ', 'blossom-floral');
        if (!empty($posts_array)) {
            foreach ($posts_array as $posts) {
                $post_options[$posts->ID] = $posts->post_title;
            }
        }
        return $post_options;
        wp_reset_postdata();
    }
endif;

if ( ! function_exists( 'blossom_floral_comment_toggle' ) ):
/**
 * Function toggle comment section position
*/
function blossom_floral_comment_toggle(){
    $comment_postion = get_theme_mod( 'toggle_comments', false );

    if ( $comment_postion ) {
        $priority = 5;
    }else{
        $priority = 45;
    }
    return absint( $priority ) ;
}
endif;

if (!function_exists('blossom_floral_get_categories')) :
    /**
     * Function to list post categories in customizer options
     */
    function blossom_floral_get_categories($select = true, $taxonomy = 'category', $slug = false)
    {
        /* Option list of all categories */
        $categories = array();

        $args = array(
            'hide_empty' => false,
            'taxonomy'   => $taxonomy
        );

        $catlists = get_terms($args);
        if ($select) $categories[''] = __('Choose Category', 'blossom-floral');
        foreach ($catlists as $category) {
            if ($slug) {
                $categories[$category->slug] = $category->name;
            } else {
                $categories[$category->term_id] = $category->name;
            }
        }

        return $categories;
    }
endif;

if (!function_exists('blossom_floral_get_image_sizes')) :
    /**
     * Get information about available image sizes
     */
    function blossom_floral_get_image_sizes($size = '')
    {

        global $_wp_additional_image_sizes;

        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        // Create the full array with sizes and crop info
        foreach ($get_intermediate_image_sizes as $_size) {
            if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
                $sizes[$_size]['width'] = get_option($_size . '_size_w');
                $sizes[$_size]['height'] = get_option($_size . '_size_h');
                $sizes[$_size]['crop'] = (bool) get_option($_size . '_crop');
            } elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = array(
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' =>  $_wp_additional_image_sizes[$_size]['crop']
                );
            }
        }
        // Get only 1 size if found
        if ($size) {
            if (isset($sizes[$size])) {
                return $sizes[$size];
            } else {
                return false;
            }
        }
        return $sizes;
    }
endif;

if (!function_exists('blossom_floral_get_fallback_svg')) :
    /**
     * Get Fallback SVG
     */
    function blossom_floral_get_fallback_svg($post_thumbnail)
    {
        if (!$post_thumbnail) {
            return;
        }

        $image_size = blossom_floral_get_image_sizes($post_thumbnail);

        if ($image_size) { ?>
            <div class="svg-holder">
                <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr($image_size['width']); ?> <?php echo esc_attr($image_size['height']); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr($image_size['width']); ?>" height="<?php echo esc_attr($image_size['height']); ?>" style="fill:#f2f2f2;"></rect>
                </svg>
            </div>
        <?php
        }
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Fire the wp_body_open action.
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     */
    function wp_body_open()
    {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }
endif;

if (!function_exists('blossom_floral_instagram')) :
    /**
     * Instagram Section
     */
    function blossom_floral_instagram($show = true)
    {
        if (blossom_floral_is_btif_activated()) {
            $ed_instagram = get_theme_mod('ed_instagram', false);
            $ed_header    = get_theme_mod('ed_header_instagram', false);
            $ed_footer    = get_theme_mod('ed_footer_instagram', false);

            if ($ed_instagram && $show) {
                if ($ed_header) {
                    echo '<div class="instagram-section header-instagram">' . do_shortcode('[blossomthemes_instagram_feed]') . '</div>';
                }
            } elseif ($ed_instagram && !$show) {
                if ($ed_footer) echo '<div class="instagram-section footer-instagram">' . do_shortcode('[blossomthemes_instagram_feed]') . '</div>';
            }
        }
    }
endif;

if( ! function_exists( 'blossom_floral_secondary_navigation' ) ) :
/**
 * Secondary Navigation
*/
function blossom_floral_secondary_navigation(){ 
    if( current_user_can( 'manage_options' ) || has_nav_menu( 'secondary' ) ) { ?>
        <nav class="secondary-nav">
            <button class="toggle-btn">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'secondary',
                    'menu_id'        => 'secondary-menu',
                    'menu_class'     => 'nav-menu',
                    'fallback_cb'    => 'blossom_floral_secondary_menu_fallback',
                ) );
            ?>
        </nav>
    <?php
    }
}
endif;

if( ! function_exists( 'blossom_floral_secondary_menu_fallback' ) ) :
/**
 * Fallback for secondary menu
*/
function blossom_floral_secondary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<div class="menu-secondary-container">';
        echo '<ul id="secondary-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'blossom-floral' ) . '</a></li>';
        echo '</ul>';
        echo '</div>';
    }
}
endif;

if( ! function_exists( 'blossom_floral_site_branding' ) ) :
/**
 * Site Branding
*/
function blossom_floral_site_branding( $mobile = false ){ 
    $site_title       = get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    $header_text      = get_theme_mod( 'header_text', 1 );
    
    if( has_custom_logo() || $site_title || $site_description || $header_text ) : 
        if( has_custom_logo() && ( $site_title || $site_description ) && $header_text ) {
            $branding_class = ' has-image-text';
        }else{
            $branding_class = '';
        } ?>
        <div class="site-branding<?php echo esc_attr( $branding_class ); ?>" itemscope itemtype="http://schema.org/Organization">
            <?php 
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    echo '<div class="site-logo">';
                    the_custom_logo();
                    echo '</div>';
                } 
                if( $site_title || $site_description ) :
                    echo '<div class="site-title-wrap">';
                    if( is_front_page() && !$mobile ){ ?>
                        <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php 
                    }else{ ?>
                        <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                    }
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ){ ?>
                        <p class="site-description" itemprop="description"><?php echo $description; ?></p>
                    <?php }
                    echo '</div>';
                endif; 
            ?>
        </div>    
    <?php endif;
}
endif;

if( ! function_exists( 'blossom_floral_search' ) ) :
/**
 * Search form Section
*/
function blossom_floral_search(){ 
    $ed_search = get_theme_mod( 'ed_header_search', false ); 
    if( $ed_search ){ ?>
        <div class="header-search">
            <button class="search-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.197" height="16.546"
                    viewBox="0 0 16.197 16.546">
                    <path id="icons8-search"
                        d="M9.939,3a5.939,5.939,0,1,0,3.472,10.754l4.6,4.585.983-.983L14.448,12.8A5.939,5.939,0,0,0,9.939,3Zm0,.7A5.24,5.24,0,1,1,4.7,8.939,5.235,5.235,0,0,1,9.939,3.7Z"
                        transform="translate(-3.5 -2.5)" fill="#222" stroke="#222" stroke-width="1"
                        opacity="0.8"></path>
                </svg>
            </button>
            <div class="header-search-wrap">
                <div class="header-search-inner">
                    <button class="close"></button>
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    <?php }
    }
endif;

if( ! function_exists( 'blossom_floral_header_cart' ) ) :
/**
 * Header cart
*/
function blossom_floral_header_cart(){ 
    $ed_cart   = get_theme_mod( 'ed_shopping_cart', false ); ?>
    <div class="header-cart">
        <?php 
            if( blossom_floral_social_links( false ) || ( blossom_floral_is_woocommerce_activated() && $ed_cart ) ){
                if( blossom_floral_is_woocommerce_activated() && $ed_cart ) blossom_floral_wc_cart_count();
                if( blossom_floral_is_woocommerce_activated() && $ed_cart && blossom_floral_social_links( false ) ) echo '<span class="separator"></span>';
            }                                    
        ?>
    </div>
<?php }
endif;

if( ! function_exists( 'blossom_floral_primary_nagivation' ) ) :
    /**
     * Primary Navigation.
    */
    function blossom_floral_primary_nagivation(){
        if( current_user_can( 'manage_options' ) || has_nav_menu( 'primary' ) ) { ?>
            <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <button class="toggle-btn">
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                </button>
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'fallback_cb'    => 'blossom_floral_primary_menu_fallback',
                    ) );
                ?>
            </nav><!-- #site-navigation -->
            <?php
        }
    }
    endif;
    
if( ! function_exists( 'blossom_floral_primary_menu_fallback' ) ) :
/**
 * Fallback for primary menu
*/
function blossom_floral_primary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="primary-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'blossom-floral' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'blossom_floral_mobile_navigation' ) ) :
/**
 * Mobile Navigation
*/
function blossom_floral_mobile_navigation(){ 
    ?>
    <div class="mobile-header">
        <div class="header-main">
            <div class="container">
                <div class="mob-nav-site-branding-wrap">
                    <div class="header-center">
                        <?php blossom_floral_site_branding( true ); ?>
                    </div>
                    <div class="header-left">
                        <?php blossom_floral_search(); ?>
                        <div class="toggle-btn-wrap">
                            <button class="toggle-btn">
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                                <span class="toggle-bar"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom-slide">
            <div class="header-bottom-slide-inner" style="top: 32px;">
                <div class="container">
                    <div class="mobile-header-wrap">
                        <button class="close"></button>
                        <?php blossom_floral_search(); ?>
                    </div>
                    <div class="mobile-header-wrapper">
                        <div class="header-left">
                            <?php blossom_floral_primary_nagivation(); ?>
                        </div>
                        <div class="header-right">
                            <?php blossom_floral_secondary_navigation(); ?>
                        </div>
                    </div>
                    <div class="header-social-wrapper">
                        <div class="header-social">
                            <?php blossom_floral_social_links(); ?>
                        </div>
                        <?php blossom_floral_header_cart(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
endif;

if( ! function_exists( 'blossom_floral_posts_per_page_count' ) ):
/**
*   Counts the Number of total posts in Archive, Search and Author
*/
function blossom_floral_posts_per_page_count(){

    global $wp_query;
    if( is_archive() || is_search() && $wp_query->found_posts > 0 ) {
        $posts_per_page = get_option( 'posts_per_page' );
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $start_post_number = 0;
        $end_post_number   = 0;

        if( $wp_query->found_posts > 0 && !( blossom_floral_is_woocommerce_activated() && is_shop() ) ):                
            $start_post_number = 1;
            if( $wp_query->found_posts < $posts_per_page  ) {
                $end_post_number = $wp_query->found_posts;
            }else{
                $end_post_number = $posts_per_page;
            }

            if( $paged > 1 ){
                $start_post_number = $posts_per_page * ( $paged - 1 ) + 1;
                if( $wp_query->found_posts < ( $posts_per_page * $paged )  ) {
                    $end_post_number = $wp_query->found_posts;
                }else{
                    $end_post_number = $paged * $posts_per_page;
                }
            }

            printf( esc_html__( '%1$s Showing: %2$s - %3$s of %4$s Articles %5$s', 'blossom-floral' ), '<span class="result-count">', absint( $start_post_number ), absint( $end_post_number ), esc_html( number_format_i18n( $wp_query->found_posts ) ), '</span>' );
        endif;
    }
}
endif;

if( ! function_exists( 'blossom_floral_footer_navigation' ) ) :
/**
 * Footer Navigation
*/
function blossom_floral_footer_navigation(){ 
    if( current_user_can( 'manage_options' ) || has_nav_menu( 'footer' ) ) { ?>
        <nav class="footer-navigation">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'nav-menu',
                    'menu_id'        => 'footer-menu',
                    'fallback_cb'    => 'blossom_floral_footer_menu_fallback',
                ) );
            ?>
        </nav>
    <?php }
}
endif;
    
if( ! function_exists( 'blossom_floral_footer_menu_fallback' ) ) :
/**
 * Fallback for footer menu
*/
function blossom_floral_footer_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="footer-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'blossom-floral' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'blossom_floral_estimated_reading_time' ) ) :
/** 
 * Reading Time Calculate Function 
*/
function blossom_floral_estimated_reading_time( $content ) {
    if( !get_theme_mod( 'ed_post_read_calc', false ) ) {
        $wpm           = get_theme_mod( 'read_words_per_minute', 200 );
        $clean_content = strip_shortcodes( $content );
        $clean_content = strip_tags( $clean_content );
        $word_count    = str_word_count( $clean_content );
        $time          = ceil( $word_count / $wpm );
        echo '<span class="post-read-time">' . absint( $time ) . esc_html__( ' min read', 'blossom-floral' ) . '</span>';
    }
}
endif;

/**
 * Is BlossomThemes Email Newsletters active or not
 */
function blossom_floral_is_btnw_activated()
{
    return class_exists('Blossomthemes_Email_Newsletter') ? true : false;
}

/**
 * Is BlossomThemes Social Feed active or not
 */
function blossom_floral_is_btif_activated()
{
    return class_exists('Blossomthemes_Instagram_Feed') ? true : false;
}

/**
 * Is Blossom Theme Toolkit active or not
 */
function blossom_floral_is_bttk_activated()
{
    return class_exists('Blossomthemes_Toolkit') ? true : false;
}

/**
 * Query WooCommerce activation
 */
function blossom_floral_is_woocommerce_activated()
{
    return class_exists('woocommerce') ? true : false;
}