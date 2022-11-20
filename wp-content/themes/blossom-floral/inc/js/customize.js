jQuery(document).ready(function($) {
    /* Move widgets to frontpage settings panel */
    wp.customize.section( 'sidebar-widgets-featured' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-featured' ).priority( '20' );
    wp.customize.section( 'sidebar-widgets-about' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-about' ).priority( '30' );

    //Scroll to home page section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    });

    $( 'input[name=blossom-floral-flush-local-fonts-button]' ).on( 'click', function( e ) {
        var data = {
            wp_customize: 'on',
            action: 'blossom_floral_flush_fonts_folder',
            nonce: blossom_floral_cdata.flushFonts
        };  
        $( 'input[name=blossom-floral-flush-local-fonts-button]' ).attr('disabled', 'disabled');

        $.post( ajaxurl, data, function ( response ) {
            if ( response && response.success ) {
                $( 'input[name=blossom-floral-flush-local-fonts-button]' ).val( 'Successfully Flushed' );
            } else {
                $( 'input[name=blossom-floral-flush-local-fonts-button]' ).val( 'Failed, Reload Page and Try Again' );
            }
        });
    });

    function scrollToSection( section_id ){
        var preview_section_id = "banner_section";

        var $contents = jQuery('#customize-preview iframe').contents();

        switch( section_id ) {

            case 'accordion-section-header_settings':
            preview_section_id = "masthead";
            break;

            case 'accordion-section-header_image':
            preview_section_id = "banner-section";
            break;

            case 'accordion-section-sidebar-widgets-featured':
            preview_section_id = "featured_area";
            break;

            case 'accordion-section-sidebar-widgets-about':
            preview_section_id = "about_section";
            break;

            case 'accordion-section-blog_settings':
            preview_section_id = "content";
            break;

            case 'accordion-section-shop_settings':
            preview_section_id = "product_section";
            break;

            case 'accordion-section-newsletter_settings':
            preview_section_id = "newsletter_section";
            break;

        }

        if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
            $contents.find("html, body").animate({
            scrollTop: $contents.find( "#" + preview_section_id ).offset().top
            }, 1000);
        }
    }
    
});

( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['blossom-floral-pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );