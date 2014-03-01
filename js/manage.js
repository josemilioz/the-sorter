jQuery(document).ready(function($){	


	$( ".areas-blocks" ).disableSelection();

	$( ".areas-blocks" ).sortable({
		placeholder: "ui-state-highlight",
		revert: true,
		update: function(){ reorder_items(); }
	});

	reorder_items = function(){
		var itemset = [];
		
		$.each( $( ".areas-blocks" ), function( a, b ){
			$.each( $( "#" + b.id + " .item-dragger" ), function( c, d ){
				var next = '"' + $( "#" + d.id + ' input[name*="item_id_"]' ).val() + '": ';
				var new_order = c + 1;
				next += '"' + new_order + '"';
				itemset.push( next );
				$( "#" + d.id + ' .order' ).html( new_order );
			});
		});
		var to_send = {
			items: $.parseJSON( "{ " +  itemset.join(", ") + " }" ),
			action: "reorder_items"
		};
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			async: false,
			data: to_send
		}).responseText;
	};

	$( ".item-dragger .tools .delete" ).click(function(e){
		if( confirm( $( this ).data( 'confirm' ) ) )
		{
			return true;
		}
		
		return false;
	});
	
	reorder_items();
});