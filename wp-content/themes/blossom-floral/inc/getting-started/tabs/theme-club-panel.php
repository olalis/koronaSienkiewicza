<?php
/**
 * Themeclub Panel.
 *
 * @package Blossom_Floral_Pro
 */
?>
<!-- More themes -->
<div id="themes-panel" class="panel-left">
	<div class="theme-intro">
		<div class="theme-intro-left">
			<p><?php printf( __( 'For just a few bucks more, you can enjoy all our current themes, new theme releases, theme updates, and premium email support. Join the Theme Club at just %1$s$89 for the Yearly Access%2$s and only %1$s$299 for Lifetime Access%2$s.', 'blossom-floral' ), '<strong>', '</strong>' ); ?></p>
		</div>
		<div class="theme-intro-right">
			<a class="button-primary club-button" href="<?php echo esc_url( 'https://blossomthemes.com/theme-club/' ); ?>" target="_blank"><?php esc_html_e( 'Learn about the Theme Club', 'blossom-floral' ); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
		</div>
	</div>
	<span class="theme-loader" style="display: none;">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/images/loader.gif' ); ?>" />
	</span>
	<div class="theme-list"></div><!-- .theme-list -->
</div><!-- .panel-left updates -->