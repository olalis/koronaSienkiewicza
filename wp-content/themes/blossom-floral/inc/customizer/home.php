<?php

/**
 * Front Page Settings
 *
 * @package blossom_floral
 */

function blossom_floral_customize_register_frontpage($wp_customize) {

    /** Front Page Settings */
    $wp_customize->add_panel(
        'frontpage_settings',
        array(
            'priority'    => 55,
            'capability'  => 'edit_theme_options',
            'title'       => __('Front Page Settings', 'blossom-floral'),
            'description' => __('Customize Banner, Featured, Service, About, Newsletter, Instagram & Shop settings.', 'blossom-floral'),
        )
    );

    $wp_customize->get_section('header_image')->panel                    = 'frontpage_settings';
    $wp_customize->get_section('header_image')->title                    = __('Banner Section', 'blossom-floral');
    $wp_customize->get_section('header_image')->priority                 = 10;
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->remove_control( 'header_image' );                
    $wp_customize->remove_control( 'header_video' );             
    $wp_customize->remove_control( 'external_header_video' );       

    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'            => 'slider_banner',
            'sanitize_callback' => 'blossom_floral_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'          => __('Banner Options', 'blossom-floral'),
                'description' => __('Choose banner as static image/video or as a slider.', 'blossom-floral'),
                'section'     => 'header_image',
                'choices'     => array(
                    'no_banner'        => __('Disable Banner Section', 'blossom-floral'),
                    'slider_banner'    => __('Banner as Slider', 'blossom-floral'),
                ),
                'priority' => 5
            )
        )
    );

    /** Slider Content Style */
    $wp_customize->add_setting(
        'slider_type',
        array(
            'default'            => 'latest_posts',
            'sanitize_callback' => 'blossom_floral_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Select_Control(
            $wp_customize,
            'slider_type',
            array(
                'label'      => __('Slider Content Style', 'blossom-floral'),
                'section' => 'header_image',
                'choices' => array(
                    'latest_posts' => __('Latest Posts', 'blossom-floral'),
                    'cat'          => __('Category', 'blossom-floral')
                ),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** Slider Category */
    $wp_customize->add_setting(
        'slider_cat',
        array(
            'default'            => '',
            'sanitize_callback' => 'blossom_floral_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Select_Control(
            $wp_customize,
            'slider_cat',
            array(
                'label'              => __('Slider Category', 'blossom-floral'),
                'section'         => 'header_image',
                'choices'         => blossom_floral_get_categories(),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'blossom_floral_sanitize_number_absint'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Slider_Control(
            $wp_customize,
            'no_of_slides',
            array(
                'section'     => 'header_image',
                'label'       => __('Number of Slides', 'blossom-floral'),
                'description' => __('Choose the number of slides you want to display', 'blossom-floral'),
                'choices'      => array(
                    'min'     => 1,
                    'max'     => 20,
                    'step'    => 1,
                ),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** HR */
    $wp_customize->add_setting(
        'banner_hr',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Note_Control(
            $wp_customize,
            'banner_hr',
            array(
                'section'      => 'header_image',
                'description' => '<hr/>',
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** Include Repetitive Posts */
    $wp_customize->add_setting(
        'include_repetitive_posts',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'include_repetitive_posts',
            array(
                'section'         => 'header_image',
                'label'           => __('Include Repetitive Posts', 'blossom-floral'),
                'description'     => __('Enable to add posts included in slider in blog page too.', 'blossom-floral'),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** Slider Auto */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'slider_auto',
            array(
                'section'     => 'header_image',
                'label'       => __('Slider Auto', 'blossom-floral'),
                'description' => __('Enable slider auto transition.', 'blossom-floral'),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** Slider Loop */
    $wp_customize->add_setting(
        'slider_loop',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'slider_loop',
            array(
                'section'     => 'header_image',
                'label'       => __('Slider Loop', 'blossom-floral'),
                'description' => __('Enable slider loop.', 'blossom-floral'),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** Slider Caption */
    $wp_customize->add_setting(
        'slider_caption',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_floral_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Toggle_Control(
            $wp_customize,
            'slider_caption',
            array(
                'section'     => 'header_image',
                'label'       => __('Slider Caption', 'blossom-floral'),
                'description' => __('Enable slider caption.', 'blossom-floral'),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /** Slider Animation */
    $wp_customize->add_setting(
        'slider_animation',
        array(
            'default'            => '',
            'sanitize_callback' => 'blossom_floral_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Select_Control(
            $wp_customize,
            'slider_animation',
            array(
                'label'          => __('Slider Animation', 'blossom-floral'),
                'section'     => 'header_image',
                'choices'     => array(
                    'bounceOut'      => __('Bounce Out', 'blossom-floral'),
                    'bounceOutLeft'  => __('Bounce Out Left', 'blossom-floral'),
                    'bounceOutRight' => __('Bounce Out Right', 'blossom-floral'),
                    'bounceOutUp'    => __('Bounce Out Up', 'blossom-floral'),
                    'bounceOutDown'  => __('Bounce Out Down', 'blossom-floral'),
                    'fadeOut'        => __('Fade Out', 'blossom-floral'),
                    'fadeOutLeft'    => __('Fade Out Left', 'blossom-floral'),
                    'fadeOutRight'   => __('Fade Out Right', 'blossom-floral'),
                    'fadeOutUp'      => __('Fade Out Up', 'blossom-floral'),
                    'fadeOutDown'    => __('Fade Out Down', 'blossom-floral'),
                    'flipOutX'       => __('Flip OutX', 'blossom-floral'),
                    'flipOutY'       => __('Flip OutY', 'blossom-floral'),
                    'hinge'          => __('Hinge', 'blossom-floral'),
                    'pulse'          => __('Pulse', 'blossom-floral'),
                    'rollOut'        => __('Roll Out', 'blossom-floral'),
                    'rotateOut'      => __('Rotate Out', 'blossom-floral'),
                    'rubberBand'     => __('Rubber Band', 'blossom-floral'),
                    'shake'          => __('Shake', 'blossom-floral'),
                    ''               => __('Slide', 'blossom-floral'),
                    'slideOutLeft'   => __('Slide Out Left', 'blossom-floral'),
                    'slideOutRight'  => __('Slide Out Right', 'blossom-floral'),
                    'slideOutUp'     => __('Slide Out Up', 'blossom-floral'),
                    'slideOutDown'   => __('Slide Out Down', 'blossom-floral'),
                    'swing'          => __('Swing', 'blossom-floral'),
                    'tada'           => __('Tada', 'blossom-floral'),
                    'zoomOut'        => __('Zoom Out', 'blossom-floral'),
                    'zoomOutLeft'    => __('Zoom Out Left', 'blossom-floral'),
                    'zoomOutRight'   => __('Zoom Out Right', 'blossom-floral'),
                    'zoomOutUp'      => __('Zoom Out Up', 'blossom-floral'),
                    'zoomOutDown'    => __('Zoom Out Down', 'blossom-floral'),
                ),
                'active_callback' => 'blossom_floral_banner_ac'
            )
        )
    );

    /**====== BANNER SECTION ENDS ====== */

    /** About Section */
    $wp_customize->add_section(
        'about',
        array(
            'title'    => __('About Section', 'blossom-floral'),
            'priority' => 30,
            'panel'    => 'frontpage_settings',
        )
    );

    /**Background image */
    $wp_customize->add_setting(
        'about_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'about_bg_image',
            array(
                'label'         => esc_html__('Background Image', 'blossom-floral'),
                'description'   => esc_html__('Choose background Image of your choice. The recommended size for image is 1920px by 780px in JPG format.', 'blossom-floral'),
                'section'       => 'about',
                'type'          => 'image',
                'priority'      => -1
            )
        )
    );

    $wp_customize->add_setting(
        'about_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $wp_customize->add_control(
        new Blossom_Floral_Note_Control(
            $wp_customize,
            'about_note_text',
            array(
                'section'     => 'about',
                'description' => __('<hr/>Add "Blossom: Featured Page" widget for about section.', 'blossom-floral'),
                'priority'    => -1
            )
        )
    );

    $about_section = $wp_customize->get_section('sidebar-widgets-about');
    if (!empty($about_section)) {

        $about_section->panel     = 'frontpage_settings';
        $about_section->priority  = 30;
        $wp_customize->get_control('about_note_text')->section = 'sidebar-widgets-about';
        $wp_customize->get_control('about_bg_image')->section  = 'sidebar-widgets-about';
    }
    
    /**===== About Section Ends =====*/

    /** Blog Settings */
    $wp_customize->add_section(
        'blog_settings',
        array(
            'title'    => __('Blog Section', 'blossom-floral'),
            'priority' => 40,
            'panel'    => 'frontpage_settings',
        )
    );

    // blog Title
    $wp_customize->add_setting(
        'blog_text',
        array(
            'default'           => __('From The Blog', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'blog_text',
        array(
            'label'   => __('Blog Title', 'blossom-floral'),
            'section' => 'blog_settings',
            'type'    => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial('blog_text', array(
        'selector' => '.section-header .blog-title',
        'render_callback' => 'blossom_floral_get_blog_text',
    ));

    // Blog Description
    $wp_customize->add_setting(
        'blog_content',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'blog_content',
        array(
            'label'   => __('Blog Description', 'blossom-floral'),
            'section' => 'blog_settings',
            'type'    => 'textarea',
        )
    );

    $wp_customize->selective_refresh->add_partial('blog_content', array(
        'selector' => '.section-header .section-desc.blog-content',
        'render_callback' => 'blossom_floral_get_blog_content',
    ));

    /** Read More Text */
    $wp_customize->add_setting(
        'read_more_text',
        array(
            'default'           => __('READ THE ARTICLE', 'blossom-floral'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'read_more_text',
        array(
            'type'    => 'text',
            'section' => 'blog_settings',
            'label'   => __('Read More Text', 'blossom-floral'),
        )
    );

    $wp_customize->selective_refresh->add_partial('read_more_text', array(
        'selector' => '.entry-footer .button-wrap .btn-link',
        'render_callback' => 'blossom_floral_get_read_more',
    ));

    $wp_customize->add_setting(
        'top_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'top_bg_image',
            array(
                'label'           => __('Background Image One', 'blossom-floral'),
                'description'     => __('This will appear at the top of blog content. The recommended size for image is 1044px by 783px in PNG format.', 'blossom-floral'),
                'section'         => 'blog_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'content_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'content_bg_image',
            array(
                'label'           => __('Background Image Two', 'blossom-floral'),
                'description'     => __('This will appear at the bottom of the blog content. The recommended size for image is 1920 px by 2138px in PNG format.', 'blossom-floral'),
                'section'         => 'blog_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'left_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'left_bg_image',
            array(
                'label'           => __('Background Image Three', 'blossom-floral'),
                'description'     => __('This will appear at the left side of blog content. The recommended size for image is 484px by 1027px in PNG format.', 'blossom-floral'),
                'section'         => 'blog_settings',
            )
        )
    );

    $wp_customize->add_setting(
        'right_bg_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_floral_sanitize_image',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'right_bg_image',
            array(
                'label'           => __('Background Image Four', 'blossom-floral'),
                'description'     => __('This will appear at the right side of blog content. The recommended size for image is 465px by 998px in PNG format.', 'blossom-floral'),
                'section'         => 'blog_settings',
            )
        )
    );

    /**===== Blog Section ===== */

    /** Newsletter Settings */
    $wp_customize->add_section(
        'newsletter_settings',
        array(
            'title'    => __('Newsletter Settings', 'blossom-floral'),
            'priority' => 60,
            'panel'    => 'frontpage_settings',
        )
    );

    if ( blossom_floral_is_btnw_activated()) {

        /** Enable Newsletter Section */
        $wp_customize->add_setting(
            'ed_newsletter',
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Toggle_Control(
                $wp_customize,
                'ed_newsletter',
                array(
                    'section'     => 'newsletter_settings',
                    'label'          => __('Newsletter Section', 'blossom-floral'),
                    'description' => __('Enable to show Newsletter Section', 'blossom-floral'),
                )
            )
        );

        /** Newsletter Shortcode */
        $wp_customize->add_setting(
            'newsletter_shortcode',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            'newsletter_shortcode',
            array(
                'type'        => 'text',
                'section'     => 'newsletter_settings',
                'label'       => __('Newsletter Shortcode', 'blossom-floral'),
                'description' => __('Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'blossom-floral'),
            )
        );

        $wp_customize->add_setting(
            'newsletter_image',
            array(
                'default'           => '',
                'sanitize_callback' => 'blossom_floral_sanitize_image',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'newsletter_image',
                array(
                    'label'      => __('Primary Image', 'blossom-floral'),
                    'description' => __('Choose image to be displayed beside the newsletter. The recommended size for image is 570px by 570px in JPG format.', 'blossom-floral'),
                    'section'    => 'newsletter_settings',
                )
            )
        );

        $wp_customize->add_setting(
            'newsletter_bg_image',
            array(
                'default'           => '',
                'sanitize_callback' => 'blossom_floral_sanitize_image',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'newsletter_bg_image',
                array(
                    'label'      => __('Background Image', 'blossom-floral'),
                    'description' => __('Choose background Image of your choice. The recommended size for image is 1920px by 854px in JPG format.', 'blossom-floral'),
                    'section'    => 'newsletter_settings',
                )
            )
        );
    } else {
        $wp_customize->add_setting(
            'newsletter_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Plugin_Recommend_Control(
                $wp_customize,
                'newsletter_recommend',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __('Newsletter Shortcode', 'blossom-floral'),
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-email-newsletter', //This is the slug of recommended plugin.
                    'description' => sprintf(__('Please install and activate the recommended plugin %1$sBlossomThemes Email Newsletter%2$s. After that option related with this section will be visible.', 'blossom-floral'), '<strong>', '</strong>'),
                )
            )
        );
    }

    /**===== Newsletter Section ===== */

    /** Shop Settings */
    $wp_customize->add_section(
        'shop_settings',
        array(
            'title'    => __('Shop Section', 'blossom-floral'),
            'priority' => 56,
            'panel'    => 'frontpage_settings',
        )
    );

    if (blossom_floral_is_woocommerce_activated()) {

        /** Shop Section */
        $wp_customize->add_setting(
            'ed_top_shop_section',
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Toggle_Control(
                $wp_customize,
                'ed_top_shop_section',
                array(
                    'section'     => 'shop_settings',
                    'label'          => __('Shop Section', 'blossom-floral'),
                    'description' => __('Enable to show Shop Section below Featured Section', 'blossom-floral'),
                )
            )
        );

        /** Related Post Taxonomy */
        $wp_customize->add_setting(
            'shop_bg',
            array(
                'default'           => 'image',
                'sanitize_callback' => 'blossom_floral_sanitize_radio'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Radio_Buttonset_Control(
                $wp_customize,
                'shop_bg',
                array(
                    'section'      => 'shop_settings',
                    'label'       => __('Shop Background', 'blossom-floral'),
                    'description' => __('Choose background of shop section. The recommended size for image is 1920px by 976px in PNG format', 'blossom-floral'),
                    'choices'      => array(
                        'image'  => __('Image', 'blossom-floral'),
                        'color'  => __('Color', 'blossom-floral'),
                    ),
                )
            )
        );

        $wp_customize->add_setting(
            'shop_bg_image',
            array(
                'default'             => '',
                'sanitize_callback' => 'blossom_floral_sanitize_image'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'shop_bg_image',
                array(
                    'label'             => __('Upload an image', 'blossom-floral'),
                    'section'           => 'shop_settings',
                    'active_callback'   => 'blossom_floral_shop_sec_ac'
                )
            )
        );

        $wp_customize->add_setting(
            'shop_bg_color',
            array(
                'default'           => '#F2CAB3',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );


        // Add Controls
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'shop_bg_color',
                array(
                    'label'             => 'Shop Background Color',
                    'section'           => 'shop_settings',
                    'active_callback'   => 'blossom_floral_shop_sec_ac'
                )
            )
        );

        /** Shop Section Title */
        $wp_customize->add_setting(
            'shop_section_title',
            array(
                'default'           => __('My Shop', 'blossom-floral'),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'shop_section_title',
            array(
                'type'        => 'text',
                'section'     => 'shop_settings',
                'label'       => __('Shop Section Title', 'blossom-floral'),
            )
        );

        $wp_customize->selective_refresh->add_partial('shop_section_title', array(
            'selector' => '.product-section .section-header h2.section-title',
            'render_callback' => 'blossom_floral_get_shop_title',
        ));

        /** Shop Section Content */
        $wp_customize->add_setting(
            'shop_section_content',
            array(
                'default'           => __('This option can be change from Customize > General Settings > Shop settings.', 'blossom-floral'),
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'shop_section_content',
            array(
                'type'        => 'textarea',
                'section'     => 'shop_settings',
                'label'       => __('Shop Section Content', 'blossom-floral'),
            )
        );

        $wp_customize->selective_refresh->add_partial('shop_section_content', array(
            'selector' => '.product-section .section-header .section-desc',
            'render_callback' => 'blossom_floral_get_shop_content',
        ));

        $wp_customize->add_setting(
            'product_type',
            array(
                'default'            => 'custom',
                'sanitize_callback' => 'blossom_floral_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Select_Control(
                $wp_customize,
                'product_type',
                array(
                    'label'      => __('Product Category', 'blossom-floral'),
                    'section' => 'shop_settings',
                    'choices' => array(
                        'custom'            => __('Custom Select', 'blossom-floral'),
                        'recent-products'   => __('Recent Products', 'blossom-floral'),
                        'popular-products'  => __('Popular Products', 'blossom-floral'),
                        'sale-products'     => __('Sale Products', 'blossom-floral'),
                    )
                )
            )
        );

        $wp_customize->add_setting(
            'selected_products',
            array(
                'default'            => '',
                'sanitize_callback' => 'blossom_floral_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Select_Control(
                $wp_customize,
                'selected_products',
                array(
                    'label'          => __('Select Products', 'blossom-floral'),
                    'section'     => 'shop_settings',
                    'choices'     => blossom_floral_get_posts('product'),
                    'multiple'    => 4,
                    'active_callback' => 'blossom_floral_shop_sec_ac'
                )
            )
        );

        $wp_customize->add_setting(
            'shop_btn_lbl',
            array(
                'default'           => __('Go To Shop', 'blossom-floral'),
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        $wp_customize->add_control(
            'shop_btn_lbl',
            array(
                'section'         => 'shop_settings',
                'label'           => __('Shop Button Label', 'blossom-floral'),
                'type'            => 'text',
            )
        );

        $wp_customize->selective_refresh->add_partial('shop_btn_lbl', array(
            'selector' => '.product-section .button-wrap a.btn-readmore ',
            'render_callback' => 'blossom_floral_get_shop_btn_lbl',
        ));

        $wp_customize->add_setting(
            'shop_btn_link',
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );

        $wp_customize->add_control(
            'shop_btn_link',
            array(
                'section'         => 'shop_settings',
                'label'           => __('Shop Button Link', 'blossom-floral'),
                'type'            => 'url',
            )
        );
    } else {
        /** Note */
        $wp_customize->add_setting(
            'woocommerce_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Plugin_Recommend_Control(
                $wp_customize,
                'woocommerce_recommend',
                array(
                    'section'     => 'shop_settings',
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'woocommerce', //This is the slug of recommended plugin.
                    'description' => sprintf(__('Please install and activate the recommended plugin %1$sWooCommerce%2$s. After that option related with this section will be visible.', 'blossom-floral'), '<strong>', '</strong>'),
                )
            )
        );
    }
    /**===== Shop Section Ends ===== */

    /** Instagram Settings */
    $wp_customize->add_section(
        'instagram_settings',
        array(
            'title'    => __('Instagram Settings', 'blossom-floral'),
            'priority' => 70,
            'panel'    => 'frontpage_settings',
        )
    );

    if ( blossom_floral_is_btif_activated() ) {
        /** Enable Instagram Section */
        $wp_customize->add_setting(
            'ed_instagram',
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Toggle_Control(
                $wp_customize,
                'ed_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'          => __('Instagram Section', 'blossom-floral'),
                    'description' => __('Enable to show Instagram Section', 'blossom-floral'),
                )
            )
        );

        $wp_customize->add_setting(
            'ed_header_instagram',
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Toggle_Control(
                $wp_customize,
                'ed_header_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'       => __('Enable Instagram in Header', 'blossom-floral'),
                    'description' => __('Enable to show Instagram Section in header', 'blossom-floral'),
                )
            )
        );

        $wp_customize->add_setting(
            'ed_footer_instagram',
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_floral_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Toggle_Control(
                $wp_customize,
                'ed_footer_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'       => __('Enable Instagram in Footer', 'blossom-floral'),
                    'description' => __('Enable to show Instagram Section in footer', 'blossom-floral'),
                )
            )
        );

        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post'
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Note_Control(
                $wp_customize,
                'instagram_text',
                array(
                    'section'      => 'instagram_settings',
                    'description' => sprintf(__('You can change the setting BlossomThemes Social Feed %1$sfrom here%2$s.', 'blossom-floral'), '<a href="' . esc_url(admin_url('admin.php?page=class-blossomthemes-instagram-feed-admin.php')) . '" target="_blank">', '</a>')
                )
            )
        );
    } else {
        $wp_customize->add_setting(
            'instagram_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Blossom_Floral_Plugin_Recommend_Control(
                $wp_customize,
                'instagram_recommend',
                array(
                    'section'     => 'instagram_settings',
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-instagram-feed', //This is the slug of recommended plugin.
                    'description' => sprintf(__('Please install and activate the recommended plugin %1$sBlossomThemes Social Feed%2$s. After that option related with this section will be visible.', 'blossom-floral'), '<strong>', '</strong>'),
                )
            )
        );
    }

    /**===== Instagram Section Ends ===== */
}
add_action('customize_register', 'blossom_floral_customize_register_frontpage');
