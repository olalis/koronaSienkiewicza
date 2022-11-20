<?php

/**
 * General Settings
 *
 * @package blossom_floral
 */

function blossom_floral_customize_register_general($wp_customize) {

    /** General Settings */
    $wp_customize->add_panel(
        'general_settings',
        array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __('General Settings', 'blossom-floral'),
            'description' => __('Customize Banner, Featured, Social, Sharing, SEO, Post/Page, Newsletter & Instagram, Shop, Performance and Miscellaneous settings.', 'blossom-floral'),
        )
    );

    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __('Header Settings', 'blossom-floral'),
            'priority' => 8,
            'panel'    => 'general_settings',
        )
    );

    /** Upload Header image */
    $wp_customize->add_setting(
        'header_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'header_bg_image',
            array(
                'label'           => __('Header Background Image', 'blossom-floral'),
                'section'         => 'header_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'header_bg_image_two',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'header_bg_image_two',
            array(
                'label'           => __('Header Secondary Image', 'blossom-floral'),
                'section'         => 'header_settings',
            )
        )
    );

    /** Header Search */
    $wp_customize->add_setting(
        'ed_header_search',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_header_search',
            array(
                'section'        => 'header_settings',
                'label'            => __('Header Search', 'blossom-floral'),
                'description'    => __('Enable to display search form in header.', 'blossom-floral'),
            )
        )
    );

    if ( blossom_floral_is_woocommerce_activated() ) {
        /** Shop Cart*/
        $wp_customize->add_setting(
            'ed_shopping_cart',
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Toggle_Control(
                $wp_customize,
                'ed_shopping_cart',
                array(
                    'section'     => 'header_settings',
                    'label'          => __('Shopping Cart', 'blossom-floral'),
                    'description' => __('Enable to show Shopping cart in the header.', 'blossom-floral'),
                )
            )
        );
    }

    /**===== Header Ends ===== */

    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __('Social Media Settings', 'blossom-floral'),
            'priority' => 35,
            'panel'    => 'general_settings',
        )
    );

    /** Enable Social Links */
    $wp_customize->add_setting(
        'ed_social_links',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_social_links',
            array(
                'section'     => 'social_media_settings',
                'label'          => __('Enable Social Links', 'blossom-floral'),
                'description' => __('Enable to show social links at header.', 'blossom-floral'),
            )
        )
    );

    $wp_customize->add_setting(
        new Blossom_Floral_Repeater_Setting(
            $wp_customize,
            'social_links',
            array(
                'default' => array(
                    array(
                        'font' => 'fab fa-facebook-f',
                        'link' => 'https://www.facebook.com/',
                    ),
                    array(
                        'font' => 'fab fa-twitter',
                        'link' => 'https://twitter.com/',
                    ),
                    array(
                        'font' => 'fab fa-youtube',
                        'link' => 'https://www.youtube.com/',
                    ),
                    array(
                        'font' => 'fab fa-instagram',
                        'link' => 'https://www.instagram.com/',
                    ),
                    array(
                        'font' => 'fab fa-pinterest',
                        'link' => 'https://www.pinterest.com/',
                    )
                ),
                'sanitize_callback' => array('Blossom_Floral_Repeater_Setting', 'sanitize_repeater_setting'),
            )
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Control_Repeater(
            $wp_customize,
            'social_links',
            array(
                'section' => 'social_media_settings',
                'label'      => __('Social Links', 'blossom-floral'),
                'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __('Font Awesome Icon', 'blossom-floral'),
                        'description' => __('Example: fab fa-facebook-f', 'blossom-floral'),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __('Link', 'blossom-floral'),
                        'description' => __('Example: https://facebook.com', 'blossom-floral'),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __('links', 'blossom-floral'),
                    'field' => 'link'
                )
            )
        )
    );
    /**===== Social Media Settings Ends ====*/

    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __('SEO Settings', 'blossom-floral'),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );

    /** Enable Social Links */
    $wp_customize->add_setting(
        'ed_post_update_date',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_post_update_date',
            array(
                'section'     => 'seo_settings',
                'label'          => __('Enable Last Update Post Date', 'blossom-floral'),
                'description' => __('Enable to show last updated post date on listing as well as in single post.', 'blossom-floral'),
            )
        )
    );

    /** Enable Social Links */
    $wp_customize->add_setting(
        'ed_breadcrumb',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'          => __('Enable Breadcrumb', 'blossom-floral'),
                'description' => __('Enable to show breadcrumb in inner pages.', 'blossom-floral'),
            )
        )
    );

    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __('Home', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __('Breadcrumb Home Text', 'blossom-floral'),
        )
    );
    /** ==== SEO Settings Ends ==== */

    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __('Posts(Blog) & Pages Settings', 'blossom-floral'),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );

    /** Prefix Archive Page */
    $wp_customize->add_setting(
        'ed_prefix_archive',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_prefix_archive',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Hide Prefix in Archive Page', 'blossom-floral'),
                'description' => __('Enable to hide prefix in archive page.', 'blossom-floral'),
            )
        )
    );

    /** Blog Post Image Crop */
    $wp_customize->add_setting(
        'ed_crop_blog',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_crop_blog',
            array(
                'section'     => 'post_page_settings',
                'label'       => __('Blog Post Image Crop', 'blossom-floral'),
                'description' => __('Enable to avoid automatic cropping of featured image in home, archive and search posts.', 'blossom-floral'),
            )
        )
    );

    /** Blog Excerpt */
    $wp_customize->add_setting(
        'ed_excerpt',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_excerpt',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Enable Blog Excerpt', 'blossom-floral'),
                'description' => __('Enable to show excerpt or disable to show full post content.', 'blossom-floral'),
            )
        )
    );

    /** Excerpt Length */
    $wp_customize->add_setting(
        'excerpt_length',
        array(
            'default'           => 30,
            'sanitize_callback' => 'blossom_floral_sanitize_number_absint'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Slider_Control(
            $wp_customize,
            'excerpt_length',
            array(
                'section'      => 'post_page_settings',
                'label'          => __('Excerpt Length', 'blossom-floral'),
                'description' => __('Automatically generated excerpt length (in words).', 'blossom-floral'),
                'choices'      => array(
                    'min'     => 10,
                    'max'     => 100,
                    'step'    => 5,
                )
            )
        )
    );

    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Note_Control(
            $wp_customize,
            'post_note_text',
            array(
                'section'      => 'post_page_settings',
                'description' => sprintf(__('%s These options affect your individual posts.', 'blossom-floral'), '<hr/>'),
            )
        )
    );
    $wp_customize->add_setting(
        'ed_post_read_calc',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_post_read_calc',
            array(
                'section'     => 'post_page_settings',
                'label'       => __('Hide Read Time', 'blossom-floral'),
                'description' => __('Enable to hide post Reading Time.', 'blossom-floral'),
            )
        )
    );

    /** Excerpt Length */
    $wp_customize->add_setting(
        'read_words_per_minute',
        array(
            'default'           => 200,
            'sanitize_callback' => 'blossom_floral_sanitize_number_absint'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Slider_Control(
            $wp_customize,
            'read_words_per_minute',
            array(
                'section'     => 'post_page_settings',
                'label'       => __('Words Per Minute', 'blossom-floral'),
                'description' => __('Blog Posts Content Words Reading Speed Per Minute.', 'blossom-floral'),
                'choices'     => array(
                    'min'   => 100,
                    'max'   => 1000,
                    'step'  => 10,
                )
            )
        )
    );

    /** Single Post Image Crop */
    $wp_customize->add_setting(
        'ed_crop_single',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_crop_single',
            array(
                'section'     => 'post_page_settings',
                'label'       => __('Single Post Image Crop', 'blossom-floral'),
                'description' => __('Enable to avoid automatic cropping of featured image in single post.', 'blossom-floral'),
            )
        )
    );

    /** Hide Author Section */
    $wp_customize->add_setting(
        'ed_author',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_author',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Hide Author Section', 'blossom-floral'),
                'description' => __('Enable to hide author section.', 'blossom-floral'),
            )
        )
    );

    /** Author Section title */
    $wp_customize->add_setting(
        'author_title',
        array(
            'default'           => __('About The Author', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'author_title',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __('Author Section Title', 'blossom-floral'),
        )
    );

    $wp_customize->selective_refresh->add_partial('author_title', array(
        'selector' => '.author-section .title',
        'render_callback' => 'blossom_floral_get_author_title',
    ));

    /** Show Related Posts */
    $wp_customize->add_setting(
        'ed_related',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_related',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Show Related Posts', 'blossom-floral'),
                'description' => __('Enable to show related posts in single page.', 'blossom-floral'),
            )
        )
    );

    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __('You may also like...', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __('Related Posts Section Title', 'blossom-floral'),
            'active_callback' => 'blossom_floral_post_page_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial('related_post_title', array(
        'selector' => '.related-posts .title',
        'render_callback' => 'blossom_floral_get_related_title',
    ));

    /** Comments */
    $wp_customize->add_setting(
        'ed_comments',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_comments',
            array(
                'section'     => 'post_page_settings',
                'label'       => __('Show Comments', 'blossom-floral'),
                'description' => __('Enable to show Comments in Single Post/Page.', 'blossom-floral'),
            )
        )
    );

    /** Comments Below Post Content */
    $wp_customize->add_setting(
        'toggle_comments',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'toggle_comments',
            array(
                'section'         => 'post_page_settings',
                'label'           => __('Comments Below Post Content', 'blossom-floral'),
                'description'     => __('Enable to show comment section right after post content. Refresh site for changes.', 'blossom-floral'),
                'active_callback' => 'blossom_floral_post_page_ac'
            )
        )
    );

    /** Hide Category */
    $wp_customize->add_setting(
        'ed_category',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_category',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Hide Category', 'blossom-floral'),
                'description' => __('Enable to hide category.', 'blossom-floral'),
            )
        )
    );

    /** Hide Post Author */
    $wp_customize->add_setting(
        'ed_post_author',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Hide Post Author', 'blossom-floral'),
                'description' => __('Enable to hide post author.', 'blossom-floral'),
            )
        )
    );

    /** Hide Posted Date */
    $wp_customize->add_setting(
        'ed_post_date',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_post_date',
            array(
                'section'     => 'post_page_settings',
                'label'          => __('Hide Posted Date', 'blossom-floral'),
                'description' => __('Enable to hide posted date.', 'blossom-floral'),
            )
        )
    );

    /** Show Featured Image */
    $wp_customize->add_setting(
        'ed_featured_image',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'ed_featured_image',
            array(
                'section'         => 'post_page_settings',
                'label'              => __('Show Featured Image', 'blossom-floral'),
                'description'     => __('Enable to show featured image in post detail (single post).', 'blossom-floral'),
            )
        )
    );

    /**===== Posts(Blog) & Pages Settings Ends =====*/
    
    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __('Misc Settings', 'blossom-floral'),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );

    /** Search Page Title  */
    $wp_customize->add_setting(
        'search_title',
        array(
            'default'           => __('Search Result For', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'search_title',
        array(
            'label'       => __('Search Page Title', 'blossom-floral'),
            'description' => __('You can change title of your search page from here.', 'blossom-floral'),
            'section'     => 'misc_settings',
            'type'        => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial('search_title', array(
        'selector'        => '.search .site-content .page-header__content-wrapper h1.page-title',
        'render_callback' => 'blossom_floral_get_search_title',
    ));

    /** Portfolio Related Projects Title  */
    $wp_customize->add_setting(
        'related_portfolio_title',
        array(
            'default'           => __('Related Projects', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'related_portfolio_title',
        array(
            'label'       => __('Portfolio Related Projects Title', 'blossom-floral'),
            'description' => __('You can change title of your portfolio related projects from here.', 'blossom-floral'),
            'section'     => 'misc_settings',
            'type'        => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial('related_portfolio_title', array(
        'selector'        => '.related-portfolio .related-portfolio-title',
        'render_callback' => 'blossom_floral_get_related_portfolio_title',
    ));

    $wp_customize->add_setting(
        'error_show_image',
        array(
            'default'           => get_template_directory_uri() . '/images/404-image.png',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'error_show_image',
            array(
                'label'         => esc_html__('Add 404 Image', 'blossom-floral'),
                'description'   => esc_html__('Choose Image of your choice. Recommended size for this image is 432px by 652px.', 'blossom-floral'),
                'section'       => 'misc_settings',
                'type'          => 'image',
            )
        )
    );
    /**===== Misc Settings ===== */

}
add_action('customize_register', 'blossom_floral_customize_register_general');
