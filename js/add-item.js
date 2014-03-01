jQuery(function($){	
	
	load_posts = function( post_type )
	{
		$( "#posts option" ).remove();
		
		$( ".posts-alert" ).slideUp();
		$( "#post_text" ).val( '' );
		$( "#posts" ).val( '' );
		
		var data = {
			action: 'deliver_posts_list',
			post_type : post_type
		};

		var answer = $.ajax({
			url: ajaxurl,
			async: false,
			method: "POST",
			data: data
		}).responseText;

		if( answer != "0" )
		{
			$( ".posts-alert" ).slideUp();
			$.each( $.parseJSON( answer ), function( i, v ){
				$( "<option />" ).val( i ).text( v ).appendTo( "select#posts" );
			});
		}
		else
		{
			$( ".posts-alert" ).slideDown();
		}	
	}
	
	load_values = function(){
		var values = [];

		$( "select#posts option" ).each( function( i, value ) {
			if ( i >= 0 ) values[i] = $( value ).text();
		});
		
		$( ".ui-autocomplete" ).addClass( 'gradient' );

		$( "input#post_text" ).autocomplete({
			source: values,
			minLength: 0,
			select: function( event, ui ){
				var option = $( "select#posts option" ).filter( function( index ){
					return $( this ).text() == ui.item.label;
				}).val();
				
				$( "select#posts" ).val( option ); // Save the option 2 times or create_slide() won't recognize it.
				
				// SHOW SUBMIT BUTTON WHEN CHOOSING A POST
				$( "#create-item" ).slideDown();
			}
		});
	};
	
	$( "#post_button" ).click( function(){
		$( "#post_text" ).autocomplete( "search", "" );
		$( "#post_text" ).focus();
	});
	
	$( "#post_text" ).click( function(){
		$( "#post_text" ).select();
		$( "#post_text" ).autocomplete( "search", "" );
		$( "#post_text" ).focus();
	});
	
	$( "input[name=post_type]" ).change( function(){
		$( ".hidden" ).slideUp();
		load_posts( $( this ).val() );
		load_values();
		$( "#pick-post" ).slideDown();
	});
	
});