<?php
/**
 * Getting Started Page.
 *
 * @package Blossom_Floral
 */

require get_template_directory() . '/inc/getting-started/class-getting-start-plugin-helper.php';

if( ! function_exists( 'blossom_floral_getting_started_menu' ) ) :
/**
 * Adding Getting Started Page in admin menu
 */
function blossom_floral_getting_started_menu(){	
	add_theme_page(
		__( 'Getting Started', 'blossom-floral' ),
		__( 'Getting Started', 'blossom-floral' ),
		'manage_options',
		'blossom-floral-getting-started',
		'blossom_floral_getting_started_page'
	);
}
endif;
add_action( 'admin_menu', 'blossom_floral_getting_started_menu' );

if( ! function_exists( 'blossom_floral_getting_started_admin_scripts' ) ) :
/**
 * Load Getting Started styles in the admin
 */
function blossom_floral_getting_started_admin_scripts( $hook ){
	// Load styles only on our page
	if( 'appearance_page_blossom-floral-getting-started' != $hook ) return;

    wp_enqueue_style( 'blossom-floral-getting-started', get_template_directory_uri() . '/inc/getting-started/css/getting-started.css', false, BLOSSOM_FLORAL_THEME_VERSION );
    
    wp_enqueue_script( 'plugin-install' );
    wp_enqueue_script( 'updates' );
    wp_enqueue_script( 'blossom-floral-getting-started', get_template_directory_uri() . '/inc/getting-started/js/getting-started.js', array( 'jquery' ), BLOSSOM_FLORAL_THEME_VERSION, true );
    wp_localize_script( 'blossom-floral-getting-started', 'blossom_floral_getting_started', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( 'blossom-floral-recommended-plugin-install', get_template_directory_uri() . '/inc/getting-started/js/recommended-plugin-install.js', array( 'jquery' ), BLOSSOM_FLORAL_THEME_VERSION, true );    
    wp_localize_script( 'blossom-floral-recommended-plugin-install', 'blossom_floral_start_page', array( 'activating' => __( 'Activating ', 'blossom-floral' ) ) );
}
endif;
add_action( 'admin_enqueue_scripts', 'blossom_floral_getting_started_admin_scripts' );

if( ! function_exists( 'blossom_floral_call_plugin_api' ) ) :
/**
 * Plugin API
**/
function blossom_floral_call_plugin_api( $plugin ) {
	include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	$call_api = plugins_api( 
        'plugin_information', 
            array(
    		'slug'   => $plugin,
    		'fields' => array(
    			'downloaded'        => false,
    			'rating'            => false,
    			'description'       => false,
    			'short_description' => true,
    			'donate_link'       => false,
    			'tags'              => false,
    			'sections'          => true,
    			'homepage'          => true,
    			'added'             => false,
    			'last_updated'      => false,
    			'compatibility'     => false,
    			'tested'            => false,
    			'requires'          => false,
    			'downloadlink'      => false,
    			'icons'             => true
    		)
    	) 
    );
	return $call_api;
}
endif;

if( ! function_exists( 'blossom_floral_check_for_icon' ) ) :
/**
 * Check For Icon 
**/
function blossom_floral_check_for_icon( $arr ) {
	if( ! empty( $arr['svg'] ) ){
		$plugin_icon_url = $arr['svg'];
	}elseif( ! empty( $arr['2x'] ) ){
		$plugin_icon_url = $arr['2x'];
	}elseif( ! empty( $arr['1x'] ) ){
		$plugin_icon_url = $arr['1x'];
	}else{
		$plugin_icon_url = $arr['default'];
	}                               
	return $plugin_icon_url;
}
endif;

if( ! function_exists( 'blossom_floral_getting_started_page' ) ) :
/**
 * Callback function for admin page.
*/
function blossom_floral_getting_started_page(){ ?>
	<div class="wrap getting-started">
		<h2 class="notices"></h2>
		<div class="intro-wrap">
			<div class="intro">
				<h3><?php printf( esc_html__( 'Getting started with %1$s v%2$s', 'blossom-floral' ), BLOSSOM_FLORAL_THEME_NAME, BLOSSOM_FLORAL_THEME_VERSION ); ?></h3>
				<h4><?php printf( esc_html__( 'You will find everything you need to get started with %1$s below.', 'blossom-floral' ), BLOSSOM_FLORAL_THEME_NAME ); ?></h4>
			</div>
		</div>

		<div class="panels">
			<ul class="inline-list">
				<li class="current">
                    <a id="plugins" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 18">
                            <defs><style>.a{fill:#354052;}</style></defs>
                            <path class="a" d="M16,9v4.66l-3.5,3.51V19h-1V17.17L8,13.65V9h8m0-6H14V7H10V3H8V7H7.99A1.987,1.987,0,0,0,6,8.98V14.5L9.5,18v3h5V18L18,14.49V9a2.006,2.006,0,0,0-2-2Z" transform="translate(-6 -3)"/>
                        </svg>
                        <?php esc_html_e( 'Recommended Plugins', 'blossom-floral' ); ?>
                    </a>
                </li>
				<li>
                    <a id="help" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                            <defs><style>.a{fill:#354052;}</style></defs>
                            <path class="a" d="M12,23H11V16.43A5.966,5.966,0,0,1,7,18a6.083,6.083,0,0,1-6-6V11H7.57A5.966,5.966,0,0,1,6,7a6.083,6.083,0,0,1,6-6h1V7.57A5.966,5.966,0,0,1,17,6a6.083,6.083,0,0,1,6,6v1H16.43A5.966,5.966,0,0,1,18,17,6.083,6.083,0,0,1,12,23Zm1-9.87v7.74a4,4,0,0,0,0-7.74ZM3.13,13A4.07,4.07,0,0,0,7,16a4.07,4.07,0,0,0,3.87-3Zm10-2h7.74a4,4,0,0,0-7.74,0ZM11,3.13A4.08,4.08,0,0,0,8,7a4.08,4.08,0,0,0,3,3.87Z" transform="translate(-1 -1)"/>
                        </svg>
                        <?php esc_html_e( 'Getting Started', 'blossom-floral' ); ?>
                    </a>
                </li>
				<li>
                    <a id="support" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <defs><style>.a{fill:#354052;}</style></defs>
                            <path class="a" d="M11,18h2V16H11ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20ZM12,6a4,4,0,0,0-4,4h2a2,2,0,0,1,4,0c0,2-3,1.75-3,5h2c0-2.25,3-2.5,3-5A4,4,0,0,0,12,6Z" transform="translate(-2 -2)"/>
                        </svg>
                        <?php esc_html_e( 'FAQ\'s &amp; Support', 'blossom-floral' ); ?>
                    </a>
                </li>
				<li>
                    <a id="free-pro-panel" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.297 20">
                            <defs><style>.a{fill:#354052;}</style></defs>
                            <path class="a" d="M19.384,17.534V13.75L14,19.155l5.384,5.405V20.777H31.3V17.534Zm6.53,9.189H14v3.243H25.914V33.75L31.3,28.345l-5.384-5.405Z" transform="translate(-14 -13.75)"/>
                        </svg>
                        <?php esc_html_e( 'Free Vs Pro', 'blossom-floral' ); ?>
                    </a>
                </li>
                <li data-id="themes" class="ajax">
                    <a id="themeclub" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.558 24">
                            <defs><style>.a{fill:#aec2b1;}.b{fill:#586c51;}.c{fill:#f78f91;}.d{fill:#fff;}</style></defs>
                            <g transform="translate(-4.284)"><g transform="translate(4.284 0.975)"><path class="a" d="M11.795,3.55A4.144,4.144,0,0,1,5.571,9.023C4.071,7.3,4.3,1.3,4.3,1.3S10.295,1.825,11.795,3.55Z" transform="translate(-4.284 -1.3)"/><g transform="translate(1.512 1.725)"><path class="b" d="M6.3,3.6c.75.75,1.5,1.575,2.25,2.4s1.425,1.65,2.175,2.475c.675.825,1.425,1.65,2.1,2.549.675.825,1.35,1.725,2.025,2.624-.75-.75-1.5-1.575-2.25-2.4S11.174,9.6,10.424,8.774c-.675-.825-1.35-1.65-2.1-2.549C7.65,5.4,6.975,4.5,6.3,3.6Z" transform="translate(-6.3 -3.6)"/></g></g><g transform="translate(12.658)"><path class="a" d="M23.736,7.274a4.168,4.168,0,1,1-8.248-1.2C15.863,3.749,20.587,0,20.587,0S24.036,5.024,23.736,7.274Z" transform="translate(-15.451)"/><g transform="translate(2.661 2.325)"><path class="b" d="M21.1,3.1c-.075,1.125-.225,2.175-.375,3.3s-.3,2.175-.45,3.3c-.225,1.05-.375,2.175-.6,3.224S19.225,15.1,19,16.147c.075-1.125.225-2.175.375-3.3s.3-2.175.45-3.3c.225-1.05.375-2.175.6-3.224S20.875,4.225,21.1,3.1Z" transform="translate(-19 -3.1)"/></g></g><g transform="translate(6.059 8.278)"><path class="c" d="M9.372,23.675c.9-.825,5.849-2.475,5.849-2.475S13.2,26,12.371,26.824A2.219,2.219,0,0,1,9.3,26.749,2.15,2.15,0,0,1,9.372,23.675Z" transform="translate(-7.16 -13.581)"/><path class="c" d="M9.087,17.194c1.2.15,5.549,3,5.549,3s-5.024,1.425-6.149,1.275a2.1,2.1,0,0,1-1.8-2.475A2.17,2.17,0,0,1,9.087,17.194Z" transform="translate(-6.651 -12.575)"/><path class="c" d="M14.453,12.629c.6,1.05,1.125,6.224,1.125,6.224s-4.274-3-4.874-4.049a2.272,2.272,0,0,1,.75-3A2.207,2.207,0,0,1,14.453,12.629Z" transform="translate(-7.592 -11.16)"/><path class="c" d="M21.375,13.934c-.45,1.125-4.124,4.8-4.124,4.8s-.375-5.174.075-6.3A2.2,2.2,0,0,1,20.1,11.16,2.055,2.055,0,0,1,21.375,13.934Z" transform="translate(-9.266 -11.04)"/><path class="c" d="M23.6,20.187c-1.125.375-6.3-.225-6.3-.225s3.824-3.524,4.949-3.9a2.109,2.109,0,0,1,2.7,1.425A2.04,2.04,0,0,1,23.6,20.187Z" transform="translate(-9.315 -12.269)"/><path class="c" d="M21.149,26.3c-.975-.675-3.749-5.1-3.749-5.1s5.174.825,6.149,1.425a2.175,2.175,0,0,1,.6,3A2.129,2.129,0,0,1,21.149,26.3Z" transform="translate(-9.34 -13.581)"/><path class="c" d="M15.2,27.374c-.15-1.2,1.575-6.074,1.575-6.074s2.624,4.5,2.7,5.7a2.076,2.076,0,0,1-1.95,2.325A2.214,2.214,0,0,1,15.2,27.374Z" transform="translate(-8.786 -13.606)"/><path class="d" d="M15.29,19.124a2.016,2.016,0,1,1-.075,2.849A2.014,2.014,0,0,1,15.29,19.124Z" transform="translate(-8.655 -12.931)"/></g></g>
                        </svg>
                        <?php esc_html_e( 'Theme Club', 'blossom-floral' ); ?>
                    </a>
                </li>
			</ul>
			<div id="panel" class="panel">
				<?php require get_template_directory() . '/inc/getting-started/tabs/plugins-panel.php'; ?>
				<?php require get_template_directory() . '/inc/getting-started/tabs/help-panel.php'; ?>
				<?php require get_template_directory() . '/inc/getting-started/tabs/support-panel.php'; ?>
				<?php require get_template_directory() . '/inc/getting-started/tabs/free-vs-pro-panel.php'; ?>
                <?php require get_template_directory() . '/inc/getting-started/tabs/link-panel.php'; ?>
				<?php require get_template_directory() . '/inc/getting-started/tabs/theme-club-panel.php'; ?>
			</div><!-- .panel -->
		</div><!-- .panels -->
	</div><!-- .getting-started -->
	<?php
}
endif;

if( ! function_exists( 'blossom_floral_theme_club_list' ) ) :
/**
 * Ajax Callback for Theme Club List
 */
function blossom_floral_theme_club_list(){
    //Getting theme list from the transient if there are any....
    $theme_array = get_transient( 'blossomthemes_feed_transient' );
    
    if( $theme_array ){
        ob_start();
        foreach( $theme_array as $theme_list ){
            $theme_title   = isset( $theme_list['title'] ) ? $theme_list['title'] : '';
            $theme_image   = isset( $theme_list['image'] ) ? $theme_list['image'] : '';
            $theme_content = isset( $theme_list['content'] ) ? $theme_list['content'] : ''; ?>
            <div class="blossom-theme">
                <div class="theme-image">
                    <a class="theme-link" href="<?php echo esc_url( 'https://blossomthemes.com/wordpress-themes/' . $theme_list['slug'] . '/' ); ?>" target="_blank" rel="nofollow">
                        <img src="<?php echo esc_url( $theme_image ); ?>" alt="">
                    </a>
                </div>
                <h3><a href="<?php echo esc_url( 'https://blossomthemes.com/wordpress-themes/' . $theme_list['slug'] . '/' ); ?>"><?php echo esc_html( $theme_title ); ?></a></h3>
                <?php echo wp_kses_post( $theme_content ); ?>
            </div>
            <?php
        }                
    }else{
        // Getting the Themelist from restapi from https://blossomthemes.com
        $themes_list = wp_safe_remote_get( 'https://blossomthemes.com/wp-json/blossom/v1/blossomthemefeed' );

        if ( ! is_wp_error( $themes_list ) && 200 === wp_remote_retrieve_response_code( $themes_list ) ){    
            $body        = wp_remote_retrieve_body( $themes_list ); //getting body 
            $theme_array = json_decode( $body, true ); // making object into array                
            if( $theme_array ){
                set_transient( 'blossomthemes_feed_transient', $theme_array, 3 * MONTH_IN_SECONDS );
                foreach( $theme_array as $theme_list ){
                    $theme_title   = isset( $theme_list['title'] ) ? $theme_list['title'] : '';
                    $theme_image   = isset( $theme_list['image'] ) ? $theme_list['image'] : '';
                    $theme_content = isset( $theme_list['content'] ) ? $theme_list['content'] : ''; ?>
                    <div class="blossom-theme">
                        <div class="theme-image">
                            <a class="theme-link" href="<?php echo esc_url( 'https://blossomthemes.com/wordpress-themes/' . $theme_list['slug'] . '/' ); ?>" target="_blank" rel="nofollow">
                                <img src="<?php echo esc_url( $theme_image ); ?>" alt="">
                            </a>
                        </div>
                        <h3><a href="<?php echo esc_url( 'https://blossomthemes.com/wordpress-themes/' . $theme_list['slug'] . '/' ); ?>"><?php echo esc_html( $theme_title ); ?></a></h3>
                        <?php echo wp_kses_post( $theme_content ); ?>
                    </div>
                    <?php
                }
            }
        }else {
            $themes_link = 'https://blossomthemes.com/theme-club/';
            printf( __( '%1$sThis theme feed seems to be temporarily down. Please check back later, or visit our <a href="%2$s" target="_blank">Themes Club page on BlossomThemes</a>.%3$s', 'blossom-floral' ), '<p>', esc_url( $themes_link ), '</p>' );
        }       
    }

    echo ob_get_clean();

    wp_die();
}
endif;
add_action( 'wp_ajax_theme_club_from_rest', 'blossom_floral_theme_club_list' );