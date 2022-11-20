jQuery(document).ready(function($){ 
	
	$('li.ajax').on( 'click', function(){
		var $this = $(this);
		var id = $this.data("id");

		$.ajax({
			data: { action: 'theme_club_from_rest' },
			type: 'POST',
			url : blossom_floral_getting_started.ajax_url,
			beforeSend:function(){
				$('.inline-list li').addClass('ajax-process');
				$('.theme-loader').show();
				$('.inline-list li').removeClass('current');
				$this.addClass('current');
				$('.panel-left').removeClass('visible');
				$('#'+id+'-panel').addClass('visible');
			},
			success: function(response) {
				$('.theme-list').html(response);				
				$('.inline-list li').removeClass('ajax-process');
				$this.removeClass('ajax');
				$('.theme-loader').hide();
				
			},
		});    
	});

	// Tabs
	$( ".inline-list" ).each( function() {
		$( this ).find( "li" ).each( function(i) {
			$(this).on( 'click', function(){
				$( this ).addClass( "current" ).siblings().removeClass( "current" )
				.parents( "#wpbody" ).find( "div.panel-left" ).removeClass( "visible" ).end().find( 'div.panel-left:eq('+i+')' ).addClass( "visible" );
				return false;
			} );
		} );
	} );

	//faq toggle
	$('.toggle-block:not(.active) .toggle-content').hide();
	$('.toggle-block .toggle-title').on( 'click', function(){
		$(this).parent('.toggle-block').siblings().removeClass('active');
		$(this).parent('.toggle-block').addClass('active');
		$(this).parent('.toggle-block').siblings().children('.toggle-content').slideUp();
		$(this).siblings('.toggle-content').slideDown();
	});
});