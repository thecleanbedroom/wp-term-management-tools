jQuery(
	function($) {
		var actions = [];

		$.each(
			tmtL10n,
			function(key, title) {
				if ( key === 'merge_into_existing' ) {
					return; // added once below
				}
				actions.unshift(
					{
						action: 'bulk_' + key,
						name: title,
						el: $( '#tmt-input-' + key )
					}
				);
			}
		);

		actions.unshift(
			{
				action: 'bulk_merge_into_existing',
				name: tmtL10n['merge_into_existing'] || 'Merge into Existing',
				el: $( '#tmt-input-merge_into_existing' )
			}
		);

		$( '.actions select' )
		.each(
			function() {
				var $select = $( this );
				var $option = $select.find( 'option:first' );

				$.each(
					actions,
					function(i, actionObj) {
						if ($select.find('option[value="' + actionObj.action + '"]').length === 0) {
							$option.after( $( '<option>', {value: actionObj.action, html: actionObj.name} ) );
						}
					}
				);
			}
		)
		.change(
			function() {
				var $select = $( this );

				$.each(
					actions,
					function(i, actionObj) {
						if ( $select.val() === actionObj.action ) {
							actionObj.el
							.insertAfter( $select )
							.css( 'display', 'inline' )
							.find( ':input' ).focus();
						} else {
							actionObj.el
							.css( 'display', 'none' );
						}
					}
				);
			}
		);
	}
);

